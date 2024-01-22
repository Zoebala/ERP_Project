<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Affectation extends Model
{
    use HasFactory;
    protected $fillable=[
        "poste_id",
        "employe_id"
    ];

    // public function employes():BelongsToMany
    // {
    //     return $this->
    // }
}
