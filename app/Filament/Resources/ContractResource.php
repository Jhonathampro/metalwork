<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\contract;
use App\Models\salary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Documento')
                    ->relationship('employee', 'document')
                    ->required(),

                Forms\Components\DatePicker::make('date_admission')
                    ->label('Dia da admissão')
                    ->required()
                    ->minDate('2015-01-01')
                    ->maxDate(now()->addYear()),

                Forms\Components\DatePicker::make('date_termination')
                    ->label('Dia da rescisão')
                    ->minDate('2015-01-01')
                    ->maxDate(now()->addYear()),

                Forms\Components\TagsInput::make('benefits')
                    ->label('Benefícios')
                    ->required(),

                Forms\Components\TextInput::make('position')
                    ->label('Cargo no trabalho')
                    ->required()
                    ->maxLength(255),


                Forms\Components\TextInput::make('value_salary')
                    ->label('Valor do salário')
                    ->numeric()
                    ->prefix('R$')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, \Filament\Forms\Get $get) {
                        $discount = $get('discount_salary') ?? 0;
                        $set('total_salary', max(0, $state - $discount));
                    }),

                Forms\Components\TextInput::make('day_payment')
                    ->label('Dia do pagamento')
                    ->required(),

                Forms\Components\TextInput::make('discount_salary')
                    ->label('Desconto do pagamento')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0)
                    ->reactive()
                    ->rule(function (\Filament\Forms\Get $get) {
                        return function (string $attribute, $value, \Closure $fail) use ($get) {
                            $salary = $get('value_salary') ?? 0;
                            if ($value > $salary) {
                                $fail('O desconto não pode ser maior que o salário.');
                            }
                        };
                    })
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, \Filament\Forms\Get $get) {
                        $salary = $get('value_salary') ?? 0;
                        $set('total_salary', max(0, $salary - $state));
                    }),

                Forms\Components\TextInput::make('total_salary')
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
                Tables\Columns\TextColumn::make('employee.document')

                    ->label('Documento')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_salary')
                    ->label('Valor total do pagamento')
                    ->prefix('R$')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->label('Cargo')
                    ->searchable(),

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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
