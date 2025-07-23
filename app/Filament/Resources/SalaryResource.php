<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Filament\Resources\SalaryResource\RelationManagers;
use App\Models\salary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryResource extends Resource
{
    protected static ?string $model = salary::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->label('Valor do salário')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),


                Forms\Components\TextInput::make('day')
                    ->label('Dia do pagamento')
                    ->required(),

                   Forms\Components\TextInput::make('discount')
                       ->label('Desconto do pagamento')
                       ->numeric()
                       ->prefix('R$')
                       ->required(),

                Forms\Components\TextInput::make('total')
                    ->label('Valor total do pagamento')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor do salário')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data do pagamento')
                    ->date('d/m'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Valor dtotal do pagamento')
                    ->money('BRL')
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}
