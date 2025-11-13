<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return [Actions\DeleteAction::make()];
        }
        return [];
    }
}