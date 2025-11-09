<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionEntry extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'scryfall_id',
        'user_id',
        'quantity',
        'is_foil',
        'condition',
    ];

    /**
     * Define o relacionamento "pertence-a" com o Utilizador.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}