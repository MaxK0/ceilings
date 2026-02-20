<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ceiling extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'thickness',
        'width',
        'description',
        'category_id',
        'manufacturer_id',
    ];

    protected $casts = [
        'thickness' => 'decimal:2',
        'width' => 'integer',
        'price' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CeilingImage::class, 'ceiling_id')->orderBy('sort');
    }
}
