<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Console\Command;
use App\Models\PerformanceReview;
use App\Models\User;
use App\Events\PerformanceReviewsUpdated;


class PerformanceReviewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'performance:review';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    
    public function handle()
{
    $threeMonthsAgo = now()->subMonths(3);
    
    
    $targetDate = $threeMonthsAgo->toDateString();
    
    $users = User::whereDate('created_at', $targetDate)
                 ->get();
    
    if ($users->isNotEmpty()) {
    foreach ($users as $user) {
        $this->info('User: ' . $user->name . ', haas completed three months in the company. ');
    }
    event(new PerformanceReviewsUpdated());
} else {
    $this->info('No users found with joining date exactly three months ago.');
}
}

    
    
    // public function handle()
    // {
    //     $employees = Employee::all();
    //     foreach ($employees as $employee) {
    //         $reviewDate = Carbon::parse($employee->company_doj)->addMonth();
    //         PerformanceReview::create([
    //             'employee_id' => $employee->id,
    //             'review_date' => $reviewDate,
    //             'status' => 'pending',
    //         ]);
    //     }
    // }
}
