<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PeopleCreateService
{
    // @codingStandardsIgnoreStart
    // TODO: CSFix
    public function __construct(
        protected UserService $userService,
        protected IndividualPeopleService $individualPeopleService,
        protected LegalPeopleService $legalPeopleService,
        protected PeopleService $peopleService,
        protected EmailService $emailService,
        protected PhoneService $phoneService,
        protected AddressService $addressService,
        protected PeoplePeopleTypeService $peoplePeopleTypeService,
    ) {
        //
    }
    // @codingStandardsIgnoreEnd

    public function create(array $request)
    {
        try {
            DB::beginTransaction();
            $userData = array_merge(
                $request,
                [
                    'password'  => Str::random(8),
                    'name'      => $request['name'] ?? $request['company_name']
                ]
            );
            $people = match ($request['peopleable_type']) {
                'pj' => $this->legalPeopleService->create($userData),
                'pf' => $this->individualPeopleService->create($request),
            default => throw new Exception('Tipo de pessoal não selecionado')
            };
            
                $people->peopleable()->create($userData);
                foreach ($request['documents']['document_type'] as $key => $documents) {
                    if ($request['documents']['document'][$key]) {
                        $people->peopleable->documents()->create(
                            [
                            'document_type_id' => $request['documents']['document_type'][$key],
                            'document' => $request['documents']['document'][$key],
                            ]
                        );
                    }
                }

                $people_id = $people->peopleable->id;
                $email = $this->emailService->create(
                    array_merge(
                        $request,
                        $userData,
                        compact('people_id')
                    )
                );
                
                if($request['phone']){ 
                    $phone = $this->phoneService->create(
                        array_merge(
                            $request,
                            $userData,
                            compact('people_id')
                        )
                    );
                }

                if($request['city_id']){ 
                    $address = $this->addressService->create(
                        array_merge(
                            $request,
                            $userData,
                            compact('people_id')
                        )
                    );
                }

                $people_type = $this->peoplePeopleTypeService->create(
                    array_merge(
                        $request,
                        $userData,
                        compact('people_id')
                    )
                );

            DB::commit();
        } catch (Exception $exception) {
            dd($exception);
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
        return $people_id;
    }
}
