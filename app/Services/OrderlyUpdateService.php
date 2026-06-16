<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderlyUpdateService
{
    public function __construct(
        protected OrderlyService $orderlyService,
    ) {
        //
    }
    
    public function update(array $request, $orderly_id)
    {
        try {
            DB::beginTransaction();
            
            $this->orderlyService->update($request, $orderly_id);

            DB::commit();
        } catch (Exception $exception) {
            ////Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
