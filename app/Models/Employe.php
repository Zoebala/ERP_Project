<?php

namespace App\Models;

use App\Models\Poste;
use App\Models\Presence;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded=[];

    public function postes()
    {
        return $this->belongsToMany(Poste::class,"affectations")->withTimestamps();
    }

    public function presences()
    {
        return $this->HasMany(Presence::class);
    }
}
