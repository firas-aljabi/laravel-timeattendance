<?php

namespace App\Http\Resources\Requests;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'date' => $this->date,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),
            'attachments' => $this->attachments,
        ];
    }
}
