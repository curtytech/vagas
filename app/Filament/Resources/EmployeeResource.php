<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Meu Perfil';
    protected static ?string $navigationGroup = 'Employee';

    public static function shouldRegisterNavigation(): bool
    {
        $role = auth()->user()?->role;
        return in_array($role, ['employee', 'admin'], true);
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
            return parent::getEloquentQuery()->where('user_id', $user->id);
        }
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('phone')->label('Telefone'),
            Forms\Components\TextInput::make('city')->label('Cidade'),
            Forms\Components\TextInput::make('state')->label('Estado'),
            Forms\Components\TextInput::make('country')->label('País'),
            Forms\Components\TextInput::make('linkedin_url')->label('LinkedIn'),
            Forms\Components\Textarea::make('summary')->label('Resumo'),
            Forms\Components\FileUpload::make('curriculum_pdf_path')
                ->label('Currículo (PDF)')
                ->disk('public')
                ->directory('employees/curriculums')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(10240),
            Forms\Components\FileUpload::make('photo_path')
                ->label('Foto')
                ->disk('public')
                ->directory('employees/photos')
                ->acceptedFileTypes(['image/*'])
                ->maxSize(10240),
                ->acceptedFileTypes(['image/webp', 'image/png', 'image/jpeg', 'image/jpg'])
                ->rules(['mimes:webp,png,jpg,jpeg']),
            Forms\Components\TextInput::make('address')
                ->label('Endereço')
                ->maxLength(100),
            Forms\Components\TextInput::make('number')
                ->label('Número')
                ->maxLength(100),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user_id')->label('User'),
            Tables\Columns\TextColumn::make('phone')->label('Telefone'),
            Tables\Columns\TextColumn::make('city')->label('Cidade'),
            Tables\Columns\TextColumn::make('address')->label('Endereço'),
            Tables\Columns\TextColumn::make('number')->label('Número'),
            Tables\Columns\TextColumn::make('curriculum_pdf_path')
                ->label('Currículo')
                ->url(fn ($record) => $record->curriculum_pdf_path ? Storage::url($record->curriculum_pdf_path) : null, true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}