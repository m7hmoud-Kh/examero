<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherPlanResource extends JsonResource
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
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'plan' => new PlanResource($this->whenLoaded('plan')),
            'points' => $this->points,
            'status' => $this->status,
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s A')
        ];
    }
}
