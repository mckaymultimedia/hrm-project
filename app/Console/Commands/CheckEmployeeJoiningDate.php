<?php

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckEmployeeJoiningDate extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employeeJoinDate:check_joining_date';
 /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if employee joining date is approaching 3 months';

     /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $users = User::where('joining_date', '<=', $threeMonthsAgo)->get();

        if ($users->isNotEmpty()) {
            // Send alert to admin or display a popup
            // Example: Mail::to($admin)->send(new JoiningDateAlert($users));
            $this->info('Alert sent to admin.');
        } else {
            $this->info('No users found with approaching joining date.');
        }
    }
}


