<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Presence;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Resources\Components\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PresenceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PresenceResource\RelationManagers;
// use Illuminate\Database\Eloquent\Builder;

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
                Section::make("Présence")
                ->aside()
                ->icon("heroicon-o-calendar-days")
                ->description("Signaler votre présence ici!")
                ->schema([
                    Select::make('employe_id')
                        ->relationship("employe","nom")
                        ->preload()
                        ->searchable()
                        ->required(),
                    DateTimePicker::make('arrivee'),
                    DateTimePicker::make('depart'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('employe.photo')->label("Profil"),
                TextColumn::make('employe.nom')
                    ->label("Nom")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employe.postnom')
                    ->label("Postnom")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employe.prenom')
                    ->label("Prénom")
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                    TextColumn::make('created_at')
                    ->label("Heure Arrivée")
                    ->dateTime("d/m/Y H:i:s")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                    TextColumn::make('arrivee')
                    ->label("Date/Heure Arrivée")
                    ->dateTime("d/m/Y H:i:s")
                    ->sortable(),
                    ToggleColumn::make('BtnDepart')
                    ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('depart')
                    ->label("Date/Heure Depart")
                    ->dateTime("d/m/Y H:i:s")
                    ->sortable(),
                    TextColumn::make('status')
                        // ->label("Prénom")
                        ->searchable()
                        ->sortable(),
                // TextColumn::make('updated_at')
                //   ->label("Heure Depart")
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(),
            ])
            ->filters([
                //
                
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make(name: "Départ")
                ->icon('heroicon-o-user')
                ->color('info')
                ->action(function(Presence $presence){
                    $check=Presence::whereRaw("id=$presence->id AND DATE(created_at)=DATE(now()) AND BtnDepart=1")->first();
                    
                    // dd($check);
                    if($check==null){
                        Presence::where("id",$presence->id)->update([
                            "depart"=> now(),
                            "BtnDepart"=> 1,
                        ]);
                        Notification::make()
                        ->title('Départ signalé avec succès')
                        ->success()
                        ->send();
                    }else{
                        Notification::make()
                        ->title("l'employé(e) est déjà parti(e)")
                        ->warning()
                        ->send();
                    }
                        
                }),
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
