<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'location',
        'stack',
        'link',
        'client',
        'payment_type',
        'profile',
        'platform',
        'applied_at',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\Employee', 'user_id', 'id');
    }
    public function jobProfile()
    {
        return $this->belongsTo('App\Models\JobProfile', 'profile', 'id');
    }
    
}
