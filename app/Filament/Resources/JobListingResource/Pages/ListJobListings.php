<?php

namespace App\Filament\Resources\JobListingResource\Pages;

use App\Filament\Resources\JobListingResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListJobListings extends ListRecords
{
    protected static string $resource = JobListingResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        $canCreate = $user && in_array($user->role, ['enterprise', 'admin'], true);

        return $canCreate ? [Actions\CreateAction::make()] : [];
    }
}