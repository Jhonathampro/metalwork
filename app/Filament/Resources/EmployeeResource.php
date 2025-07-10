<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\employee;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome')->required(),
                Forms\Components\TextInput::make('age')->label('Idade')->required()->numeric(),
                Forms\Components\Select::make('marital_status')
                    ->label('Estado civil')
                    ->placeholder('Escolha uma opção')
                    ->options([
                        'Solterio(a)' => 'Solterio(a)',
                        'Casado(a)' => 'Casado(a)',
                        'Divorciado(a)' => 'Divorciado(a)',
                        'Viuvo(a)' => 'Viuvo(a)',
                        'Separado(a)' => 'Separado(a)',
                        'Noivo(a)' => 'Noivo(a)',
                        'Namorando'  => 'Namorando',
                    ]),
                Forms\Components\TextInput::make('address')->label('Endereço')->required(),
                Forms\Components\TextInput::make('data_of_birth')->label('Data de nascimento')->required(),
                Forms\Components\TextInput::make('phone')->label('Número de contato')->required(),
                Forms\Components\TextInput::make('email')->label('email')->required(),
                Forms\Components\TextInput::make('document')->label('CPF')->required(),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('age')
                    ->label('idade')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('número de contato')
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
