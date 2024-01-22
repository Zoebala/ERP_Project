<?php

namespace App\Models;

use App\Models\Direction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory;
     protected $fillable=[
        "lib",
        "direction_id"
     ];
      public function Direction():BelongsTo
      {
        return $this->BelongsTo(Direction::class);
      }
}
