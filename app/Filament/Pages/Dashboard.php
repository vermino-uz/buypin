<?php
 
namespace App\Filament\Pages;
 
class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationGroup = 'Asosiy';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'dashboard';
    protected static ?string $maxWidth = 'full';
    protected static ?string $maxHeight = 'full';
    protected static ?string $pollingInterval = '30s';
    
}