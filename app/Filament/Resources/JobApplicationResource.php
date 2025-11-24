<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Models\Employee;
use App\Models\Enterprise;
use App\Models\JobApplication;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;
    protected static ?string $modelLabel = 'Candidatura';
    protected static ?string $pluralModelLabel = 'Candidaturas';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Candidaturas';
    protected static ?string $navigationGroup = 'Vagas';
    protected static ?string $recordTitleAttribute = 'id'; // ajuste para o campo correto (ex.: 'nome', 'user.name', etc.)
    protected static ?string $title = 'Candidaturas';


    public static function shouldRegisterNavigation(): bool
    {
        $role = auth()->user()?->role;
        return in_array($role, ['employee', 'enterprise', 'admin'], true);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        if (!$user) {
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }
        if ($user->role === 'admin') {
            return parent::getEloquentQuery();
        }
        if ($user->role === 'employee') {
            $employee = Employee::query()->where('user_id', $user->id)->first();
            return parent::getEloquentQuery()->when($employee, fn ($q) => $q->where('employee_id', $employee->id), fn ($q) => $q->whereRaw('1 = 0'));
        }
        if ($user->role === 'enterprise') {
            $enterprise = Enterprise::query()->where('user_id', $user->id)->first();
            $jobIds = $enterprise ? JobListing::query()->where('enterprise_id', $enterprise->id)->pluck('id') : collect([]);
            return parent::getEloquentQuery()->whereIn('job_listing_id', $jobIds->all());
        }
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('status')->options([
                'applied' => 'Aplicada',
                'under_review' => 'Em análise',
                'shortlisted' => 'Pré-selecionada',
                'rejected' => 'Rejeitada',
                'hired' => 'Contratado',
            ])->required(),
            Forms\Components\Textarea::make('cover_letter')->label('Carta de Apresentação'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('jobListing.title')->label('Vaga')->sortable(),
            Tables\Columns\TextColumn::make('employee.user.name')->label('Candidato')->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'applied'      => 'Aplicada',
                    'under_review' => 'Em análise',
                    'shortlisted'  => 'Pré-selecionada',
                    'rejected'     => 'Rejeitada',
                    'hired'        => 'Contratado',
                    default        => $state,
                }),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Criada em'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobApplications::route('/'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}