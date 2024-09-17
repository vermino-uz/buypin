<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceByIdResource\Pages;
use App\Filament\Resources\PriceByIdResource\RelationManagers;
use App\Models\PriceById;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use App\Models\Game;
class PriceByIdResource extends Resource
{
    protected static ?string $model = PriceById::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('game_id')->label('Game')->formatStateUsing(fn ($record) => Game::find($record->game_id)->game_name),
                Tables\Columns\TextColumn::make('price')->label('Price')->formatStateUsing(fn ($record) => "$" . $record->price),
                Tables\Columns\TextColumn::make('amount')->label('Amount')->formatStateUsing(fn ($record) => $record->amount . " " . Game::find($record->game_id)->currency),
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
            'index' => Pages\ListPriceByIds::route('/'),
            'create' => Pages\CreatePriceById::route('/create'),
            'edit' => Pages\EditPriceById::route('/{record}/edit'),
        ];
    }
}
