<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'contador_id',
    ];

    public function contador()
    {
        return $this->belongsTo(User::class, 'contador_id');
    }

    public function arquivos()
    {
        return $this->hasMany(Arquivo::class);
    }
}
