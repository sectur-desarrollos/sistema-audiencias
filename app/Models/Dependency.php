<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependency extends Model
{
    use HasFactory;
    
    protected $table = 'dependencies';

    protected $fillable = [
        'name',
        'activo',
    ];

    public function audiences()
    {
        return $this->hasMany(Audience::class, 'dependency_id');
    }
}
