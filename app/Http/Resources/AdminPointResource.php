<?php

namespace App\Http\Resources;

use App\Models\AdminPoint;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminPointResource extends JsonResource
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
            'message' => $this->message,
            'points' => $this->points,
            'type' => AdminPoint::getTypeName($this->type),
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
        ];
    }
}
