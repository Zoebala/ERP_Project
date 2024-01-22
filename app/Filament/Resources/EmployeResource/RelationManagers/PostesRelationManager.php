<?php

namespace App\Filament\Resources\EmployeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PostesRelationManager extends RelationManager
{
    protected static string $relationship = 'postes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Modifier le Poste ?")
                ->description("Modifier un nouveau poste ici!")
                ->aside()
                ->icon("heroicon-o-book-open")
                ->schema([

                    Select::make('departement_id')
                        ->relationship("Departement","lib")
                        ->label("Departement")
                        ->preload()
                        ->required(),
                    TextInput::make('lib')
                        ->label("Poste")
                        ->placeholder("Ex: Directeur")
                        ->required()
                        ->maxLength(255),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lib')
            ->columns([
                TextColumn::make('departement.lib')
                ->label("Departement")
                ->searchable()
                ->sortable(),
            TextColumn::make('lib')
                ->label("Poste")
                ->searchable(),
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
