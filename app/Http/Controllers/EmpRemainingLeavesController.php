<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manage_leaves;
use Illuminate\Support\Facades\Crypt;

class EmpRemainingLeavesController extends Controller
{
    public function index()
    {
        $creatorID = \Auth::user()->creatorId();
        $manageLeaves = Manage_leaves::all();
        return view('empremainingleaves.index', compact( 'manageLeaves'));
    }

    public function manageEmpLeave($id)
    {
        $id = Crypt::decrypt($id);
        if (\Auth::user()->can('Edit Employee')) {
            $employee     = Employee::find($id);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);
            $manage_leaves = Manage_leaves::where('employee_id', '=', $id)->first();

            return view('employee.manage', compact('employee', 'employeesId',  'manage_leaves'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function addleaves(Request $request)
    {
        $employee_id = $request->employee_id;
        $earn_leaves = $request->earn_leaves;
        $sick_leaves = $request->sick_leaves;
        $creatorID = \Auth::user()->creatorId();
        $title = $request->remarks;
        $total_leaves = $earn_leaves + $sick_leaves;
        $check = Manage_leaves::where('employee_id', '=', $employee_id)->first();

        if (!empty($check)) {
            Manage_leaves::where('employee_id', $employee_id)->update([
                'earn_type' => $earn_leaves,
                'sick_type' => $sick_leaves,
                'total_earn_leave' => $earn_leaves,
                'total_sick_leave' => $sick_leaves,
                'total_leaves' => $total_leaves,
                'title' => $title,
                'created_by' => $creatorID,
            ]);

            return redirect()->back()->with('success', __('Leaves updated successfully'));
        } else {
            Manage_leaves::create([
                'employee_id' => $employee_id,
                'earn_type' => $earn_leaves,
                'sick_type' => $sick_leaves,
                'total_leaves' => $total_leaves,
                'title' => $title,
                'created_by' => $creatorID,
            ]);

            return redirect()->back()->with('success', __('Leaves added successfully'));
        }
    }
}
