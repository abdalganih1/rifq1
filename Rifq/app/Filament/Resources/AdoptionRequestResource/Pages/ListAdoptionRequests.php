<?php

namespace App\Filament\Resources\AdoptionRequestResource\Pages;

use App\Filament\Resources\AdoptionRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdoptionRequests extends ListRecords
{
    protected static string $resource = AdoptionRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
