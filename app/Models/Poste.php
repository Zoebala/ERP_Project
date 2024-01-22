<?php

namespace App\Models;

use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poste extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib",
        "departement_id"
    ];

    public function departement():BelongsTo
    {
        return $this->Belongsto(Departement::class);
    }
}
