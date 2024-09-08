<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubTariffResource\Pages;
use App\Filament\Resources\SubTariffResource\RelationManagers;
use App\Models\Game;
use App\Models\SubTariff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Select;

class SubTariffResource extends Resource
{
    protected static ?string $navigationParentItem = 'Games';
    protected static ?string $navigationGroup = "O'yinlar va Tariflar";
    protected static ?int $navigationSort = 2;
    protected static ?string $model = SubTariff::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Forms\Components\TextInput::make('tariff_name')
                    ->label('Tariff Name')
                    ->required()
                    ->visible(fn (callable $get) => $get('game_id') !== null)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $amount = preg_replace('/[^0-9]/', '', $state);
                            $set('amount', $amount ? (int)$amount : null);
                        }
                    }),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->suffix('$')
                    ->visible(fn (callable $get) => $get('game_id') !== null),
                Forms\Components\Hidden::make('amount'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('game_id')
                    ->label('Game Name')
                    ->formatStateUsing(function ($state) {
                        $game = \App\Models\Game::find($state);
                        return $game ? $game->game_name : 'N/A';
                    }),
                TextColumn::make('tariff_name')
                    ->label('Tariff Name')->badge()->color('success'),
                TextColumn::make('price')
                    ->label('Price')->suffix(' $')->color('warning'),
                ToggleColumn::make('is_active')
                    ->label('Is Active')->inline(false),
            ])->groups([
                Tables\Grouping\Group::make('game_id')
                    ->label('Game Name')
                    ->collapsible(),
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
            'index' => Pages\ListSubTariffs::route('/'),
            'create' => Pages\CreateSubTariff::route('/create'),
            'edit' => Pages\EditSubTariff::route('/{record}/edit'),
        ];
    }
}
