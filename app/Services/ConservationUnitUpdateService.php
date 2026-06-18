<?php

namespace App\Services;

use App\Models\ConservationUnit;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ConservationUnitCoverage;

class ConservationUnitUpdateService
{
    public function __construct(
        protected UserService $userService,
        protected BiddingService $biddingService,
        protected ConservationUnitService $conservationUnitService,
    ) {
        //
    }

    public function update(array $request, $conservation_unit_id)
    {
        try {
            DB::beginTransaction();

                $conservation_unit = ConservationUnit::find($conservation_unit_id);
                $old_path = $conservation_unit->thumb;

                $conservation_unit->title = $request['title'];
                $conservation_unit->conservation_unit_type_id = $request['conservation_unit_type_id'];
                $conservation_unit->creation = $request['creation'];
                $conservation_unit->creation_link = $request['creation_link'];
                $conservation_unit->objective = $request['objective'];
                $conservation_unit->area = $request['area'];
                $conservation_unit->localization = $request['localization'];
                $conservation_unit->address = $request['address'];
                $conservation_unit->phone = $request['phone'];
                $conservation_unit->email = $request['email'];
                $conservation_unit->opening_hours = $request['opening_hours'];
                $conservation_unit->thumb = isset($request['thumb']) ? $request['thumb']  : $old_path;
                $conservation_unit->thumb_description = $request['thumb_description'];
                $conservation_unit->status = $request['status'];
                $conservation_unit->save();


                $old_coverages = ConservationUnitCoverage::where('conservation_unit_id', $conservation_unit)->get();

                foreach($old_coverages as $forDelete){
                    $forDelete->forceDelete();
                }

                if(isset($request['coverages'])){
                    foreach ($request['coverages'] as $coverage_id) {

                        ConservationUnitCoverage::create([
                            'coverage_id' => $coverage_id,
                            'conservation_unit_id' => $conservation_unit_id,
                        ]);
                    }

                }

            DB::commit();
        } catch (Exception $exception) {
            dd($exception);
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
