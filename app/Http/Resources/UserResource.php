<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullName' => $this->first_name . ' ' . $this->last_name,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'date_of_birth' => $this->date_of_birth,
            'is_block' => $this->is_block,
            'media' => new MediaResource($this->media),
            'ImagePath' => User::PATH_IMAGE,
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s')
        ];
    }
}
