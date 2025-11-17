<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'format_id',
        'description',
        'user_id',
        'commander_scryfall_id',
    ];

    public function format(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Format::class);
    }

    public function deckCards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DeckCard::class);
    }
}
