<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class City extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'city',
        'visible',
    ];

    /**
     * @return HasOne
     */
    public function feedback(): HasOne
    {
        return $this->hasOne(FeedBack::class);
    }

    /**
     * @param string $city
     * @return int
     */
    public function getId(string $city): int
    {
        return FeedBack::where('city', $city);
    }
}
