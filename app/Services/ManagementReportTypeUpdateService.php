<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManagementReportTypeUpdateService
{
    public function __construct(
        protected UserService $userService,
        protected BiddingService $biddingService,
        protected ManagementReportTypeService $managementReportTypeService,
    ) {
        //
    }

    public function update(array $request, $managementReportType_id)
    {
        try {
            DB::beginTransaction();

            $this->managementReportTypeService->update($request, $managementReportType_id);

            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
