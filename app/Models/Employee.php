<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'city',
        'state',
        'country',
        'resume_path',
        'curriculum_pdf_path',
        'address',
        'number',
        'linkedin_url',
        'portfolio_url',
        'summary',
        'photo_path',
    ];
}
