<?php

namespace App\Http\Resources;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'level' => Question::getLevelName($this->level),
            'for' => Question::getForWhomName($this->for),
            'semster' => Question::getSemsterName($this->semster),
            'status' => Question::getStatusName($this->status),
            'has_branch' => $this->has_branch,
            'is_choose' => $this->is_choose,
            'group' => new GroupResource($this->whenLoaded('group')),
            'subject' => new GroupResource($this->whenLoaded('subject')),
            'unit' => new GroupResource($this->whenLoaded('unit')),
            'lesson' => new LessonResource($this->whenLoaded('lesson')),
            'question_type' => new QuestionTypeResource($this->whenLoaded('questionType')),
            'media' => new MediaResource($this->whenLoaded('media')),
            'ImagePath' =>$this->whenLoaded('media',Question::PATH_IMAGE),
            'adminAuthor' => new AdminQuestionResource($this->whenLoaded('adminQuestion')),
            'options' => OptionResource::collection($this->whenLoaded('options'))
        ];
    }
}
