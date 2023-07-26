<?php

namespace App\Http\Resources\Requests;

use App\Http\Resources\Admin\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VacationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "type" => $this->type,
            "status" => $this->status,
            "reason" => $this->reason,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            'payment_type' => $this->payment_type,
            'user' => EmployeeResource::make($this->whenLoaded('user')),

        ];
    }
}
