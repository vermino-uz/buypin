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
use Filament\Forms\Components\Select;
class PriceByIdResource extends Resource
{
    protected static ?string $model = PriceById::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'ID Tariflari';
    protected static ?string $navigationGroup = "O'yinlar va Tariflar";
    protected static ?string $navigationParentItem = "O'yinlar";
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('game_id')
                ->label('Game')
                ->options(Game::all()->pluck('game_name', 'id'))
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('tariff_name', null);
                    $set('price', null);
                }),
            Forms\Components\TextInput::make('amount')->label('Miqdori')->visible(fn (callable $get) => $get('game_id') !== null),
            Forms\Components\TextInput::make('price')
                ->label('Price')
                ->required()
                ->numeric()
                ->suffix('$')
                ->visible(fn (callable $get) => $get('game_id') !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('game_id')->label('Game')->formatStateUsing(fn ($record) => Game::find($record->game_id)->game_name),
                Tables\Columns\TextColumn::make('amount')->badge()->color('success')->label('Tariff name')->formatStateUsing(fn ($record) => $record->amount . " " . Game::find($record->game_id)->currency),
                Tables\Columns\TextColumn::make('price')->label('Price')->formatStateUsing(fn ($record) => $record->price . " $" )->badge()->color('success'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Aktivmi?')->inline(false),
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
            ])
            ->groups([
                'game_id',
                'price',
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
