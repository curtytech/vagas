<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnterpriseResource\Pages;
use App\Models\Enterprise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EnterpriseResource extends Resource
{
    protected static ?string $model = Enterprise::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Minha Empresa';
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
            return parent::getEloquentQuery()->where('user_id', $user->id);
        }
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('company_name')->required(),
            Forms\Components\TextInput::make('company_slug')->required(),
            Forms\Components\TextInput::make('website_url'),
            Forms\Components\TextInput::make('contact_email'),
            Forms\Components\TextInput::make('contact_phone'),
            Forms\Components\Textarea::make('about'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('company_name')->label('Empresa'),
            Tables\Columns\TextColumn::make('contact_email')->label('E-mail'),
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
}