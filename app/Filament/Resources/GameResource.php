<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class GameResource extends Resource
{
    protected static ?string $navigationLabel = "O'yinlar";
    protected static ?string $model = Game::class;
    protected static ?string $navigationGroup = "O'yinlar va Tariflar";
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-c-puzzle-piece';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('game_name')
                    ->label('Game Name')
                    ->required(),
                TextInput::make('thumb')
                    ->label('Thumbnail')
                    ->required(),
                TextInput::make('currency')
                    ->label('Currency')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumb')
                    ->label('Icon')->circular()->width(40),
                TextColumn::make('game_name')
                    ->label('Game Name'),
                TextColumn::make('currency')
                    ->label('Currency'),
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
