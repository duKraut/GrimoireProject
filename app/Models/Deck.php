<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'name',
        'format_id',
        'description',
        'user_id',
        'commander_scryfall_id' 
        // Adicionámos os campos que vêm do formulário
    ];

    /**
     * Define o relacionamento "pertence-a" com o Format.
     */
    public function format(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Format::class);
    }

    public function deckCards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DeckCard::class);
    }
}