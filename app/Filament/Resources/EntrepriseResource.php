<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Entreprise;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EntrepriseResource\Pages;
use App\Filament\Resources\EntrepriseResource\RelationManagers;
use App\Filament\Resources\EntrepriseResource\RelationManagers\DirectionsRelationManager;

class EntrepriseResource extends Resource
{
    protected static ?string $model = Entreprise::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup ="Entreprise Management";
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgecolor():string|array|null
    {
        return static::getModel()::count() > 5 ? 'success' : 'warning';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make("Nouvelle Entreprise ?")
                ->description("Ajouter une entreprise ici!")
                ->icon("heroicon-o-building-library")
                ->aside()
                ->schema([
                    TextInput::make("lib")
                    ->label("Dénomination")
                    ->required()
                    ->placeholder("Ex: Systematik")
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("id")
                ->numeric(),
                TextColumn::make("lib")
                ->label("Dénomination")
                ->searchable(),
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
            DirectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntreprises::route('/'),
            'create' => Pages\CreateEntreprise::route('/create'),
            'edit' => Pages\EditEntreprise::route('/{record}/edit'),
        ];
    }
}
