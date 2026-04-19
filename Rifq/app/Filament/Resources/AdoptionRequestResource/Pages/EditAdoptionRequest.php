<?php

namespace App\Filament\Resources\AdoptionRequestResource\Pages;

use App\Filament\Resources\AdoptionRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdoptionRequest extends EditRecord
{
    protected static string $resource = AdoptionRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
