<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use App\Filament\Resources\EmployeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmploye extends CreateRecord
{
    protected static string $resource = EmployeResource::class;

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Enregistrement effectué avec succès!";
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
