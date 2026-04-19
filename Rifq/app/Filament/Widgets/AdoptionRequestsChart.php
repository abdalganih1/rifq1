<?php

namespace App\Filament\Widgets;

use App\Models\AdoptionRequest;
use Filament\Widgets\ChartWidget;

class AdoptionRequestsChart extends ChartWidget
{
    protected static ?string $heading = 'طلبات التبني';
    
    protected static ?int $sort = 2;
    
    protected function getData(): array
    {
        $approved = AdoptionRequest::where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->count();
        
        $rejected = AdoptionRequest::where('status', 'rejected')
            ->whereMonth('created_at', now()->month)
            ->count();
        
        $pending = AdoptionRequest::where('status', 'pending')
            ->whereMonth('created_at', now()->month)
            ->count();
        
        return [
            'datasets' => [
                [
                    'label' => 'طلبات التبني هذا الشهر',
                    'data' => [$approved, $rejected, $pending],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)',   // green - approved
                        'rgb(239, 68, 68)',   // red - rejected
                        'rgb(234, 179, 8)',   // yellow - pending
                    ],
                ],
            ],
            'labels' => ['مقبول', 'مرفوض', 'قيد المراجعة'],
        ];
    }
    
    protected function getType(): string
    {
        return 'doughnut';
    }
}
