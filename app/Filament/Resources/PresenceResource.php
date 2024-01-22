<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresenceResource\Pages;
use App\Filament\Resources\PresenceResource\RelationManagers;
use App\Models\Presence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup ="Entreprise Management";
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employe_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('arrivee'),
                Forms\Components\DateTimePicker::make('depart'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employe_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('arrivee')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('depart')
                    ->dateTime()
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
            'index' => Pages\ListPresences::route('/'),
            'create' => Pages\CreatePresence::route('/create'),
            'edit' => Pages\EditPresence::route('/{record}/edit'),
        ];
    }
}
