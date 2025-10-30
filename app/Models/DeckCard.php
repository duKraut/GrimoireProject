<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeckCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'deck_id',
        'printing_id',
        'quantity',
        'board',
    ];
}