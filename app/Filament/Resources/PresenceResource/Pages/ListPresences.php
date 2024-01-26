<?php

namespace App\Filament\Resources\PresenceResource\Pages;

use Filament\Actions;

use App\Models\Presence;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
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
    public function getTabs():array
    {
        return [
            'Toute'=>Tab::make(),
            'Today'=>Tab::make()
            ->modifyQueryUsing(function(Builder $query)
            {
               $query->whereRaw("Date(presences.created_at)=DATE(now())");

            })->badge(Presence::query()
            ->whereRaw("Date(created_at)=DATE(now())")->count())
            ->icon("heroicon-o-users"),
            
        ];
    }
}
