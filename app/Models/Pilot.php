<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pilot extends Model
{
    protected $fillable = [
        'name',
        'image_url',
        'description',
        'tags',
    ];

    public function mobileSuits(): BelongsToMany
    {
        return $this->belongsToMany(MobileSuit::class);
    }
}