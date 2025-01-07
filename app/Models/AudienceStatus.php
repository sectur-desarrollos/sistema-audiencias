<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudienceStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'color', 'activo'];

    public function audiences()
    {
        return $this->hasMany(Audience::class, 'audience_status_id');
    }
}
