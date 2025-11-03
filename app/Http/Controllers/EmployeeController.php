<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function show(int $id): View
    {
        $employee = DB::table('employees')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->select(
                'employees.id',
                'users.name',
                'employees.phone',
                'employees.city',
                'employees.state',
                'employees.country',
                'employees.function',
                'employees.curriculum_pdf_path',
                'employees.address',
                'employees.number',
                'employees.linkedin_url',
                'employees.portfolio_url',
                'employees.summary',
            )
            ->where('employees.id', $id)
            ->first();

        abort_unless($employee, 404);

        return view('employees.show', compact('employee'));
    }
}
