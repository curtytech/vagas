<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Models\Enterprise;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Minhas Vagas';
    protected static ?string $navigationGroup = 'Enterprise';

    public static function shouldRegisterNavigation(): bool
    {
        $role = auth()->user()?->role;
        return in_array($role, ['enterprise', 'admin'], true);
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
        if ($user->role === 'enterprise') {
            $enterprise = Enterprise::query()->where('user_id', $user->id)->first();
            return parent::getEloquentQuery()->when($enterprise, fn ($q) => $q->where('enterprise_id', $enterprise->id), fn ($q) => $q->whereRaw('1 = 0'));
        }
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('slug')->required(),
            Forms\Components\Textarea::make('description')->required(),
            Forms\Components\TextInput::make('location'),
            Forms\Components\Toggle::make('is_remote'),
            Forms\Components\Select::make('employment_type')->options([
                'full_time' => 'Full-time',
                'part_time' => 'Part-time',
                'contract' => 'Contrato',
                'internship' => 'Estágio',
            ])->required(),
            Forms\Components\TextInput::make('salary_min')->numeric()->step('0.01'),
            Forms\Components\TextInput::make('salary_max')->numeric()->step('0.01'),
            Forms\Components\Select::make('status')->options([
                'draft' => 'Rascunho',
                'published' => 'Publicada',
                'closed' => 'Encerrada',
            ])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Título')->searchable(),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge(),
            Tables\Columns\TextColumn::make('published_at')->label('Publicada em')->dateTime(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}