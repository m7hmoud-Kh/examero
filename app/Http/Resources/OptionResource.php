<?php

namespace App\Http\Resources;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'option' => $this->option,
            'is_correct' => $this->is_correct,
            'media' => new MediaResource($this->whenLoaded('media')),
            'ImagePath' =>$this->whenLoaded('media',Option::PATH_IMAGE),
        ];
    }
}
