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
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, \Filament\Forms\Get $get) {
                        $discount = $get('discount') ?? 0;
                        $set('total', max(0, $state - $discount));
                    }),

                Forms\Components\TextInput::make('day')
                    ->label('Dia do pagamento')
                    ->required(),

                   Forms\Components\TextInput::make('discount')
                       ->label('Desconto do pagamento')
                       ->numeric()
                       ->prefix('R$')
                       ->default(0)
                       ->reactive()
                       ->rule(function (\Filament\Forms\Get $get) {
                           return function (string $attribute, $value, \Closure $fail) use ($get) {
                               $salary = $get('value') ?? 0;
                               if ($value > $salary) {
                                   $fail('O desconto não pode ser maior que o salário.');
                               }
                           };
                       })
                       ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, \Filament\Forms\Get $get) {
                           $salary = $get('value') ?? 0;
                           $set('total', max(0, $salary - $state));
                       }),

                Forms\Components\TextInput::make('total')
                    ->label('Valor total do pagamento')
                    ->numeric()
                    ->prefix('R$')
                    ->disabled()
                    ->dehydrated()
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
                Tables\Columns\TextColumn::make('day')
                    ->label('Dia do pagamento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Valor total do pagamento')
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
