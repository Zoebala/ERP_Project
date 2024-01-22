<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Poste;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PosteResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PosteResource\RelationManagers;
// use App\Filament\Resources\PosteResource\RelationManagers\EmployesRelationManager;

class PosteResource extends Resource
{
    protected static ?string $model = Poste::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup ="Entreprise Management";
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Nouveau Poste ?")
                ->description("Ajouter un nouveau poste ici!")
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('departement.lib')
                    ->label("Departement")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lib')
                    ->label("Poste")
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\EmployesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostes::route('/'),
            'create' => Pages\CreatePoste::route('/create'),
            'edit' => Pages\EditPoste::route('/{record}/edit'),
        ];
    }
}
