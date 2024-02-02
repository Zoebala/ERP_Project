<?php

namespace App\Models;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;
    protected $fillable=[
        "employe_id",
        "arrivee",
        "depart",
        "status",
        "BtnDepart",
        "BtnArrivee",
        "Observation",

    ];

    public function employe():BelongsTo
    {
        return $this->BelongsTo(Employe::class);
    }
}
