<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnterpriseResource\Pages;
use App\Models\Enterprise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions; // <— ADICIONADO: importa as ações da Tabela
use Illuminate\Database\Eloquent\Builder;

class EnterpriseResource extends Resource
{
    protected static ?string $model = Enterprise::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Minha Empresa';
    protected static ?string $navigationGroup = 'Empresa';

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
            return parent::getEloquentQuery()->where('user_id', $user->id);
        }
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Empresa')
                ->description('Informações principais da empresa.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('company_name')
                            ->label('Nome da empresa')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set) {
                                $set('company_slug', Str::slug((string) $state));
                            }),
                        TextInput::make('company_slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('ex: joao-silva')
                            ->helperText('Use apenas letras e números; espaços viram "-".')
                            ->rule('regex:/^[a-z0-9-]+$/')
                            ->unique(table: 'enterprises', column: 'company_slug', ignoreRecord: true)
                            ->dehydrateStateUsing(fn($state) => Str::slug((string) $state)),
                    ]),
                    Textarea::make('about')
                        ->label('Sobre a empresa')
                        ->rows(6),
                ])
                ->collapsible(),

            Section::make('Contato')
                ->description('Canais de contato e site oficial.')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('website_url')
                            ->label('Site')
                            ->placeholder('https://exemplo.com'),
                        TextInput::make('contact_email')
                            ->label('E-mail de contato')
                            ->email(),
                        TextInput::make('contact_phone')
                            ->label('Telefone')
                            ->placeholder('(99) 99999-9999')
                            ->maxLength(20),
                    ]),
                ])
                ->collapsible(),

            Section::make('Imagem')
                ->description('Logotipo da empresa.')
                ->schema([
                    FileUpload::make('logo_path')
                        ->label('Logo')
                        ->disk('public')
                        ->directory('enterprises/logos')
                        ->acceptedFileTypes(['image/webp', 'image/png', 'image/jpeg', 'image/jpg'])
                        ->maxSize(10240)
                        ->rules(['mimes:webp,png,jpg,jpeg']),
                ])
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->label('Empresa'),
                Tables\Columns\TextColumn::make('contact_email')->label('E-mail'),
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
            'index' => Pages\ListEnterprises::route('/'),
            'create' => Pages\CreateEnterprise::route('/create'),
            'edit' => Pages\EditEnterprise::route('/{record}/edit'),
        ];
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
