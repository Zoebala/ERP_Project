<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use Filament\Actions;
use Filament\Tables\Table;
// use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\EmployeResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListEmployes extends ListRecords
{
    protected static string $resource = EmployeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // public function getTabs():array
    // {
    //     return [
    //         'Tous'=>Tab::make(),
    //         "Liste de Présence"=>Tab::make()
    //         ->modifyQueryUsing(fn(Builder $query)=>$query->join("presences","presences.employe_id","=","employes.id","right outer"))
    //         // ->where("presences.employe_id",null)
            
    //     ];
    // }
}
