<?php

namespace App\Http\Controllers;

use App\Models\PerformanceReview;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class PerformanceReviewController extends Controller
{
    public function index()
    {
        $login_id = \Auth::user()->type;
        $users = [];
        if ($login_id == 'hr') {
            $threeMonthsAgo = now()->subMonths(3);
            $sixMonthsAgo = now()->subMonths(6);
            $oneYearAgo = now()->subYear();
            $twoYearsAgo = now()->subYears(2);
            $threeYearsAgo = now()->subYears(3);
    
            $threeMonthsUsers = User::whereDate('created_at', $threeMonthsAgo->toDateString())
                                    ->get()
                                    ->map(function ($user) {
                                        $user['period'] = '3 months';
                                        return $user;
                                    });
    
            $sixMonthsUsers = User::whereDate('created_at', $sixMonthsAgo->toDateString())
                                  ->get()
                                  ->map(function ($user) {
                                      $user['period'] = '6 months';
                                      return $user;
                                  });
    
            $oneYearUsers = User::whereDate('created_at', $oneYearAgo->toDateString())
                                ->get()
                                ->map(function ($user) {
                                    $user['period'] = '1 year';
                                    return $user;
                                });
    
            $twoYearsUsers = User::whereDate('created_at', $twoYearsAgo->toDateString())
                                 ->get()
                                 ->map(function ($user) {
                                     $user['period'] = '2 years';
                                     return $user;
                                 });
    
            $threeYearsUsers = User::whereDate('created_at', $threeYearsAgo->toDateString())
                                   ->get()
                                   ->map(function ($user) {
                                       $user['period'] = '3 years';
                                       return $user;
                                   });
    
            $users = $threeMonthsUsers
                        ->merge($sixMonthsUsers)
                        ->merge($oneYearUsers)
                        ->merge($twoYearsUsers)
                        ->merge($threeYearsUsers);
        }
    
        return response()->json($users);
    }

    public function team()
{
    // Get the ID of the logged-in user
    $login_id = \Auth::user()->id;
    $login_type = \Auth::user()->type;
    $teamLeadExists = false;
    $login_user_id = Employee::where('user_id', $login_id)->pluck('id')->first();
    if($login_type == 'employee'){
        $users = Employee::get();
        foreach ($users as $user) {
            print_r($user->team_lead);
            
            if ($user->team_lead == $login_user_id) {
                $teamLeadExists = true;
                break;
            }
        }
        
        return response()->json(['teamLeadExists' => $teamLeadExists]);

    }
}
    

    // public function status(Request $request)
    // {
    //     $userData = $request->json()->all();
        
    
    //     foreach ($userData['userIds'] as $user) {
    //         // Retrieve the user by ID
    //         $userId = $user['id'];
    //         $period = $user['period'];
    //         $status = 1; // Default status
    
    //         if ($period == '3 months') {
    //             $status = 1;
    //         } elseif ($period == '6 months') {
    //             $status = 2;
    //         } elseif ($period == '1 year') {
    //             $status = 3;
    //         } elseif ($period == '2 years') {
    //             $status = 4;
    //         } elseif ($period == '3 years') {
    //             $status = 5;
    //         }
    
    //         // Update the user's status
    //         User::where('id', $userId)->update(['status' => $status]);
    //     }
    
    //     // Return a success response
    //     return response()->json(['message' => 'Status updated successfully']);
    // }
    public function notification(){
        $login_id = \Auth::user()->type;
        $users = [];
        if ($login_id == 'hr') {
            $threeMonthsAgo = now()->subMonths(3);
            $sixMonthsAgo = now()->subMonths(6);
            $oneYearAgo = now()->subYear();
            $twoYearsAgo = now()->subYears(2);
            $threeYearsAgo = now()->subYears(3);
    
            $threeMonthsUsers = User::whereDate('created_at', $threeMonthsAgo->toDateString())
                                    ->get()
                                    ->map(function ($user) {
                                        $user['period'] = '3 months';
                                        return $user;
                                    });
            $sixMonthsUsers = User::whereDate('created_at', $sixMonthsAgo->toDateString())
                                  ->get()
                                  ->map(function ($user) {
                                      $user['period'] = '6 months';
                                      return $user;
                                  });
            $oneYearUsers = User::whereDate('created_at', $oneYearAgo->toDateString())
                                ->get()
                                ->map(function ($user) {
                                    $user['period'] = '1 year';
                                    return $user;
                                });
            $twoYearsUsers = User::whereDate('created_at', $twoYearsAgo->toDateString())
                                 ->get()
                                 ->map(function ($user) {
                                     $user['period'] = '2 years';
                                     return $user;
                                 });
            $threeYearsUsers = User::whereDate('created_at', $threeYearsAgo->toDateString())
                                   ->get()
                                   ->map(function ($user) {
                                       $user['period'] = '3 years';
                                       return $user;
                                   });
            $users = $threeMonthsUsers
                        ->merge($sixMonthsUsers)
                        ->merge($oneYearUsers)
                        ->merge($twoYearsUsers)
                        ->merge($threeYearsUsers);
        }
        return view('notification.index', compact('users'));
    }
}
