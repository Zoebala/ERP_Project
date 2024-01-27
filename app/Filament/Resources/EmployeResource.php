<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employe;
use Filament\Forms\Get;
use App\Models\Presence;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Illuminate\Database\Query\Builder;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\EmployeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\EmployeResource\RelationManagers;
// use App\Filament\Resources\EmployeResource\RelationManagers\PostesRelationManager;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup ="Entreprise Management";
    protected static ?int $navigationSort = 5;
    protected static ?string $recordTitleAttribute ="nom";
    public static function getGlobalSearchResultTitle(Model $record):string
    {
        return $record->nom.' '.$record->postnom;
    }
    public static function getGloballySearchableAttributes():array
    {
        return [
            "nom",
            "postnom",
            "postes.lib"
        ];
    }
    // public static function getGlobalSearchResultDetails(Model $record):array
    // {
    //     return [
    //         "Poste"=>$record->postes->lib,
    //     ];
    // }
    // public static function getGlobalSearchResultEloquentQuery(Model $record):Builder
    // {
    //     return parent::getGlobalSearchEloquentQuery()->with(['parenttable']);
    // }
    // public static function getGlobalSearchResultDetails(Model $record):array
    // {
    //     return [
    //         "Poste"=>$record->postes->lib,
    //     ];
    // }
    // public static function getGlobalSearchResultEloquentQuery(Model $record):Builder
    // {
    //     return parent::getGlobalSearchEloquentQuery()->with(['parenttable']);
    // }
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
                Tabs::make('Identification Employé')
                        ->tabs([
                            Tab::make('Info 1')
                                ->schema([
                                    // ...
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
                                        TextInput::make('prenom')
                                            ->required()
                                            ->live()
                                            ->hidden(fn(Get $get):bool => !filled($get("postnom")))
                                            ->maxLength(255),
                                        Select::make('genre')
                                            ->live()
                                            ->options([
                                                "F"=>"F",
                                                "M"=>"M"
                                            ])
                                            ->required()
                                            ->hidden(fn(Get $get):bool => !filled($get("prenom"))),
                                        DatePicker::make('datenais')
                                            ->label("Date de naissance")
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
                            ]),
                           
                            Tab::make('Info 2')
                                ->schema([
                                    Section::make()
                                    ->schema([

                                        TextInput::make('phone')
                                            ->label("Telephone")
                                            ->tel()
                                            ->placeholder('Ex : 089XXXXXXX')
                                            ->maxLength(10),
                                        TextInput::make('email')
                                            ->placeHolder('Ex: toto@example.com')
                                            ->email(),                                                    
                                        TextInput::make('lieu_naissance')
                                            ->placeholder('Ex: Mbanza-Ngungu')
                                            ->maxLength(255),
                                        TextInput::make('pays_naissance')
                                            ->placeholder('Ex: Nigeria')
                                            ->maxLength(255),
                                        Select::make('situation_familiale')
                                            ->options([
                                            "Marié(e)"=>"Marié(e)",
                                            "Célibataire"=>"Célibataire",
                                            "Divorcé(e)"=>"Divorcé(e)",
                                            "Veuf(ve)"=>"Veuf(ve)",
                                        ]),
                                       TextInput::make('Nbre_Enfant')
                                            ->placeholder('Ex: 2'),
                                       TextInput::make('adresse')
                                            ->placeholder('Ex: 45, Av. mweneditu Q/Disengomoka')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),
                            Tab::make('info 3')
                                    ->schema([
                                       Group::make()
                                       ->schema([
                                            Section::make()
                                            ->schema([

                                                Select::make('position')
                                                 ->options([
                                                     "En activité"=>"En activité",
                                                     "En congé"=>"En congé",
                                                     "En suspension"=>"En suspension"
                                                 ]),
                                                 DatePicker::make("date_embauche"),
                                                 Select::make('province')
                                                  ->options([
                                                      "kongo Central"=>"kongo Central",
                                                      "kinshasa"=>"kinshasa",
                                                      "haut-Katanga"=>"haut-Katanga",
                                                      "lualaba"=>"lualaba",
                                                      "haut-lomani"=>"haut-lomani",
                                                      "kolwezi"=>"kolwezi",
                                                      "mai-ndombe"=>"mai-ndombe",
                                                      "kwilu"=>"kwilu",
                                                      "tshopo"=>"tshopo",
                                                      "tshuapa"=>"tshuapa",
                                                      "ituri"=>"ituri",
                                                      "sankuru"=>"sankuru",
                                                      "sud-ubangi"=>"sud-ubangi",
                                                      "nord-ubangi"=>"nord-ubangi",
                                                      "sud-kivu"=>"sud-kivu",
                                                      "nord-kivu"=>"sud-kivu",
                                                      "bas-uélé"=>"bas-uélé",
                                                      "haut-uélé"=>"haut-uélé",
                                                      "kasaï"=>"kasaï",
                                                      "kasaï-central"=>"kasaï-central",
                                                      "kasaï-oriental"=>"kasaï-oriental",
                                                      "kwango"=>"kwango",
                                                      "lomani"=>"lomani",
                                                      "maniema"=>"maniema",
                                                      "mongala"=>"mongala",
                                                      "tanganyika"=>"tanganyika",
                                                      "équateur"=>"équateur",
         
                                                  ]),
                                                 Select::make('structure')
                                                  ->options([
                                                     "systematik"=>"systematik",
                                                     "quisine"=>"quisine",
                                                  ]),
                                                 Select::make('qualification')
                                                  ->options([
                                                     "gradué(e)"=>"gradué(e)",
                                                     "licencié(e)"=>"licencié(e)",
                                                     "Master"=>"Master",
                                                  ]),
                                                  Section::make()
                                                  ->description("Avez vous une rémunération ?")
                                                  ->schema([
                                                      Toggle::make('remuneration')
                                                      ->label('Rémunération')
                                                      ->live(),
                                                      TextInput::make('montantrem')
                                                      ->label('Montant rémuneration')
                                                      ->placeholder('Ex: 100000')
                                                      ->hidden(fn(Get $get):bool => $get('remuneration')==false)
                                                      ->integer()
                                                      ->minValue(0)
                                                      ->maxValue(100000000),
                                                  ])->columnSpan(1),
                                            ])->columnSpanFull()->columns(2),
                                       ])->columnSpanFull(),
                                         
                                                        
                            ])->columns(2),
                            Tab::make("info 4")
                                ->schema([
                                    TextInput::make("formation_suivie")
                                    ->placeholder('Ex: Marketing'),
                                    TextInput::make("institution_obt_diplome")
                                    ->placeholder('Ex: ISP_Mbanza-Ngungu'),
                                    TextInput::make("annee_obt_diplome")
                                    ->label("Annee obtention diplôme")
                                    ->placeholder('Ex: 2023-2024')
                                    ->maxLength(9),
                                    TextInput::make("lieu_obt_diplome")
                                    ->label('Lieu Obtention diplôme')
                                    ->placeholder('Ex: Mbanza-Ngungu'),
                                    TextInput::make("pays_obt_diplome")
                                    ->label('Pays obtention diplôme')
                                    ->columnSpanFull()
                                    ->placeholder('Ex: RDC'),                                   
                                    
                            ])->columns(2),
                        ])->columnSpanFull()->columns(3),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                ImageColumn::make("photo"),
                TextColumn::make('nom')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('postnom')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('prenom')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('genre')
                    ->searchable(),
                TextColumn::make('datenais')
                    ->date("d/m/Y")
                    ->label("DateNaissance")
                    // ->format()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                // SpatieMediaLibraryImageColumn::make('photo'),
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
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ReplicateAction::make()->color("info"),
                Tables\Actions\Action::make(name: 'présent(e)')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action(function(Employe $employe){
                    
                    //vérifie si l'employé existe déjà
                    $check=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now())")->first();
                    //vérifie si l'employé est absent(e)
                    $check1=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=0")->exists();
                    // dd($check1);

                    if($check==null){
                        
                        Presence::create([
                            'employe_id' => $employe->id,
                            'arrivee' => now(),                       
                            'BtnArrivee' => 1,  
                            'status' => 'présent(e)',                         
                        ]);

                        Notification::make()
                        ->title("Présence de l'employé(e) $employe->nom $employe->postnom signalée avec succès")
                        ->success()
                        ->send();
                        //on vérifie si l'employé n'a pas déjà été déclaré(e) comme absent(e)
                    }elseif($check1){
                       
                            Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=0")->delete();
                            Presence::create([
                                'employe_id' => $employe->id,
                                'arrivee' => now(),                       
                                'BtnArrivee' => 1,   
                                'status' => 'présent(e)',                    
                            ]);
    
                            Notification::make()
                            ->title("Présence de l'employé(e) $employe->nom $employe->postnom signalée avec succès")
                            ->success()
                            ->send();
                    }else{

                            Notification::make()
                            ->title("l'employé $employe->nom $employe->postnom est déjà présent(e)")
                            ->warning()
                            ->send();
                    }
                    
                    
                }),
                Tables\Actions\Action::make(name: 'Absent(e)')
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->action(function(Employe $employe){
                    //on vérifie si l'employé n'a pas déjà été déclarée comme présent(e)
                    $check=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=1")->exists();
                    //on vérifie  si l'employe n'a pas déjà été déclaré comme absent(e)
                    $check2=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=0")->exists();
                    
                    if($check){
                        Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=1")->delete();
                        Presence::create([
                            'employe_id' => $employe->id,
                            'arrivee'=>null,
                            'depart'=>null,
                            'status'=>'absent(e)',
                            // 'arrivee' => now(),                       
                            // 'BtnArrivee' => 0,                       
                        ]);
                        Notification::make()
                        ->title("l'absence de l'employé $employe->nom $employe->postnom signalée avec succès")
                        ->success()
                        ->send();
                    //on vérifie si l'employé n'a pas déjà été déclaré(e) comme absent(e)  
                    }elseif($check2){
                        Notification::make()
                        ->title("l'absence de l'employé(e) $employe->nom $employe->postnom a déjà été signalée")
                        ->warning()
                        ->send();
                    }
                    else{
                        //si le l'employé n'a pas encore été déjà déclaré(e) 
                        Presence::create([
                            'employe_id' => $employe->id,
                            // 'arrivee' => now(),                       
                            'BtnArrivee' => 0,  
                            'status' =>"absent(e)",                     
                        ]);
                        Notification::make()
                        ->title("l'absence de l'employé $employe->nom $employe->postnom signalée avec succès")
                        ->success()
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
            RelationManagers\PostesRelationManager::class,
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
