<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'activo'];

    // Relación con municipios
    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'state_id'); // Relación de uno a muchos
    }
}
