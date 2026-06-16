<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ConservationUnitCoverage;

class ConservationUnitCreateService
{
    public function __construct(
        protected ConservationUnitService $conservationUnitService,
    ) {
        //
    }

    public function create(array $request)
    {
        try {
            //dd($request);
            DB::beginTransaction();

            $conservartion_unit = $this->conservationUnitService->create($request);

            if(isset($request['coverages'])){
                foreach ($request['coverages'] as $coverage_id) {

                    ConservationUnitCoverage::create([
                        'coverage_id' => $coverage_id,
                        'conservation_unit_id' => $conservartion_unit->id,
                    ]);
                }

            }
            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            dd($exception);
            throw new Exception($exception);
        }
    }

}
