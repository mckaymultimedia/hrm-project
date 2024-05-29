<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmpBirthdayController extends Controller
{
    public function birthdays()
    {
        $employees = Employee::all();
        $emp = [];

        foreach ($employees as $employee) {
            $db = $employee->dob;
            $birthday = Carbon::parse($db);
            $birthday->year(date('Y'));

            $diff = Carbon::now()->diffInDays($birthday, false);
            if ($diff >= 0 && $diff <= 7) {
                $emp[] = $employee;
            }

            // $dob = Carbon::parse($employee->dob)->format('d-M');
            // if ($dob == Carbon::now()->format('d-M')) {
            //     $to = 'hr@devsspace.com';
            //     $subject = 'Birthday Alert';
            //     $message = 'Hello, Today is the Birthday of ' . $employee->name;

            //     Mail::raw($message, function ($mail) use ($to, $subject) {
            //         $mail
            //             ->to($to)
            //             ->subject($subject);
            //     });
            // }
        }

        return view('empbirthdays.index', compact('emp'));
    }
}
