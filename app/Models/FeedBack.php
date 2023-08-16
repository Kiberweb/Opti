<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedBack extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'city_id',
        'feedback',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
