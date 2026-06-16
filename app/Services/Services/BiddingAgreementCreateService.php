<?php

namespace App\Services;

use App\Models\AgreementFile;
use App\Models\BiddingAgreementFile;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\File;

class BiddingAgreementCreateService
{
    public function __construct(
        protected BiddingAgreementService $biddingAgreementService,
    ) {
        //
    }

    public function create(array $request)
    {
        try {
            DB::beginTransaction();
            
            $file = File::create([
                'file_type_id' => '1',
                'title' => $request['file_title'],
                'url' => $request['path_file'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $agreement = $this->biddingAgreementService->create($request);
            
            BiddingAgreementFile::create([
                'bidding_agreement_id' => $agreement->id,
                'file_id' => $file->id
            ]);

            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            dd($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
