<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Models\Enterprise;
use App\Models\JobListing;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions; // <— ADICIONADO
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Minhas Vagas';
    protected static ?string $navigationGroup = 'Vagas';
    protected static ?string $title = 'Vagas';


    public static function shouldRegisterNavigation(): bool
    {
        $role = auth()->user()?->role;
        return in_array($role, ['enterprise', 'admin'], true);
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     $user = auth()->user();
    //     if (!$user) {
    //         return parent::getEloquentQuery()->whereRaw('1 = 0');
    //     }
    //     if ($user->role === 'admin') {
    //         return parent::getEloquentQuery();
    //     }
    //     if ($user->role === 'enterprise') {
    //         $enterprise = Enterprise::query()->where('user_id', $user->id)->first();
    //         return parent::getEloquentQuery()->when($enterprise, fn ($q) => $q->where('enterprise_id', $enterprise->id), fn ($q) => $q->whereRaw('1 = 0'));
    //     }
    //     return parent::getEloquentQuery()->whereRaw('1 = 0');
    // }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Vaga')
                ->collapsible()
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('enterprise_id')
                            ->label('Empresa')
                            ->options(fn () => Enterprise::query()
                                ->orderBy('company_name')
                                ->pluck('company_name', 'id')
                                ->toArray())
                            ->default(fn () => Enterprise::query()
                                ->where('user_id', auth()->id())
                                ->value('id'))
                            ->disabled(fn () => auth()->user()?->role === 'enterprise')
                            ->required(),

                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(150)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set) {
                                $set('slug', Str::slug((string) $state));
                            }),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(180)
                            ->dehydrateStateUsing(fn ($state) => Str::slug((string) $state))
                            ->unique(table: 'job_listings', column: 'slug', ignoreRecord: true),

                        TextInput::make('location')
                            ->label('Local')
                            ->maxLength(150),
                    ]),

                    Grid::make(2)->schema([
                        Toggle::make('is_remote')
                            ->label('Remoto'),

                        Select::make('employment_type')
                            ->label('Tipo de contratação')
                            ->options([
                                'full_time' => 'Full-time',
                                'part_time' => 'Part-time',
                                'contract' => 'Contrato',
                                'internship' => 'Estágio',
                            ])
                            ->required(),
                    ]),

                    Textarea::make('description')
                        ->label('Descrição')
                        ->rows(6)
                        ->required(),
                ]),

            Section::make('Detalhes')
                ->collapsible()
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('salary_min')
                            ->label('Salário mínimo')
                            ->numeric()
                            ->step('0.01'),

                        TextInput::make('salary_max')
                            ->label('Salário máximo')
                            ->numeric()
                            ->step('0.01'),
                    ]),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'draft' => 'Rascunho',
                            'published' => 'Publicada',
                            'closed' => 'Encerrada',
                        ])
                        ->required(),
                ]),

            Section::make('Publicação')
                ->collapsible()
                ->schema([
                    Grid::make(2)->schema([
                        DateTimePicker::make('published_at')
                            ->label('Publicada em'),

                        DateTimePicker::make('expires_at')
                            ->label('Expira em'),
                    ]),

                    TextInput::make('apply_url')
                        ->label('URL para candidatura')
                        ->url()
                        ->maxLength(255),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Título')->searchable()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('published_at')->label('Publicada em')->dateTime()->sortable(),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->visible(fn () => in_array(auth()->user()?->role, ['admin', 'enterprise'], true)),
                Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()?->role === 'admin')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()?->role === 'admin'),
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

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === 'admin';
    }
}