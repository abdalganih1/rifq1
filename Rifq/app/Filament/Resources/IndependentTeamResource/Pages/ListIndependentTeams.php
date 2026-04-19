<?php

namespace App\Filament\Resources\IndependentTeamResource\Pages;

use App\Filament\Resources\IndependentTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndependentTeams extends ListRecords
{
    protected static string $resource = IndependentTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
