<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BonusResource\Pages;
use App\Filament\Resources\BonusResource\RelationManagers;
use App\Models\Bonus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class BonusResource extends Resource
{
    protected static ?int $navigationSort = 4;
    protected static ?string $model = Bonus::class;
    protected static ?string $navigationGroup = "O'yinlar va Tariflar";
    protected static ?string $navigationIcon = 'heroicon-m-qr-code';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('promo')
                    ->label('Promo')
                    ->required(),
                TextInput::make('count_to_use')
                    ->label('Count to use')->extraAttributes(['style' => 'width: 40%;'])
                    ->suffix(' ta')
                    ->required()->numeric()->minValue(1),
                TextInput::make('amount')
                    ->label('Amount')
                    ->suffix('$')->extraAttributes(['style' => 'width: 40%;'])
                    ->required()->numeric()->minValue(1),
            ])->columns(3);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('promo')
                    ->badge()
                    ->color('info')->copyable()->copyableState(fn (Bonus $record): string => $record->promo),
                TextColumn::make('count_to_use')
                    ->badge()
                    ->color(fn (Bonus $record): string => $record->count_to_use == 0 ? 'danger' : 'success')->suffix(' ta'),
                TextColumn::make('amount')
                    ->suffix(' $')->badge()->color('warning'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBonuses::route('/'),
            'create' => Pages\CreateBonus::route('/create'),
            'edit' => Pages\EditBonus::route('/{record}/edit'),
        ];
    }
}
