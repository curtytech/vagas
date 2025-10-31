<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class JobController extends Controller
{
    public function show(string $slug): View
    {
        $job = DB::table('job_listings')
            ->join('enterprises', 'job_listings.enterprise_id', '=', 'enterprises.id')
            ->select(
                'job_listings.id',
                'job_listings.title',
                'job_listings.slug',
                'job_listings.description',
                'job_listings.location',
                'job_listings.is_remote',
                'job_listings.employment_type',
                'job_listings.salary_min',
                'job_listings.salary_max',
                'job_listings.status',
                'job_listings.published_at',
                'enterprises.company_name',
                'enterprises.company_slug',
                'enterprises.website_url'
            )
            ->where('job_listings.slug', $slug)
            ->first();

        abort_unless($job, 404);

        return view('jobs.show', compact('job'));
    }
}