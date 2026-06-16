<?php

namespace App\Services;

use App\Models\Employee;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpseclib\Crypt\Random;

class EmployeeCreateService
{
    // @codingStandardsIgnoreStart
    // TODO: CSFix
    public function __construct(
        protected EmployeeService $employeeService,
        protected UserService $userService,
        protected IndividualPeopleService $individualPeopleService
    ) {
        //
    }
    // @codingStandardsIgnoreEnd

    public function create(array $request): Employee
    {
        try {
            DB::beginTransaction();
            $individualPeople = $this->individualPeopleService->create($request);
            $individualPeople->peopleable()->create($request);
            $user = $this->userService->create(
                array_merge($request, [
                    'people_id' => $individualPeople->peopleable->id,
                    'password'  => bcrypt(Str::random(60))
                ])
            );
            $employee = $this->employeeService->create(
                array_merge(
                    $request,
                    [
                        'people_id' => $individualPeople->peopleable->id
                    ]
                )
            );
            $employee->departaments()->attach(
                $request['departament']
            );
            DB::commit();
        } catch (Exception $exception) {
            ////Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }

        return $employee;
    }
}
