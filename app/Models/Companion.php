<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companion extends Model
{
    use HasFactory;

    protected $fillable = [
        'audience_id',
        'nombre',
        'telefono',
        'email',
        'cargo',
    ];

    public function audience()
    {
        return $this->belongsTo(Audience::class);
    }
}
