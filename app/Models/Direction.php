<?php

namespace App\Models;

use App\Models\Entreprise;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Direction extends Model
{
    use HasFactory;
     protected $fillable=[
        "entreprise_id",
        "lib"
     ];

     public function Entreprise():BelongsTo
     {
        return $this->BelongsTo(Entreprise::class);
     }

     public function departements()
     {
      return $this->hasMany(Departement::class);
     }
}
