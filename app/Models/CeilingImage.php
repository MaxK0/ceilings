<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CeilingImage extends Model
{
    protected $fillable = [
        'image_path',
        'sort',
        'ceiling_id',
    ];

    public function ceiling(): BelongsTo
    {
        return $this->belongsTo(Ceiling::class);
    }
}
