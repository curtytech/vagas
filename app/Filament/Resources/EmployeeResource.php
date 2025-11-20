<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $modelLabel = 'Funcionário';
    protected static ?string $pluralModelLabel = 'Funcionários';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Funcionários';
    protected static ?string $navigationGroup = 'Empresa';
    protected static ?string $recordTitleAttribute = 'nome'; 
    protected static ?string $title = 'Funcionários';

    // protected static ?string $navigationGroup = 'Employee';

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
            Section::make('Currículo')
                ->description('Dados do currículo e perfil profissional.')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('function')
                            ->label('Função')
                            ->placeholder('Informe sua função principal.'),
                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->placeholder('https://www.linkedin.com/in/usuario'),
                        TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(99) 99999-9999')
                            ->placeholder('(99) 99999-9999')
                            ->maxLength(15)
                            ->nullable(),
                    ]),
                    Textarea::make('summary')
                        ->label('Resumo')
                        ->rows(6),

                ])
                ->collapsible(),

            Section::make('Endereço')
                ->description('Informações de localização e endereço do candidato.')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('address')
                            ->label('Endereço')
                            ->maxLength(50)
                            ->columnSpan(2),
                        TextInput::make('number')
                            ->label('Número')
                            ->maxLength(50),
                        TextInput::make('city')
                            ->label('Cidade')
                            ->maxLength(50)
                            ->nullable()
                            ->rule('regex:/^[a-zA-ZÀ-ÿ\s]+$/')
                            ->helperText('Apenas letras são permitidas.'),
                        TextInput::make('state')
                            ->label('Estado')
                            ->maxLength(50)
                            ->nullable()
                            ->rule('regex:/^[a-zA-ZÀ-ÿ\s]+$/')
                            ->helperText('Apenas letras são permitidas.'),
                        TextInput::make('country')
                            ->label('País')
                            ->maxLength(50)
                            ->nullable()
                            ->rule('regex:/^[a-zA-ZÀ-ÿ\s]+$/')
                            ->helperText('Apenas letras são permitidas.'),
                    ]),
                ])
                ->collapsible(),

            Section::make('Arquivos')
                ->schema([
                    Grid::make(2)->schema([
                        FileUpload::make('photo_path')
                            ->label('Foto')
                            ->disk('public')
                            ->directory('employees/photos')
                            ->acceptedFileTypes(['image/webp', 'image/png', 'image/jpeg', 'image/jpg'])
                            ->maxSize(10240)
                            ->rules(['mimes:webp,png,jpg,jpeg']),
                        FileUpload::make('curriculum_pdf_path')
                            ->label('Currículo (PDF)')
                            ->disk('public')
                            ->directory('employees/curriculums')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240),
                    ]),

                ])

                ->collapsible(),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')->label('Usuário'),
                Tables\Columns\TextColumn::make('phone')->label('Telefone'),
                Tables\Columns\TextColumn::make('city')->label('Cidade'),
                Tables\Columns\TextColumn::make('address')->label('Endereço'),
                Tables\Columns\TextColumn::make('number')->label('Número'),
                Tables\Columns\TextColumn::make('curriculum_pdf_path')
                    ->label('Currículo')
                    ->url(fn($record) => $record->curriculum_pdf_path ? Storage::url($record->curriculum_pdf_path) : null, true),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->visible(fn () => in_array(auth()->user()?->role, ['admin', 'employee'], true)),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
