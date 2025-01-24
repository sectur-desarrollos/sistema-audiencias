<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;
    
    protected $fillable = ['state_id', 'name', 'activo'];

    // Relación con el modelo de State
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
