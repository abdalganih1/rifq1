<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;

class MainDashboard extends Dashboard
{
    protected static ?string $navigationLabel = 'لوحة التحكم';
    
    protected static string $view = 'filament.pages.dashboard';
    
    protected static ?int $navigationSort = -2;
    
    public function getHeading(): string
    {
        return 'مرحباً بك في رِفْق';
    }
    
    public function getSubheading(): string
    {
        return 'نظام رعاية وحماية الحيوانات';
    }
}
