<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Filament\Resources\PromoCodeResource\RelationManagers;
use App\Models\Game;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;
    protected static ?string $navigationGroup = "O'yinlar va Tariflar";
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Promo kodlar';
    protected static ?string $navigationParentItem = "O'yinlar";
    protected static ?string $navigationIcon = 'heroicon-s-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                
                Select::make('game_id')
                    ->label('Game')
                    ->options(Game::all()->pluck('game_name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('amount', null);
                        $set('promo', null);
                    }),



                Select::make('amount') 
                    ->label('Amount')
                    ->options(function ($get) {
                        $gameId = $get('game_id');
                        if ($gameId) {
                            return \App\Models\SubTariff::where('game_id', $gameId)
                                ->get()
                                ->mapWithKeys(function ($subTariff) {
                                    return [$subTariff->amount => $subTariff->tariff_name];
                                });
                        }
                        return [];
                    })
                    ->disabled(fn ($get) => !$get('game_id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $subTariff = \App\Models\SubTariff::where('amount', $state)->first();
                            $set('price', $subTariff ? $subTariff->price : null);
                        } else {
                            $set('price', null);
                        }
                    }),



                TextInput::make('price')
                    ->label('Price')
                    ->hidden(fn ($get) => !$get('game_id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $subTariff = \App\Models\SubTariff::where('price', $state)->first();
                            $set('amount', $subTariff ? $subTariff->amount : null);
                        } else {
                            $set('amount', null);
                        }
                    }),



                Textarea::make('promo')
                    ->label('Promo Codes')
                    ->required()
                    ->helperText('Enter each promo code on a new line. Multiple codes will create separate records.')
                    ->rows(5),
                Forms\Components\Hidden::make('promo_codes')
                    ->afterStateHydrated(function (Forms\Get $get, Forms\Set $set) {
                        $promoText = $get('promo');
                        $promoCodes = array_filter(explode("\n", $promoText));
                        $gameId = $get('game_id');
                        $amount = $get('amount');
                        $price = $get('price');
                        $set('promo_codes', array_map(function($code) use ($gameId, $amount, $price) {
                            return [
                                'game_id' => $gameId,
                                'amount' => $amount,
                                'price' => $price,
                                'promo' => trim($code),
                            ];
                        }, $promoCodes));
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('game_id'),
                Tables\Columns\TextColumn::make('game.game_name')
                    ->label('Game'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount'),
                Tables\Columns\TextColumn::make('price')->suffix(' $')->color('warning')
                    ->label('Price'),   
                Tables\Columns\TextColumn::make('promo')
                    ->label('Promo')
                    ->copyable()
                    ->copyMessage('Promo code copied')
                    ->copyMessageDuration(1500)
                    ->badge()
                    ->color(fn (PromoCode $record): string => $record->is_sold ? 'danger' : 'success'),
                ToggleColumn::make('is_sold')
                    ->label('Sold')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])->groups([    
                Tables\Grouping\Group::make('game.game_name')
                    ->label('Game')
                    ->collapsible(),
            ])
            ->filters([
                SelectFilter::make('is_sold')
                    ->options([
                        '0' => 'Sotilmaganlari',
                        '1' => 'Sotilganlari',
                    ])->default('0')
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}
