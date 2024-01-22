<?php

namespace App\Filament\Resources\DirectionResource\Pages;

use App\Filament\Resources\DirectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDirection extends EditRecord
{
    protected static string $resource = DirectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
