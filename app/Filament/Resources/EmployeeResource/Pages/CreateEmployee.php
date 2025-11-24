<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Employee;
use Filament\Support\Exceptions\Halt;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    // Preenche user_id e valida perfil
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'employee') {
            throw new Halt();
        }

        $data['user_id'] = $user->id;

        return $data;
    }

    // Bloqueia criação se já existir um currículo
    public function mount(): void
    {
        parent::mount();

        $user = auth()->user();

        if (!$user || $user->role !== 'employee') {
            $this->redirect(EmployeeResource::getUrl('index'));
            throw new Halt();
        }

        $existing = Employee::query()->where('user_id', $user->id)->first();
        if ($existing) {
            $this->redirect(EmployeeResource::getUrl('edit', ['record' => $existing->getKey()]));
            throw new Halt();
        }
    }
}