<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campsite extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'location',
    ];


    public function campsite_images(): HasMany
    {
        return $this->hasMany(CampsiteImage::class);
    }


    public function campsite_spots(): HasMany
    {
        return $this->hasMany(CampsiteSpot::class);
    }
}
