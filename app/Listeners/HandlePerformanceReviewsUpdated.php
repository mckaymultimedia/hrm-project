<?php

namespace App\Listeners;

use App\Events\PerformanceReviewsUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandlePerformanceReviewsUpdated implements ShouldQueue
{
    public function handle(PerformanceReviewsUpdated $event)
    {
        // Redirect to the performance reviews route
        return redirect()->route('perfromanceView.index');
    }
}
