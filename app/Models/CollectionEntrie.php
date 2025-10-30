<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionEntrie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'printing_id',
        'quantity',
        'is_foil',
        'condition',
    ];
}