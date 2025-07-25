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
                Forms\Components\TextInput::make('date_admission')
                    ->label('Dia da admissão')
                    ->required()
                    ->rule('date_format:Y-m')
                    ->placeholder('YYYY-MM')
                    ->maxLength(7),

                Forms\Components\TextInput::make('date_termination')
                    ->label('Dia da rescisão')
                    ->required()
                    ->rule('date_format:Y-m')
                    ->placeholder('YYYY-MM')
                    ->maxLength(7),

                Forms\Components\TagsInput::make('benefits')
                    ->label('Benefícios')
                    ->required(),

                Forms\Components\TextInput::make('position')
                    ->label('Cargo no trabalho')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('salary_id')
                    ->label('Salário')
                    ->relationship('salary', 'total')
                    ->searchable()
                    ->required()
                    ->default(fn () => salary::first()?->id)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_admission')
                    ->label('Valor do salário')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('benefits')
                    ->label('Benefícios')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->label('Cargo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('salary')
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
