<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedBackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->full_name,
            'phone' => $this->phone,
            'city' => $this->city->city,
            'feedback' => $this->feedback,
            'created' => $this->created_at->toDateTimeString(),
            'updated' => $this->updated_at->toDateTimeString(),
        ];
    }
}
