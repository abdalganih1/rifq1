<?php

namespace App\Filament\Resources\AIScanResource\Pages;

use App\Filament\Resources\AIScanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAIScans extends ListRecords
{
    protected static string $resource = AIScanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
