<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'format_id',
        'description',
        'commander_printing_id',
        'color_identity',
    ];

    protected $casts = [
        'color_identity' => 'array',
    ];
}