<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_listing_id', 'employee_id', 'status', 'cover_letter', 'resume_path',
    ];
}