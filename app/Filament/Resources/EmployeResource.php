<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employe;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                        ->maxLength(255),
                    TextInput::make('postnom')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('genre')
                        ->required()
                        ->maxLength(1),
                    DatePicker::make('datenais')
                        ->required(),
                ])->columnSpan(2),
                Section::make("Votre Profil")
                ->schema([

                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postnom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('genre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('datenais')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
