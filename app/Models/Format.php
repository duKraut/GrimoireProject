<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'min_deck_size',
        'max_deck_size',
        'sideboard_size',
        'copy_limit',
        'is_singleton',
        'platform',
    ];
}