<?php

namespace App\Filament\Resources\EnterpriseResource\Pages;

use App\Filament\Resources\EnterpriseResource;
use App\Models\Enterprise;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListEnterprises extends ListRecords
{
    protected static string $resource = EnterpriseResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();

        if (!$user) {
            return [];
        }

        if ($user->role === 'admin') {
            return [Actions\CreateAction::make()];
        }

        if ($user->role === 'enterprise') {
            $hasEnterprise = Enterprise::query()->where('user_id', $user->id)->exists();
            return $hasEnterprise ? [] : [Actions\CreateAction::make()];
        }

        return [];
    }
}