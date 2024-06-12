<?php

namespace App\Http\Resources;

use App\Models\TeacherPlanDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherPlanDetailsResource extends JsonResource
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
            'point' => $this->point,
            'type' => TeacherPlanDetails::getTypeName($this->type),
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s A')
        ];
    }
}
