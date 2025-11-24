<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'city',
        'state',
        'country',
        'function',
        'resume_path',
        'curriculum_pdf_path',
        'address',
        'number',
        'linkedin_url',
        'portfolio_url',
        'summary',
        'photo_path',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}