<?php

namespace App\Filament\Widgets;

use App\Models\Animal;
use App\Models\AdoptionRequest;
use App\Models\User;
use App\Models\IndependentTeam;
use App\Models\Governorate;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي الحيوانات', Animal::count())
                ->description('جميع الحيوانات المسجلة')
                ->descriptionIcon('heroicon-m-heart')
                ->color('success'),

            Stat::make('بيانات مُدخلة', Animal::where('data_entered_status', true)->count())
                ->description(Animal::where('data_entered_status', false)->count() . ' قيد الإدخال')
                ->descriptionIcon('heroicon-m-pencil')
                ->color('info'),

            Stat::make('متاحة للتبني', Animal::where('status', 'Available')->count())
                ->description(Animal::where('status', 'Adopted')->count() . ' تم التبني')
                ->descriptionIcon('heroicon-m-home')
                ->color('warning'),

            Stat::make('طلبات التبني', AdoptionRequest::count())
                ->description(AdoptionRequest::where('status', 'Pending')->count() . ' قيد المراجعة')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('danger'),

            Stat::make('الفرق المستقلة', IndependentTeam::count())
                ->description(Governorate::has('independentTeams')->count() . ' محافظة مغطاة')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('المستخدمين', User::count())
                ->description('إجمالي المستخدمين المسجلين')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
