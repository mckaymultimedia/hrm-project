<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobDetail;
use Carbon\Carbon;
use App\Models\Employee;

class JobGraphicalDataController extends Controller
{
    public function jobGraphical()
    {
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
    
        $jobDetails = JobDetail::with('user', 'jobProfile')
            ->whereMonth('applied_at', $currentMonth)
            ->get();

        $jobProfiles = Employee::where('department_id', 4)->get();
        $graphData = [];
        foreach ($jobDetails as $detail) {
            $weekNumber = Carbon::parse($detail->applied_at)->weekOfMonth;
            $username = $detail->user->name;
            if (!isset($graphData[$username])) {
                $graphData[$username] = array_fill(0, $currentDate->weekOfMonth, 0);
            }
            $graphData[$username][$weekNumber - 1]++;
        }
    
        return view('job-graphical-data.index', compact('jobProfiles', 'graphData', 'jobDetails'));
    }
    
    
    
    
    public function getJobDetails(Request $request)
    
    {
        $status = (int) $request->status;        
        if($request->month != ""){
            $dateString = date('Y') . '-' . $request->month . '-01';
            $selectedMonth = Carbon::parse($dateString);
            if($request->status != ""){
                $jobDetails = JobDetail::where('user_id', $request->profile_id)
                ->where('status', $status)
                ->whereYear('applied_at', $selectedMonth->year)
                ->whereMonth('applied_at', $selectedMonth->month)
                ->with('user' ,'jobProfile')
                ->get();
            }else{
                $jobDetails = JobDetail::where('user_id', $request->profile_id)
                ->whereYear('applied_at', $selectedMonth->year)
                ->whereMonth('applied_at', $selectedMonth->month)
                ->with('user' ,'jobProfile')
                ->get();
            }
           
        }else{
            if($request->status != ""){
                
                $currentDate = Carbon::now();
                $currentMonth = $currentDate->month;
                $jobDetails = JobDetail::where('user_id', $request->profile_id)
                ->where('status', $status)
                ->with('user' ,'jobProfile')
                ->whereMonth('applied_at', $currentMonth)
                ->get();
        // return response()->json(['jobDetails' => $jobDetails]);

            }else{
                $currentDate = Carbon::now();
                $currentMonth = $currentDate->month;
            $jobDetails = JobDetail::where('user_id', $request->profile_id)->with('user' ,'jobProfile')->whereMonth('applied_at', $currentMonth)->get();
            }

        }
        if($request->month != ""){  
            $currentWeek = $request->month;
        }
        else{
            
            $currentDate = Carbon::now();
            $currentWeek = $currentDate->month;
            // $currentWeek = Carbon::now()->weekOfMonth;
        }
        $graphData = [];
        foreach ($jobDetails as $detail) {
            $weekNumber = Carbon::parse($detail->applied_at)->weekOfMonth;
            $username = $detail->user->name;
            if (!isset($graphData[$username])) {
                $graphData[$username] = array_fill(0, $currentWeek, 0); 
            }
            $graphData[$username][$weekNumber - 1]++;
        }
        if($request->month == "" && $request->profile_id == "" && $request->status != ""){
            $jobDetails = JobDetail::where('status', $status)
                ->with('user' ,'jobProfile')
                ->get();
            $currentWeek = Carbon::now()->weekOfMonth;
            $graphData = [];
            foreach ($jobDetails as $detail) {
                $weekNumber = Carbon::parse($detail->applied_at)->weekOfMonth;
                $username = $detail->user->name;
                if (!isset($graphData[$username])) {
                    $graphData[$username] = array_fill(0, $currentWeek, 0); 
                }
                $graphData[$username][$weekNumber - 1]++;
            }
            return response()->json(['graphData' => $graphData, 'jobDetails' => $jobDetails]);
        }

        return response()->json(['graphData' => $graphData, 'jobDetails' => $jobDetails]);
    }
}
