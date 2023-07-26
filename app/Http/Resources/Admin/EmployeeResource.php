<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Employees\AttendanceResource;
use App\Http\Resources\Employees\EmployeeAvailableTimeResource;
use App\Http\Resources\Employees\SalaryResource;
use App\Http\Resources\Requests\VacationResource;
use App\Models\EmployeeAvailableTime;
use App\Services\Admin\AdminService;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user_id = $this->id;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'work_email' => $this->work_email,
            'status' => $this->status,
            'type' => $this->type,
            'gender' => $this->gender,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'departement' => $this->departement,
            'skills' => $this->skills,
            'serial_number' => $this->serial_number,
            'nationalitie_id' => $this->nationalitie_id,
            'birthday_date' => $this->birthday_date,
            'marital_status' => $this->marital_status,
            'guarantor' => $this->guarantor,
            'branch' => $this->branch,
            'start_job_contract' => $this->start_job_contract,
            'end_job_contract' => $this->end_job_contract,
            'start_visa' => $this->start_visa,
            'end_visa' => $this->end_visa,
            'start_passport' => $this->start_passport,
            'end_passport' => $this->end_passport,
            'image' => $this->image,
            'id_photo' => $this->id_photo,
            'biography' => $this->biography,
            'employee_sponsorship' => $this->employee_sponsorship,
            'visa' => $this->visa,
            'passport' => $this->passport,
            'municipal_card' => $this->municipal_card,
            'health_insurance' => $this->health_insurance,
            'permission_to_entry' =>  $this->permission_to_entry,
            'permission_to_leave' =>  $this->permission_to_leave,
            'percentage' => AdminService::AttendancePercentage($user_id),
            'Basic Salary' => $this->basic_salary,
            'salaries' => SalaryResource::collection($this->whenLoaded('salaries')),
            'availableTime' => $this->whenLoaded('availableTime', function () {
                return [
                    'hours_daily' => $this->availableTime->hours_daily,
                    'days_monthly' => $this->availableTime->days_monthly,
                    'days_annual' => $this->availableTime->days_annual,
                ];
            }),
            'vacation_approved' => VacationResource::collection($this->whenLoaded('vacationRequestsApproved')),
            'attendances' => AttendanceResource::collection($this->whenLoaded('attendancesMonthly')),

        ];
    }
}
