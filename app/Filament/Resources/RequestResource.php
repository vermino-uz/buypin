<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\Request;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;
    protected static ?string $navigationLabel = 'Buyurtmalar';
    protected static ?string $navigationIcon = 'heroicon-s-arrow-down-on-square-stack';
    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('game'),
                TextColumn::make('user_id')->copyable(),
                TextColumn::make('tariff'),
                TextColumn::make('price')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . " $")
                    ->badge()
                    ->color('success'),
                TextColumn::make('account')->copyable()->copyMessage('Account ID copied')->copyMessageDuration(1500)->badge(
                ),
                SelectColumn::make('is_fulfilled')->options([
                    1=>"To'lab berildi",
                    0=>"To'langani yo'q",
                ])
            ])
            ->filters([
                SelectFilter::make('is_fulfilled')
                ->options([
                    '0' => "To'lanmaganlari",
                    '1' => "To'langanlari",
                ])->default('0')            ])
            ->actions([
                // Tables\Actions\Action::make('fulfilled')->requiresConfirmation()->label("To'landi")
                // ->action(function($record){

                // }),
                Tables\Actions\EditAction::make(),
                

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
