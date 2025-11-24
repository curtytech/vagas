<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use App\Models\Employee;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();

        if (!$user) {
            return [];
        }

        if ($user->role === 'employee') {
            $hasRecord = Employee::query()->where('user_id', $user->id)->exists();
            return $hasRecord ? [] : [Actions\CreateAction::make()];
        }

        // Oculta "Criar" para perfis não-candidatos
        return [];
    }
}