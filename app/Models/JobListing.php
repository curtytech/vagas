<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'enterprise_id', 'title', 'slug', 'description', 'location',
        'is_remote', 'employment_type', 'salary_min', 'salary_max',
        'status', 'published_at', 'expires_at', 'apply_url',
    ];
}