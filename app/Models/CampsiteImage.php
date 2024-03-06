<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampsiteImage extends Model
{
    use HasFactory;

    public $fillable = [
        'image_path',
    ];

    public function campsite(): BelongsTo
    {
        return $this->belongsTo(Campsite::class);
    }
}
