<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Competencies;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Indicator;
use App\Models\Performance_Type;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('Manage Indicator')) {
            $user = \Auth::user();
            if ($user->type == 'employee') {
                $employee = Employee::where('user_id', $user->id)->first();

                $indicators = Indicator::where('created_by', '=', $user->creatorId())->where('branch', $employee->branch_id)->where('department', $employee->department_id)->where('designation', $employee->designation_id)->where('first_month', 1)->get();
                $yearIndicators = Indicator::where('created_by', '=', $user->creatorId())->where('branch', $employee->branch_id)->where('department', $employee->department_id)->where('designation', $employee->designation_id)->where('year', 1)->get();
                $monthIndicators = Indicator::where('created_by', '=', $user->creatorId())->where('branch', $employee->branch_id)->where('department', $employee->department_id)->where('designation', $employee->designation_id)->where('six_month', 1)->get();
            } else {
                $indicators = Indicator::where('created_by', '=', $user->creatorId())->with(['branches', 'departments', 'designations', 'user'])->where('first_month', 1)->get();
                $yearIndicators = Indicator::where('created_by', '=', $user->creatorId())->where('year', 1)->get();
                $monthIndicators = Indicator::where('created_by', '=', $user->creatorId())->where('six_month', 1)->get();
            }
            // dd($monthIndicators);
            return view('indicator.index', compact('indicators', 'yearIndicators', 'monthIndicators'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('Create Indicator')) {
            $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
            $brances     = Branch::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $brances->prepend('Select Branch', '');
            $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments->prepend('Select Department', '');
            $degisnation = Designation::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            //get the indicator data from the database

            return view('indicator.create', compact('performance_types', 'brances', 'departments', 'degisnation'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Indicator')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',                   
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }


            $indicator = new Indicator();

            if ($request->has('first_month') && !empty($request->first_month)) {
                $indicator->first_month = $request->first_month;
            } else {
                $indicator->first_month = 0; 
            }
            
            if ($request->has('six_month') && !empty($request->six_month)) {
                $indicator->six_month = $request->six_month;
            } else {
                $indicator->six_month = 0; 
            }
            
            if ($request->has('year') && !empty($request->year)) {
                $indicator->year = $request->year;
            } else {
                $indicator->year = 0; 
            }
            $title = str_replace(' ', '_', $request->title);
            $indicator->title = $title;
            $indicator->not_observed = $request->not_observed ?? 0;
            $indicator->not_applicable = $request->not_applicable ?? 0;
            $indicator->above_average = $request->above_average ?? 0;
            $indicator->average = $request->average ?? 0;
            $indicator->unsatisfactory = $request->unsatisfactory ?? 0;
            
            $indicator->save();
            
            if (\Auth::user()->type == 'company') {
                $indicator->created_user = \Auth::user()->creatorId();
            } else {
                $indicator->created_user = \Auth::user()->id;
            }

            $indicator->created_by = \Auth::user()->creatorId();
            $indicator->save();

            return redirect()->route('indicator.index')->with('success', __('Indicator successfully created.'));
        }
    }

    public function show(Indicator $indicator)
    {
        $ratings = json_decode($indicator->rating, true);
        $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
        // $technicals      = Competencies::where('created_by', \Auth::user()->creatorId())->where('type', 'technical')->get();
        // $organizationals = Competencies::where('created_by', \Auth::user()->creatorId())->where('type', 'organizational')->get();
        // $behaviourals = Competencies::where('created_by', \Auth::user()->creatorId())->where('type', 'behavioural')->get();
        return view('indicator.show', compact('indicator', 'ratings', 'performance_types'));
    }


    public function edit(Request $request, Indicator $indicator)
    {
        if (\Auth::user()->can('Edit Indicator')) {
        
            $indicator = Indicator::find($request->id);
            return view('indicator.edit', compact('indicator'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request)
{
    if (\Auth::user()->can('Edit Indicator')) {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $indicator = Indicator::findOrFail($request->id);
        

        $title = str_replace(' ', '_', $request->title);
        if ($request->has('first_month') && !empty($request->first_month)) {
            $indicator->first_month = $request->first_month;
        } else {
            $indicator->first_month = 0; 
        }
        
        if ($request->has('six_month') && !empty($request->six_month)) {
            $indicator->six_month = $request->six_month;
        } else {
            $indicator->six_month = 0; 
        }
        
        if ($request->has('year') && !empty($request->year)) {
            $indicator->year = $request->year;
        } else {
            $indicator->year = 0; 
        }
        $indicator->update([
          
        $title = str_replace(' ', '_', $request->title),
        $indicator->title = $title,
        $indicator->not_observed = $request->not_observed ?? 0,
        $indicator->not_applicable = $request->not_applicable ?? 0,
        $indicator->above_average = $request->above_average ?? 0,
        // $indicator->average = $request->average ?? 0,
        $indicator->unsatisfactory = $request->unsatisfactory ?? 0,
        ]);

        return redirect()->route('indicator.index')->with('success', __('Indicator successfully updated.'));
    }
}




    public function destroy(Request $request, Indicator $indicator)
    {
        if (\Auth::user()->can('Delete Indicator')) {
            if ($indicator->created_by == \Auth::user()->creatorId()) {
                $indicator->delete();

                return redirect()->route('indicator.index')->with('success', __('Indicator successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function year()
    {
        if (\Auth::user()->can('Manage Indicator')) {
            $user = \Auth::user();
            if ($user->type == 'employee') {
                $employee = Employee::where('user_id', $user->id)->first();

                $indicators = Indicator::where('created_by', '=', $user->creatorId())->where('branch', $employee->branch_id)->where('department', $employee->department_id)->where('designation', $employee->designation_id)->get();
            } else {
                $indicators = Indicator::where('created_by', '=', $user->creatorId())->with(['branches', 'departments', 'designations', 'user'])->get();
            }

            return view('indicator.year', compact('indicators'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function yearStore(Request $request)
    {
        if (\Auth::user()->can('Create Indicator')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',    
                    'description' => 'required',             
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $indicator = new Indicator();
            $title = str_replace(' ', '_', $request->title);
            $indicator->title = $title;
            $indicator->year = 1;
            $indicator->description = $request->description;
            $indicator->unsatisfactory = $request->unsatisfactory;
            $indicator->full_satisfactory = $request->full_satisfactory;
            $indicator->excellent = $request->excellent;
            $indicator->outstanding = $request->outstanding;
            $indicator->less_than_satisfactory = $request->less_than_satisfactory;
            $indicator->unsatisfactory_description = $request->unsatisfactory_description;
            $indicator->full_satisfactory_description = $request->full_satisfactory_description;
            $indicator->excellent_description = $request->excellent_description;
            $indicator->outstanding_description = $request->outstanding_description;
            $indicator->less_than_satisfactory_description = $request->less_than_satisfactory_description;
            $indicator->save();
            
            if (\Auth::user()->type == 'company') {
                $indicator->created_user = \Auth::user()->creatorId();
            } else {
                $indicator->created_user = \Auth::user()->id;
            }

            $indicator->created_by = \Auth::user()->creatorId();
            $indicator->save();

            return redirect()->route('indicator.index')->with('success', __('Indicator successfully created.'));
        }
    }
    public function edityear(Request $request, Indicator $indicator)
    {

        if (\Auth::user()->can('Edit Indicator')) {
            $indicator = Indicator::find($request->id);
            return view('indicator.yearEdit', compact('indicator'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function yearUpdate(Request $request)
    {
        if (\Auth::user()->can('Edit Indicator')) {
            $validator = \Validator::make($request->all(), [
                'title' => 'required',
            ]);
    
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $indicator = Indicator::findOrFail($request->id);
    
            
            $indicator->update([
                $title = str_replace(' ', '_', $request->title),
                $indicator->title = $title,
                $indicator->description = $request->description,
                $indicator->unsatisfactory = $request->unsatisfactory,
                $indicator->full_satisfactory = $request->full_satisfactory,
                $indicator->excellent = $request->excellent,
                $indicator->outstanding = $request->outstanding,
                $indicator->less_than_satisfactory = $request->less_than_satisfactory,
                $indicator->unsatisfactory_description = $request->unsatisfactory_description,
                $indicator->full_satisfactory_description = $request->full_satisfactory_description,
                $indicator->excellent_description = $request->excellent_description,
                $indicator->outstanding_description = $request->outstanding_description,
                $indicator->less_than_satisfactory_description = $request->less_than_satisfactory_description,
                $indicator->save(),
            ]);
    
            return redirect()->route('indicator.index')->with('success', __('Indicator successfully updated.'));
        }
    }

    public function month()
    {
        if (\Auth::user()->can('Manage Indicator')) {
            $user = \Auth::user();
            if ($user->type == 'employee') {
                $employee = Employee::where('user_id', $user->id)->first();

                $indicators = Indicator::where('created_by', '=', $user->creatorId())->where('branch', $employee->branch_id)->where('department', $employee->department_id)->where('designation', $employee->designation_id)->get();
            } else {
                $indicators = Indicator::where('created_by', '=', $user->creatorId())->with(['branches', 'departments', 'designations', 'user'])->get();
            }

            return view('indicator.month', compact('indicators'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function monthStore(Request $request)
    {
        if (\Auth::user()->can('Create Indicator')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',              
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $indicator = new Indicator();
            $title = str_replace(' ', '_', $request->title);
            $indicator->title = $title;
            $indicator->six_month = 1;
            $indicator->very_satisfactory = $request->very_satisfactory;
            $indicator->satisfactory = $request->satisfactory;
            $indicator->neutral = $request->neutral;
            $indicator->dissatisfactory = $request->dissatisfactory;
            $indicator->very_dissatisfactory = $request->very_dissatisfactory;
            $indicator->very_satisfactory_description = $request->very_satisfactory_description;
            $indicator->satisfactory_description = $request->satisfactory_description;
            $indicator->neutral_description = $request->neutral_description;
            $indicator->dissatisfactory_description = $request->dissatisfactory_description;
            $indicator->very_dissatisfactory_description = $request->very_dissatisfactory_description;
            $indicator->save();
            
            if (\Auth::user()->type == 'company') {
                $indicator->created_user = \Auth::user()->creatorId();
            } else {
                $indicator->created_user = \Auth::user()->id;
            }

            $indicator->created_by = \Auth::user()->creatorId();
            $indicator->save();

            return redirect()->route('indicator.index')->with('success', __('Indicator successfully created.'));
        }
    }
    public function editmonth(Request $request, Indicator $indicator)
    {

        if (\Auth::user()->can('Edit Indicator')) {
            $indicator = Indicator::find($request->id);
            return view('indicator.monthEdit', compact('indicator'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function monthUpdate(Request $request)
    {
        if (\Auth::user()->can('Edit Indicator')) {
            $validator = \Validator::make($request->all(), [
                'title' => 'required',
            ]);
    
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $indicator = Indicator::findOrFail($request->id);
    
            
            $indicator->update([
                $title = str_replace(' ', '_', $request->title),
                $indicator->title = $title,
                $indicator->very_satisfactory = $request->very_satisfactory,
                $indicator->satisfactory = $request->satisfactory,
                $indicator->neutral = $request->neutral,
                $indicator->dissatisfactory = $request->dissatisfactory,
                $indicator->very_dissatisfactory = $request->very_dissatisfactory,
                $indicator->very_satisfactory_description = $request->very_satisfactory_description,
                $indicator->satisfactory_description = $request->satisfactory_description,
                $indicator->neutral_description = $request->neutral_description,
                $indicator->dissatisfactory_description = $request->dissatisfactory_description,
                $indicator->very_dissatisfactory_description = $request->very_dissatisfactory_description,
                $indicator->save(),
            ]);
    
            return redirect()->route('indicator.index')->with('success', __('Indicator successfully updated.'));
        }
    }
    
    













}
