<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BotUserResource\Pages;
use App\Filament\Resources\BotUserResource\RelationManagers;
use App\Models\BotUser;
use Doctrine\DBAL\Types\BooleanType;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Termwind\style;

class BotUserResource extends Resource
{
    protected static ?string $model = BotUser::class;
    protected static ?string $navigationLabel = 'Bot foydalanuvchila';
    protected static ?string $navigationIcon = 'heroicon-m-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name'),
                TextInput::make('user_id'),
                
                TextInput::make('balance')->suffixicon('heroicon-s-currency-dollar')->extraAttributes(['style' => 'width: 60%']),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('pfp')
                    ->label('Profile Picture')
                    ->circular(),
                TextColumn::make('full_name'),
                TextColumn::make('user_id'),
                TextColumn::make('balance')->badge()->color(fn(BotUser $record): string => $record->balance == 0.00 ? 'danger' : 'success')->formatStateUsing(fn(BotUser $record): string => number_format($record->balance, 2) . ' $'),
                TextColumn::make('coin')->numeric(),
                TextColumn::make('language')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'uz' => 'Uzbek',
                            'ru' => 'Rus',
                            'eng' => 'Ingliz',
                            default => $state,
                        };
                    }),
                TextColumn::make('phone_number')
                    ->default('Kiritilmagan'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportAction::make()
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
            'index' => Pages\ListBotUsers::route('/'),
            'create' => Pages\CreateBotUser::route('/create'),
            'edit' => Pages\EditBotUser::route('/{record}/edit'),
        ];
    }
}
