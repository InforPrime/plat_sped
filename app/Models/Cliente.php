<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'email',
        'nome_modelo',
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
