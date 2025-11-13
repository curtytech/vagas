<?php

namespace App\Filament\Resources\EnterpriseResource\Pages;

use App\Filament\Resources\EnterpriseResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditEnterprise extends EditRecord
{
    protected static string $resource = EnterpriseResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return [Actions\DeleteAction::make()];
        }
        return [];
    }
}