<?php

namespace App\Http\Resources\Requests;

use App\Http\Resources\Admin\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JustifyResource extends JsonResource
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
            "type" => $this->type,
            "status" => $this->status,
            "reason" => $this->reason,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "medical_report_file" => $this->medical_report_file,
            'user' => EmployeeResource::make($this->whenLoaded('user')),
        ];
    }
}
