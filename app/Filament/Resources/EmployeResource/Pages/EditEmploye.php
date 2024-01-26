<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EmployeResource;

class EditEmploye extends EditRecord
{
    protected static string $resource = EmployeResource::class;
  

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
        // ->icon("heroicon-o-user")
        ->title("Modification")
        ->success()
        ->body("Modification effecuée avec succès!") ;
    }
}
