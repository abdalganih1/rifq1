<?php

namespace App\Filament\Resources\AnimalResource\Pages;

use App\Filament\Resources\AnimalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnimal extends EditRecord
{
    protected static string $resource = AnimalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
