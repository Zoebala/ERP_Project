<?php

namespace App\Models;

use App\Models\Poste;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable=[
        "lib",
        "nom",
        "postnom",
        "datenais",
        "genre",
        "photo"
    ];

    public function postes()
    {
        return $this->belongsToMany(Poste::class,"affectations")->withTimestamps();
    }
}
