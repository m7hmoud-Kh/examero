<?php

namespace App\Http\Resources;

use App\Models\Question;
use App\Models\TeacherExam;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherExamResource extends JsonResource
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
            'group' => new GroupResource($this->whenLoaded('group')),
            'subject' => new GroupResource($this->whenLoaded('subject')),
            'semster' => Question::getSemsterName($this->semster),
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),

            'mediaPdf' => MediaResource::collection($this->whenLoaded('mediaPdf')),
            'mediaAnswerPath' =>$this->whenLoaded('mediaAnswer',TeacherExam::PATH_IMAGE),
            'mediaQuestionPath' =>$this->whenLoaded('mediaQuestion',TeacherExam::PATH_IMAGE),
        ];
    }
}
