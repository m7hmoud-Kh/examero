<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'student_id' => $this->user_id,
            'semster' => Question::getSemsterName($this->semster),
            'group' => new GroupResource($this->whenLoaded('group')),
            'subject' => new GroupResource($this->whenLoaded('subject')),
            'unit' => new GroupResource($this->whenLoaded('unit')),
            'lesson' => new LessonResource($this->whenLoaded('lesson')),
            'total_score' => $this->total_score,
            'result' => $this->result,
            'status' => $this->total_score / 2 <= $this->result ? 'ناجح' : 'راسب',
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s A'),
        ];
    }
}
