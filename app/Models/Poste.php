<?php

namespace App\Models;

use App\Models\Employe;
use App\Models\Direction;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Poste extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib",
        "departement_id",
        "direction_id"
    ];

    public function departement():BelongsTo
    {
        return $this->Belongsto(Departement::class);
    }

    public function employes()
    {
        return $this->belongsToMany(Employe::class,"affectations")->withTimestamps();
    }

    public function direction():BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }
}
