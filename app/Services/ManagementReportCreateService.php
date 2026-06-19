<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManagementReportCreateService
{
    public function __construct(
        protected ManagementReportService $managementReportService,
    ) {
        //
    }

    public function create(array $request): \App\Models\ManagementReport
    {
        try {
            DB::beginTransaction();
            $report = $this->managementReportService->create($request);

            DB::commit();
            return $report;
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
