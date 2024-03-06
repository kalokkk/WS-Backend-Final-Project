<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampsiteSpot extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'image',
        'campsite_id',
    ];

    public function campsite(): BelongsTo
    {
        return $this->belongsTo(Campsite::class);
    }
}
