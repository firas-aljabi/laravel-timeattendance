<?php

namespace App\Repository\Requests;

use App\ApiHelper\SortParamsHelper;
use App\Filter\JustifyRequests\JustifyRequestsFilter;
use App\Models\EmployeeRequest;
use App\Models\JustifyRequest;
use App\Repository\BaseRepositoryImplementation;
use App\Statuses\JustifyStatus;
use App\Statuses\UserTypes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EmployeeRequestRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
        // $records = EmployeeRequest::query()->where('user_id', Auth::id());
        // if ($filter instanceof JustifyRequestsFilter) {
        //     $records->when(isset($filter->orderBy), function ($records) use ($filter) {
        //         $sortParams = SortParamsHelper::getSortParams($filter->getOrderBy());
        //         if ($sortParams->getIsRelated()) {
        //             $records
        //                 ->join(
        //                     $sortParams->getTable(),
        //                     'justify_requests.' . $sortParams->getJoinColumn(),
        //                     '=',
        //                     $sortParams->getRelation()
        //                 )
        //                 ->orderBy($sortParams->getOrderColumn(), $filter->getOrder());
        //         } else {
        //             $records->orderBy($filter->getOrderBy(), $filter->getOrder());
        //         }
        //     });
        //     return $records->with('user')->paginate($filter->per_page);
        // }
        // return $records->with('user')->paginate($filter->per_page);
    }


    public function employee_request($data)
    {
        DB::beginTransaction();
        try {

            if (auth()->user()->type == UserTypes::HR || auth()->user()->type == UserTypes::EMPLOYEE) {
                $user_id = Auth::id();

                $existing_request = EmployeeRequest::where('user_id', $user_id)->first();

                if ($existing_request) {
                    return ['success' => false, 'message' => "A request has already been created for this user."];
                }

                $employeeRequest = new EmployeeRequest();
                $employeeRequest->user_id =  auth()->user()->id;
                $employeeRequest->reason = $data['reason'];
                $employeeRequest->type = $data['type'];
                $employeeRequest->date = date('Y-m-d');
                $employeeRequest->company_id = auth()->user()->company_id;

                if (Arr::has($data, 'attachments')) {
                    $file = Arr::get($data, 'attachments');
                    $extention = $file->getClientOriginalExtension();
                    $file_name = Str::uuid() . date('Y-m-d') . '.' . $extention;
                    $file->move(public_path('uploaded'), $file_name);

                    $image_file_path = public_path('uploaded/' . $file_name);
                    $image_data = file_get_contents($image_file_path);
                    $base64_image = base64_encode($image_data);
                    $employeeRequest->attachments = $base64_image;
                }
                $employeeRequest->save();


                DB::commit();
                if ($employeeRequest === null) {
                    return ['success' => false, 'message' => "Request was not created"];
                }
                return ['success' => true, 'data' => $employeeRequest->load(['user'])];
            } else {
                return ['success' => false, 'message' => "Unauthorized"];
            }
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e->getMessage());

            throw $e;
        }
    }

    public function model()
    {
        return EmployeeRequest::class;
    }
}
