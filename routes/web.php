<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    $jobs = DB::table('job_listings')
        ->join('enterprises', 'job_listings.enterprise_id', '=', 'enterprises.id')
        ->select('job_listings.id', 'job_listings.title', 'job_listings.slug', 'job_listings.location', 'job_listings.is_remote', 'job_listings.published_at', 'enterprises.company_name')
        ->where('job_listings.status', 'published')
        ->orderByDesc('job_listings.published_at')
        ->limit(6)
        ->get();

    $resumes = DB::table('employees')
        ->join('users', 'employees.user_id', '=', 'users.id')
        ->select(
            'employees.id',
            'employees.city',
            'employees.state',
            'employees.country',
            'employees.linkedin_url',
            'employees.summary',
            'employees.curriculum_pdf_path',
            'users.name',
        )
        ->where(function ($q) {
            $q->whereNotNull('employees.summary')
              ->orWhereNotNull('employees.curriculum_pdf_path');
        })
        ->orderByDesc('employees.updated_at')
        ->limit(6)
        ->get();

    return view('welcome', compact('jobs', 'resumes'));
});

Route::get('/buscar-vagas', [JobController::class, 'search'])->name('jobs.search');

Route::get('/vagas/{slug}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/candidatos/{id}', [EmployeeController::class, 'show'])->name('employees.show');
