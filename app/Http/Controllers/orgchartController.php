<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
class orgchartController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        // dd($employees);
        return view('organization-chart.index', compact('employees'));
    }
}
