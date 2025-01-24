<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    protected $table = 'audiences';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'asunto',
        'hora_llegada',
        'fecha_llegada',
        'telefono',
        'cargo',
        'email',
        'folio',
        'observacion',
        'contact_type_id',
        'dependency_id',
        'audience_status_id',
        'state_id',
        'municipality_id'
    ];

    protected $casts = [
        'fecha_llegada' => 'date',
        // 'hora_llegada' => 'time',
    ];

    public function contactType()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }

    public function dependency()
    {
        return $this->belongsTo(Dependency::class, 'dependency_id');
    }

    public function status()
    {
        return $this->belongsTo(AudienceStatus::class, 'audience_status_id');
    }

    public function companions()
    {
        return $this->hasMany(Companion::class, 'audience_id');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
}
