<?php

namespace App\Filament\Widgets;

use App\Models\Animal;
use App\Models\IndependentTeam;
use Filament\Widgets\ChartWidget;

class TeamsByGovernorateChart extends ChartWidget
{
    protected static ?string $heading = 'الفرق حسب المحافظة';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $teams = IndependentTeam::with('governorate')
            ->withCount('animals')
            ->get()
            ->groupBy('governorate.name');

        $labels = $teams->keys()->toArray();
        $data = $teams->map(fn ($group) => $group->sum('animals_count'))->values()->toArray();

        return [
            'datasets' => [[
                'label' => 'عدد الحيوانات',
                'data' => $data,
                'backgroundColor' => [
                    'rgb(34, 197, 94)', 'rgb(59, 130, 246)', 'rgb(234, 179, 8)',
                    'rgb(239, 68, 68)', 'rgb(168, 85, 247)', 'rgb(20, 184, 166)',
                    'rgb(249, 115, 22)', 'rgb(236, 72, 153)', 'rgb(99, 102, 241)',
                ],
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
