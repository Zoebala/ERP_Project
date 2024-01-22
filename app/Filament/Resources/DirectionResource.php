<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Direction;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DirectionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DirectionResource\RelationManagers;

class DirectionResource extends Resource
{
    protected static ?string $model = Direction::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup ="Entreprise Management";
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Nouvelle Direction ?")
                ->icon('heroicon-o-building-office')
                ->aside()
                ->description("Ajouter une nouvelle Direction ici!")
                ->schema([

                    Select::make('entreprise_id')
                        ->relationship('Entreprise',"lib")
                        ->preload()
                        ->searchable()
                        ->label("Entreprise")
                        ->required(),
                    TextInput::make('lib')
                        ->label("Direction")
                        ->required()
                        ->placeholder("Ex: Ressources Humaines")
                        ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('entreprise.lib')
                    ->label("Entreprise")                    
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lib')
                    ->label("Direction")
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDirections::route('/'),
            'create' => Pages\CreateDirection::route('/create'),
            'edit' => Pages\EditDirection::route('/{record}/edit'),
        ];
    }
}
