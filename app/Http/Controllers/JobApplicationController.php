<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class JobApplicationController extends Controller
{
    public function store(string $slug): RedirectResponse
    {
        // Redireciona para login se não autenticado (com fallback para Filament)
        if (!auth()->check()) {
            if (Route::has('login')) {
                return redirect()->route('login');
            }
            return redirect('/admin/login');
        }

        $user = auth()->user();

        if ($user->role !== 'employee') {
            return back()->with('error', 'Apenas candidatos podem se candidatar.');
        }

        $job = DB::table('job_listings')
            ->select('id', 'status')
            ->where('slug', $slug)
            ->first();

        if (!$job || $job->status !== 'published') {
            return back()->with('error', 'Vaga indisponível para candidatura.');
        }

        $employee = DB::table('employees')
            ->select('id')
            ->where('user_id', $user->id)
            ->first();

        if (!$employee) {
            return back()->with('error', 'Crie seu perfil de candidato antes de se candidatar.');
        }

        $alreadyApplied = DB::table('job_applications')
            ->where('job_listing_id', $job->id)
            ->where('employee_id', $employee->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('info', 'Você já se candidatou a esta vaga.');
        }

        DB::table('job_applications')->insert([
            'job_listing_id' => $job->id,
            'employee_id' => $employee->id,
            'status' => 'applied',
            'cover_letter' => null,
            'resume_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Candidatura enviada com sucesso!');
    }
}