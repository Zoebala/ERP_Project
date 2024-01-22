<?php

namespace App\Filament\Resources\PosteResource\Pages;

use App\Filament\Resources\PosteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostes extends ListRecords
{
    protected static string $resource = PosteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
