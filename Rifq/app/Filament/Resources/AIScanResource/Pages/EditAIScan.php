<?php

namespace App\Filament\Resources\AIScanResource\Pages;

use App\Filament\Resources\AIScanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAIScan extends EditRecord
{
    protected static string $resource = AIScanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
