<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EnviromentalLicensingUpdateService
{
    public function __construct(
        protected UserService $userService,
        protected BiddingService $biddingService,
        protected EnviromentalLicensingService $enviromentalLicensingService,
    ) {
        //
    }

    public function update(array $request, $enviromentalLicensing_id)
    {
        try {
            DB::beginTransaction();

            $this->enviromentalLicensingService->update($request, $enviromentalLicensing_id);

            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
