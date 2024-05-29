<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Leave;
use App\Models\Utility;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Exports\LeaveExport;
use Illuminate\Http\Request;
use App\Mail\LeaveActionSend;
use App\Models\Designation;
use Illuminate\Support\Carbon;
use App\Models\Leave as LocalLeave;
use App\Models\Manage_leaves;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\GoogleCalendar\Event as GoogleEvent;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\LocalList;

class LeaveController extends Controller
{


    private function removeNumber($string)
    {
        return preg_replace('/[-0-9]+/', '', $string);
    }
    public function convertDateRange($dateRange)
    {
        $dates = explode(' - ', $dateRange);

        $startDate = $this->convertDate($dates[0]);
        $endDate = $this->convertDate($dates[1]);

        return [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }

    private function convertDate($dateString)
    {
        preg_match('/[a-zA-Z]{3}, (\d{4})/', $dateString, $matches);
        $year = $matches[1];

        preg_match('/(\d{1,2}) ([a-zA-Z]{3})/', $dateString, $matches);
        $month = $matches[2];
        $day = $matches[1];

        $date = Carbon::createFromFormat('M d Y', "$month $day $year");

        return $date->format('Y-m-d');
    }

    public function index()
    {
        $date = Carbon::now();
        $infos = Leave::orderByRaw("FIELD(status, 'rejected', 'pending', 'approved')")
            ->simplePaginate();
        $empleave  = Employee::paginate(10);
        $TeamLeadEmpLeaves = [];
        if (Auth::user()->employee) {
            $loggedInUserId = Auth::user()->id;
            $totalTeamMembers = Employee::where('team_lead', $loggedInUserId)->get()->pluck('id');
            $TeamLeadEmpLeaves = Leave::whereIn('employee_id', $totalTeamMembers)->orderByRaw("FIELD(status, 'pending', 'approved', 'Delete', 'reject')")->orderBy('created_at', 'DESC')->get();
        }

        if (\Auth::user()->can('Manage Leave')) {
            $empleave  = Employee::all();
            $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->get();
            if (\Auth::user()->type == 'employee') {
                $user     = \Auth::user();
                $employee = Employee::where('user_id', '=', $user->id)->first();
                $leaves   = Leave::where('employee_id', '=', $employee->id)->orderByRaw("FIELD(status, 'pending', 'approved', 'Delete', 'reject')")->orderBy('created_at', 'DESC')->get();
            } else {
                $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->orderByRaw("FIELD(status, 'pending', 'approved', 'Delete','reject')")->orderBy('created_at', 'DESC')->get();
            }

            return view('leave.index', compact('empleave', 'TeamLeadEmpLeaves', 'leaves'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function LeaveCreate()
    {
        if (\Auth::user()->can('Create Leave')) {
            if (Auth::user()->type == 'employee') {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->first();
            } else {
                $employees = Employee::select('id', 'name')->get();
            }
            return view('leave.companycreateleaves', compact('employees'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function HRMleaveStore(Request $request)
    {

        $employee = Employee::where('id', $request->employee_id)->first();
        $lead = Employee::where('id', $employee->team_lead)->first();

        $hr = User::select('email')->where('type', 'hr')->first();

        if (\Auth::user()->can('Create Leave')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required',
                    'leave_type_id' => 'required',
                    'daterange' => 'required',
                    'leave_reason' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $type = $this->removeNumber($request->leave_type_id);
            $dates = $this->convertDateRange($request->daterange);

            if ($type  == 'earn_type') {
                $leave_type_id = 1;
            } elseif ($type  == 'sick_type') {
                $leave_type_id = 2;
            }


            $leave_type = LeaveType::find($leave_type_id);


            $manageLeaves = Manage_leaves::where('employee_id', $request->employee_id)->first();
            if ($request->leave_type_id == 'earn_type') {

                if ($request->days > $manageLeaves->earn_type) {
                    return redirect()->back()->with('error', __('You are not eligible for leave.'));
                }
            } elseif ($request->leave_type_id == 'sick_type') {
                if ($request->days > $manageLeaves->sick_type) {
                    return redirect()->back()->with('error', __('You are not eligible for leave.'));
                }
            }



            if ($manageLeaves->total_leaves >= $request->days) {
                $leave    = new LocalLeave();
                if (\Auth::user()->type == "employee") {
                    $leave->employee_id = $request->employee_id;
                } else {
                    $leave->employee_id = $request->employee_id;
                }
                $leave->leave_type_id    = $leave_type_id;
                $leave->applied_on       = date('Y-m-d');
                $leave->start_date       = $dates['startDate'];
                if ($request->leave == '1st_half' || $request->leave == '2nd_half') {
                    $leave->end_date         = 'no end date';
                } else {
                    $leave->end_date         = $dates['endDate'];
                }
                $leave->total_leave_days = $request->days;
                $leave->leave_reason     = $request->leave_reason;
                $leave->remark           = $request->remark;
                $leave->status           = 'Approved';

                $leave->leave       = $request->leave;
                $leave->created_by       = \Auth::user()->creatorId();

                $leave->save();
                if ($leave->save()) {
                    $manageLeaves->decrement($type, $request->days);
                    $manageLeaves->decrement('total_leaves', $request->days);
                }
                $uArr = [
                    'leave_status_name' => $employee->name,
                    'leave_purpose' => 'Pending',
                    'leave_reason' => $leave->leave_reason,
                    'leave_start_date' => $dates['startDate'],
                    'leave_end_date' => $dates['endDate'],
                    'total_leave_days' => $request->days,
                ];
                $user = User::where('id', $employee->user_id)->first();
                if(empty($lead)){
                    $team_lead = $hr->email;
                }
                else{
                    $team_lead = $lead->email;
                }
                if ($request->days >= 2) {
                    $designation_id = Designation::where('name', 'LIKE', 'Manager')->pluck('id');
                    $manager = Employee::where('designation_id', $designation_id)->first();
                    Utility::sendEmailTemplate('leave_apply', [$user->email, $hr->email, $team_lead, $manager->email], $uArr);
                } else {
                    Utility::sendEmailTemplate('leave_apply', [$user->email, $hr->email, $team_lead], $uArr);
                }

                return redirect()->route('leave.index')->with('success', __('Leave  successfully created.'));
            } else {
                return redirect()->back()->with('error', __('Leave type ' . $leave_type->name . ' is provide maximum ' . $leave_type->days . "  days please make sure your selected days is under " . $leave_type->days . ' days.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('Create Leave')) {
            if (Auth::user()->type == 'employee') {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->first();
            } else {
                $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            }

            $leavetypes = Manage_leaves::where('employee_id', '=',  $employees->id)->get();
            return view('leave.create', compact('employees', 'leavetypes'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $employee = Employee::where('id', $request->employee_id)->first();
        $lead = User::where('id', $employee->team_lead)->first();
        $hr = User::select('email')->where('type', 'hr')->first();
        $company = User::select('email')->where('type', 'company')->first();

        if (\Auth::user()->can('Create Leave')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required',
                    'leave_type_id' => 'required',
                    'daterange' => 'required',
                    'leave_reason' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $type = $this->removeNumber($request->leave_type_id);
            $dates = $this->convertDateRange($request->daterange);

            if ($type  == 'earn_type') {
                $leave_type_id = 1;
            } elseif ($type  == 'sick_type') {
                $leave_type_id = 2;
            }


            $leave_type = LeaveType::find($leave_type_id);

            if (\Auth::user()->type == 'employee') {
                $manageLeaves = Manage_leaves::where('employee_id', $request->employee_id)->first();
                if ($request->leave_type_id == 'earn_type') {

                    if ($request->days > $manageLeaves->earn_type) {
                        return redirect()->back()->with('error', __('You are not eligible for leave.'));
                    }
                } elseif ($request->leave_type_id == 'sick_type') {
                    if ($request->days > $manageLeaves->sick_type) {
                        return redirect()->back()->with('error', __('You are not eligible for leave.'));
                    }
                }
            }



            if ($manageLeaves->total_leaves >= $request->days) {
                $leave    = new LocalLeave();
                if (\Auth::user()->type == "employee") {
                    $leave->employee_id = $request->employee_id;
                } else {
                    $leave->employee_id = $request->employee_id;
                }
                $leave->leave_type_id    = $leave_type_id;
                $leave->applied_on       = date('Y-m-d');
                $leave->start_date       = $dates['startDate'];
                if ($request->leave == '1st_half' || $request->leave == '2nd_half') {
                    $leave->end_date         = 'no end date';
                } else {
                    $leave->end_date         = $dates['endDate'];
                }

                $leave->total_leave_days = $request->days;
                $leave->leave_reason     = $request->leave_reason;
                $leave->remark           = $request->remark;
                $leave->status           = 'Pending';

                $leave->leave       = $request->leave;
                $leave->created_by       = \Auth::user()->creatorId();

                $leave->save();
                if ($leave->save()) {
                    $manageLeaves->decrement($type, $request->days);
                    $manageLeaves->decrement('total_leaves', $request->days);
                }
                // if ($request->days == 0.5) {
                //     $total_leave_days = $request->leave;
                // }
                $uArr = [
                    'leave_status_name' => $employee->name,
                    'leave_purpose' => 'Pending',
                    'leave_reason' => $leave->leave_reason,
                    'leave_start_date' => $dates['startDate'],
                    'leave_end_date' => $dates['endDate'],
                    'total_leave_days' => $request->days,
                ];
                $user = User::where('id', $employee->user_id)->first();
                if(empty($lead)){
                    $team_lead = $hr->email;
                }
                else{
                    $team_lead = $lead->email;
                }
                if ($request->days >= 2) {
                    $designation_id = Designation::where('name', 'LIKE', 'Manager')->pluck('id');
                    $manager = Employee::where('designation_id', $designation_id)->first();
                    Utility::sendEmailTemplate('leave_apply', [$user->email, $hr->email, $team_lead, $company->email], $uArr);
                } else {
                    Utility::sendEmailTemplate('leave_apply', [$user->email, $hr->email, $team_lead], $uArr);
                }

                return redirect()->route('leave.index')->with('success', __('Leave  successfully created.'));
            } else {
                return redirect()->back()->with('error', __('Leave type ' . $leave_type->name . ' is provide maximum ' . $leave_type->days . "  days please make sure your selected days is under " . $leave_type->days . ' days.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(LocalLeave $leave)
    {
        return redirect()->route('leave.index');
    }

    public function edit(LocalLeave $leave)
    {
        if (\Auth::user()->can('Edit Leave')) {
            if ($leave->created_by == \Auth::user()->creatorId()) {
                if (Auth::user()->type == 'employee') {
                    $employees = Employee::where('employee_id', '=', \Auth::user()->creatorId())->first();;
                } else {
                    $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                }
                $leavetypes      = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();
                return view('leave.edit', compact('leave', 'employees', 'leavetypes'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $leave)
    {

        $leave = LocalLeave::find($leave);
        if (\Auth::user()->can('Edit Leave')) {
            if ($leave->created_by == Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'employee_id' => 'required',
                        'leave_type_id' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'leave_reason' => 'required',
                        'remark' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                $leave_type = LeaveType::find($request->leave_type_id);
                $employee = Employee::where('employee_id', '=', \Auth::user()->creatorId())->first();;

                $startDate = new \DateTime($request->start_date);
                $endDate = new \DateTime($request->end_date);
                $endDate->add(new \DateInterval('P1D'));
                // $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;

                $date = Utility::AnnualLeaveCycle();

                if (\Auth::user()->type == 'employee') {
                    // Leave day
                    $leaves_used   = LocalLeave::whereNotIn('id', [$leave->id])->where('employee_id', '=', $employee->id)->where('leave_type_id', $leave_type->id)->where('status', 'Approved')->whereBetween('created_at', [$date['start_date'], $date['end_date']])->sum('total_leave_days');

                    $leaves_pending  = LocalLeave::whereNotIn('id', [$leave->id])->where('employee_id', '=', $employee->id)->where('leave_type_id', $leave_type->id)->where('status', 'Pending')->whereBetween('created_at', [$date['start_date'], $date['end_date']])->sum('total_leave_days');
                } else {
                    // Leave day
                    $leaves_used   = LocalLeave::whereNotIn('id', [$leave->id])->where('employee_id', '=', $request->employee_id)->where('leave_type_id', $leave_type->id)->where('status', 'Approved')->whereBetween('created_at', [$date['start_date'], $date['end_date']])->sum('total_leave_days');

                    $leaves_pending  = LocalLeave::whereNotIn('id', [$leave->id])->where('employee_id', '=', $request->employee_id)->where('leave_type_id', $leave_type->id)->where('status', 'Pending')->whereBetween('created_at', [$date['start_date'], $date['end_date']])->sum('total_leave_days');
                }

                $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;

                $return = $leave_type->days - $leaves_used;
                if ($total_leave_days > $return) {
                    return redirect()->back()->with('error', __('You are not eligible for leave.'));
                }

                if (!empty($leaves_pending) && $leaves_pending + $total_leave_days > $return) {
                    return redirect()->back()->with('error', __('Multiple leave entry is pending.'));
                }

                if ($leave_type->days >= $total_leave_days) {
                    if (\Auth::user()->type == 'employee') {
                        $leave->employee_id = $employee->id;
                    } else {
                        $leave->employee_id      = $request->employee_id;
                    }
                    $leave->leave_type_id    = $request->leave_type_id;
                    $leave->start_date       = $request->start_date;
                    $leave->end_date         = $request->end_date;
                    $leave->total_leave_days = $total_leave_days;
                    $leave->leave_reason     = $request->leave_reason;
                    $leave->remark           = $request->remark;

                    $leave->save();

                    return redirect()->route('leave.index')->with('success', __('Leave successfully updated.'));
                } else {
                    return redirect()->back()->with('error', __('Leave type ' . $leave_type->name . ' is provide maximum ' . $leave_type->days . "  days please make sure your selected days is under " . $leave_type->days . ' days.'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(LocalLeave $leave)
    {
        if ($leave->leave_type_id == 1) {
            $type = 'earn_type';
        } else if ($leave->leave_type_id == 2) {
            $type = 'sick_type';
        }
        if (\Auth::user()->can('Delete Leave')) {
            if ($leave->created_by == \Auth::user()->creatorId()) {
                /// upadate leave leave balance
                $manageLeaves = Manage_leaves::where('employee_id', $leave->employee_id)->first();
                if ($leave->leave == '1st_half' || $leave->leave == '2nd_half') {
                    $manageLeaves->increment($type, 0.5);
                    $manageLeaves->increment('total_leaves', 0.5);
                } else {
                    $manageLeaves->increment($type, $leave->total_leave_days);
                    $manageLeaves->increment('total_leaves', $leave->total_leave_days);
                }

                $leave->delete();
                return redirect()->route('leave.index')->with('success', __('Leave successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function action($id)
    {
        $leave     = LocalLeave::find($id);
        $employee  = Employee::find($leave->employee_id);
        $leavetype = LeaveType::find($leave->leave_type_id);

        return view('leave.action', compact('employee', 'leavetype', 'leave'));
    }

    public function approveByLead(Request $request)
    {
        $leave = LocalLeave::find($request->leave_id);
        $hr = User::select('email')->where('type', 'hr')->first();

        $lead = Employee::getTeamLead($leave->employee_id);
        if (Auth::user()->id == $lead->user_id) {
            if ($request->status == 'Approved') {
                $leave->update(['tl_approve' => 1]);
            } elseif ($request->status == 'Reject') {
                $leave->update(['tl_approve' => 0]);
            }
        }
    }

    public function changeaction(Request $request)
    {
        $user = Auth::user();
        $type = $user->type;

        $leave = LocalLeave::find($request->leave_id);
        $employeeDet = Employee::where('id', $leave->employee_id)->where('created_by', '=', \Auth::user()->creatorId())->first();
        
        if($type != 'employee' && $leave->tl_approve == 0 && $employeeDet->team_lead != 0){
            if($leave->total_leave_days < 2){
                return redirect()->back()->with('error', __('First need to the lead approval.'));
            }
            else{
                return redirect()->back()->with('error', __('You are not allowed to take this action.'));
            }
        }
        $checkStatus = "";
        $tl_approval = $leave->tl_approve;
        $hr_approval = $leave->manager_approve;

        if($type == 'employee'){
            if($leave->total_leave_days < 2){
                $checkStatus = "Approved";
                $tl_approval = 1;
            }
            else{
                $checkStatus = "Approved by Lead";
                $tl_approval = 1;
            }
        }

        else{
            $checkStatus = "Approved";
            $hr_approval = 1;

        }
        if ($request->status == 'Approved') {
            $leave->update(['status' => $checkStatus, 'tl_approve' => $tl_approval, 'manager_approve' => $hr_approval]);
        } elseif ($request->status == 'Reject') {
            $leave->update(['status' => $request->status , 'tl_approve' => 0, 'manager_approve' => 0]);
            if ($leave->leave_type_id == 1) {
                $type = 'earn_type';
            } elseif ($leave->leave_type_id == 2) {
                $type = 'sick_type';
            }
            $manageLeaves = Manage_leaves::where('employee_id', $leave->employee_id)->first();
            if ($leave->leave == '1st_half' || $leave->leave == '2nd_half') {
                $manageLeaves->increment($type, 0.5);
                $manageLeaves->increment('total_leaves', 0.5);
            } else {
                $manageLeaves->increment($type, $leave->total_leave_days);
                $manageLeaves->increment('total_leaves', $leave->total_leave_days);
            }
        }
        $employee = Employee::where('id', $leave->employee_id)->where('created_by', '=', \Auth::user()->creatorId())->first();
        $uArr = [
            'leave_status_name' => $employee->name,
            'leave_purpose' =>   $request->status,
            'leave_reason' => $leave->leave_reason,
            'leave_start_date' => $leave->start_date,
            'leave_end_date' => $leave->end_date,
            'total_leave_days' => $leave->total_leave_days,
        ];
        $user = User::where('id', $employee->user_id)->first();
        $resp = Utility::sendEmailTemplate('leave_reply', [$user->email], $uArr);
        return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

    }

    public function jsoncount(Request $request)
    {
        if ($request->has('employee_id')) {
            $leavetypes = Manage_leaves::where('employee_id', '=', $request->employee_id)->get();

            if (!$leavetypes->isEmpty()) {
                $leavetypes = [
                    ['earn_type' => 'earn_type-' . $leavetypes[0]->earn_type],
                    ['sick_type' => 'sick_type-' . $leavetypes[0]->sick_type]
                ];
            } else {
                $leavetypes = [];
            }
            return response()->json(['leaves' => $leavetypes]);
        } else {
            return response()->json([]);
        }
    }

    public function export(Request $request)
    {
        $name = 'Leave' . date('Y-m-d i:h:s');
        $data = Excel::download(new LeaveExport(), $name . '.xlsx');

        return $data;
    }

    public function calender(Request $request)
    {
        $created_by = Auth::user()->creatorId();
        $Meetings = LocalLeave::where('created_by', $created_by)->get();
        $today_date = date('m');
        $current_month_event = LocalLeave::select('id', 'start_date', 'employee_id', 'created_at')->whereRaw('MONTH(start_date)=' . $today_date)->get();

        $arrMeeting = [];

        foreach ($Meetings as $meeting) {
            $arr['id']        = $meeting['id'];
            $arr['employee_id']     = $meeting['employee_id'];
            // $arr['leave_type_id']     = date('Y-m-d', strtotime($meeting['start_date']));
        }

        $leaves = LocalLeave::where('created_by', '=', \Auth::user()->creatorId())->get();
        if (\Auth::user()->type == 'employee') {
            $user     = \Auth::user();
            $employee = Employee::where('user_id', '=', $user->id)->first();
            $leaves   = LocalLeave::where('employee_id', '=', $employee->id)->get();
        } else {
            $leaves = LocalLeave::where('created_by', '=', \Auth::user()->creatorId())->get();
        }

        return view('leave.calender', compact('leaves'));
    }

    public function get_leave_data(Request $request)
    {
        $arrayJson = [];
        if ($request->get('calender_type') == 'google_calender') {
            $type = 'leave';
            $arrayJson =  Utility::getCalendarData($type);
        } else {
            $data = LocalLeave::get();

            foreach ($data as $val) {
                $end_date = date_create($val->end_date);
                date_add($end_date, date_interval_create_from_date_string("1 days"));
                $arrayJson[] = [
                    "id" => $val->id,
                    "title" => !empty(\Auth::user()->getLeaveType($val->leave_type_id)) ? \Auth::user()->getLeaveType($val->leave_type_id)->title : '',
                    "start" => $val->start_date,
                    "end" => date_format($end_date, "Y-m-d H:i:s"),
                    "className" => $val->color,
                    "textColor" => '#FFF',
                    "allDay" => true,
                    "url" => route('leave.action', $val['id']),
                ];
            }
        }

        return $arrayJson;
    }
}
