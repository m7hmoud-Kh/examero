<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
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
            'causer' => $this->causer ? new AdminResource($this->causer) : null,
            'properties' => $this->properties,
            'description' => $this->description,
            'event_type' => $this->event,
            'subject_type' => $this->subject_type,
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s A'),
        ];
    }
}
