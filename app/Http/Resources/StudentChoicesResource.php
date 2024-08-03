<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentChoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'question' => new QuestionResource($this->whenLoaded('question')),
            'studnet_choice' => $this->option_id,
            'is_correct' => $this->is_correct
        ];
    }
}
