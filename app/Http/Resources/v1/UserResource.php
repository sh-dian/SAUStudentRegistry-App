<?php

namespace App\Http\Resources\v1;

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
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "registration_status" => $this->registration_status_label,
            "registration_status_id" => $this->registration_status,
            "access_token" => $this->when($this->id == auth()->id(), function () {
                return $this->accessToken;
            }),
        ];
    }
}
