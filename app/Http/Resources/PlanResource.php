<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'allow_exam' => $this->allow_exam,
            'allow_question' => $this->allow_question,
            'status' => $this->status,
            'for_whom' => $this->for_student ? 'Student' : 'Teacher',
            'pivot' => $this->whenLoaded('pivot', function () {
                return [
                    'exam_used' => $this->pivot->exam_used,
                    'subscribe_type' => date_format($this->created_at, 'Y m-d h:i:s A'),
                    'payment_id' => $this->pivot->payment_id,
                    'type' => $this->pivot->type,
                ];
            }),
        ];
    }
}
