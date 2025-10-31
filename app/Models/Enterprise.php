<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'company_slug', 'website_url',
        'contact_email', 'contact_phone', 'about', 'logo_path',
    ];
}