<?php

namespace App\Filament\Resources\JobListingResource\Pages;

use App\Filament\Resources\JobListingResource;
use App\Models\Enterprise;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateJobListing extends CreateRecord
{
    protected static string $resource = JobListingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        // Garante que apenas enterprise crie vagas
        if (!$user || $user->role !== 'enterprise') {
            abort(403, 'Apenas perfis de empresa podem criar vagas.');
        }

        $enterprise = Enterprise::query()->where('user_id', $user->id)->first();

        if (!$enterprise) {
            abort(403, 'Nenhuma empresa vinculada ao seu usuário.');
        }

        $data['enterprise_id'] = $enterprise->id;

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}