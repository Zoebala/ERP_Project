<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employe;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\EmployeResource\RelationManagers;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup ="Entreprise Management";
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Nouvel Employé ?")
                ->description("Ajouter un nouvel employé ici!")
                ->icon('heroicon-o-user-plus')
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
                    SpatieMediaLibraryFileUpload::make("photo"),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                    ->searchable(),
                TextColumn::make('postnom')
                    ->searchable(),
                TextColumn::make('genre')
                    ->searchable(),
                TextColumn::make('datenais')
                    ->date()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('photo'),
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
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
        ];
    }
}
