<?php

namespace App\Filament\Resources\PresenceResource\Pages;

use App\Filament\Resources\PresenceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePresence extends CreateRecord
{
    protected static string $resource = PresenceResource::class;
    protected function getCreatedNotificationTitle(): ? string
    {
        return "Enregistrement effectué avec succès!";
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
