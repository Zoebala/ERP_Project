<?php

namespace App\Filament\Resources\EntrepriseResource\Pages;

use App\Filament\Resources\EntrepriseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEntreprise extends CreateRecord
{
    protected static string $resource = EntrepriseResource::class;
    
    protected function getCreatedNotificationTitle(): ? string
    {
        return "Enregistrement effectué avec succès!";
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}

