<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MobileSuit extends Model
{
    protected $fillable = [
        'name',
        'image_url',
        'description',
        'tags',
    ];

    public function pilots(): BelongsToMany
    {
        return $this->belongsToMany(Pilot::class);
    }
}