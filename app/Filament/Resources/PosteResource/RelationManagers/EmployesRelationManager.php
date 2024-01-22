<?php

namespace App\Filament\Resources\PosteResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class EmployesRelationManager extends RelationManager
{
    protected static string $relationship = 'employes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Modifier Employé ?")
                ->description("Modifier l'employé ici!")
                ->icon('heroicon-o-user')
                ->schema([

                    TextInput::make('nom')
                        ->required()
                        ->live()
                        ->maxLength(255),
                    TextInput::make('postnom')
                        ->required()
                        ->live()
                        ->hidden(fn(Get $get):bool => !filled($get("nom")))
                        ->maxLength(255),
                    Select::make('genre')
                        ->live()
                        ->options([
                            "F"=>"F",
                            "M"=>"M"
                        ])
                        ->required()
                        ->hidden(fn(Get $get):bool => !filled($get("postnom"))),
                    DatePicker::make('datenais')
                        ->hidden(fn(Get $get):bool => !filled($get("genre")))
                        ->required(),
                ])->columnSpan(2),
                Section::make("Votre Profil")
                ->icon("heroicon-o-camera")
                ->description("Uploader votre profil ici!")
                ->schema([
                    // SpatieMediaLibraryFileUpload::make("photo"),
                    FileUpload::make("photo")->disk("public")->directory("photos"),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nom')
            ->columns([
                ImageColumn::make("photo"),
                TextColumn::make('nom')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('postnom')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('genre')
                    ->searchable(),
                TextColumn::make('datenais')
                    ->date("d/m/Y")
                    ->label("DateNaissance")
                    // ->format()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
