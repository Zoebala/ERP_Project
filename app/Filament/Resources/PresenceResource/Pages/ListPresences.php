<?php

namespace App\Filament\Resources\PresenceResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PresenceResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListPresences extends ListRecords
{
    protected static string $resource = PresenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    // public function getTabs():array
    // {
    //     return [
    //         'Toute'=>Tab::make(),
    //         "Aujourd'hui"=>Tab::make()
    //         ->modifyQueryUsing(fn(Builder $query)=>$query->where("prensences.arrivee",now())),
            
    //     ];
    // }
}
