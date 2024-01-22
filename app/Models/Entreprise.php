<?php

namespace App\Models;

use App\Models\Direction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entreprise extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib"
    ];

    public function directions()
    {
        return $this->hasMany(Direction::class);
    }
}
