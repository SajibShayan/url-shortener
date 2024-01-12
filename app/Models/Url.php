<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'slug',
        'short_code',
        'long_url',
        'clicks_count',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSluggableColumnName(): string
    {
        return 'short_code';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
