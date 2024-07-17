<?php

namespace App\Http\Resources;

use App\Models\OpenEmis;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpenEmisResource extends JsonResource
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
            'user_name' => $this->user_name,
            'password' => $this->password,
            'group' => $this->group,
            'subject' => $this->subject,
            'status' => OpenEmis::getStatusName($this->status),
            'note' => $this->note,
            'phone_number' => $this->phone_number,
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'media' => new MediaResource($this->whenLoaded('media')),
            'ImagePath' =>$this->whenLoaded('media',OpenEmis::PATH_IMAGE),
        ];
    }
}
