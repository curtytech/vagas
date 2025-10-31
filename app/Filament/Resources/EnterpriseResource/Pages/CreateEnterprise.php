<?php

namespace App\Filament\Resources\EnterpriseResource\Pages;

use App\Filament\Resources\EnterpriseResource;
use App\Models\Enterprise;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateEnterprise extends CreateRecord
{
    protected static string $resource = EnterpriseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        // Garante que apenas enterprise crie sua empresa
        if (!$user || $user->role !== 'enterprise') {
            abort(403, 'Apenas perfis de empresa podem criar sua empresa.');
        }

        // Impede duplicidade de empresa por usuário
        $alreadyHasEnterprise = Enterprise::query()
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyHasEnterprise) {
            abort(403, 'Você já possui uma empresa cadastrada.');
        }

        $data['user_id'] = $user->id;

        if (empty($data['company_slug']) && !empty($data['company_name'])) {
            $data['company_slug'] = Str::slug($data['company_name']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}