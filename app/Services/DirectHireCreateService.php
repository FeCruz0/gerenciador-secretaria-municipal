<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;

class DirectHireCreateService
{
    public function __construct(
        protected DirectHireService $directHireService,
    ) {
    }

    public function create(array $request)
    {
        try {
            DB::beginTransaction();
            
            if (array_key_exists('value_min', $request)) {
                $request['value_min'] = $this->parseCurrency($request['value_min']);
            }
            if (array_key_exists('value_max', $request)) {
                $request['value_max'] = $this->parseCurrency($request['value_max']);
            }
    
            $this->directHireService->create($request);

            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            dd($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }

    private function parseCurrency($value)
    {
        if (is_null($value) || $value === '') {
            return null;
        }
        if (is_numeric($value)) {
            return floatval($value);
        }
        $strings_1 = ['.', 'R$ ', ','];
        $strings_2 = ['', '', '.'];
        return floatval(str_replace($strings_1, $strings_2, $value));
    }
}
