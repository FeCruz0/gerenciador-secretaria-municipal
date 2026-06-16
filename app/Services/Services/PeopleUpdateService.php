<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeopleUpdateService
{
    public function __construct(
        protected UserService $userService,
        protected IndividualPeopleService $individualPeopleService,
        protected LegalPeopleService $legalPeopleService,
        protected DocumentService $documentService,
        protected PeopleService $peopleService,
        protected EmailService $emailService,
        protected PhoneService $phoneService,
        protected AddressService $addressService,
        //protected VehicleService $vehicleService,
    ) {
        //
    }
    
    public function update(array $request)
    {
        try {
            DB::beginTransaction();

            
            $userData = array_merge(
                $request,
                [
                    'name'      => $request['name'] ?? $request['company_name']
                ]
            );
            
            $this->peopleService->update($userData, $userData['people_id']);

            match ($request['person_type']) {
                'pj' => $this->legalPeopleService->update($userData, $userData['peopleable_id']),
                'pf' => $this->individualPeopleService->update($request, $userData['peopleable_id']),
            default => throw new Exception('Tipo de pessoal não selecionado')
            };

            //dd($userData['documents']);
            foreach ($request['documents']['document_type'] as $key => $documents) {
                $documentId = $request['documents']['id'][$key];
                if ($request['documents']['document'][$key]) {
                    $this->documentService->update(
                        [
                        'document_type_id' => $request['documents']['document_type'][$key],
                        'document' => $request['documents']['document'][$key],
                        ], $documentId
                    );
                }
            }
            
            foreach ($request['emails']['email'] as $key => $emails) {
                $emailId = $request['emails']['id'][$key];
                if ($request['emails']['email'][$key]) {
                    $this->emailService->update(
                        [
                        'email' => $request['emails']['email'][$key],
                        ], $emailId
                    );
                }
            }
            
            foreach ($request['phones']['phone'] as $key => $phones) {
                $phoneId = $request['phones']['id'][$key];
                if ($request['phones']['phone'][$key]) {
                    $this->phoneService->update(
                        [
                        'phone' => $request['phones']['phone'][$key],
                        ], $phoneId
                    );
                }
            }
            
            //tratando address como se fosse único, pq vai aparecer sempre como único
            $this->addressService->update($userData, $userData['people_id']);
            
            /*foreach ($request['vehicles']['type_vehicle_id'] as $key => $vehicles) {
                $vehicleId = $request['vehicles']['id'][$key];
                if ($request['vehicles']['license_plate'][$key]) {
                    $this->vehicleService->update(
                        [
                            'title' => $request['vehicles']['title'][$key],
                            'license_plate' => $request['vehicles']['license_plate'][$key],
                            'type_vehicle_id' => $request['vehicles']['type_vehicle_id'][$key],
                            'description' => $request['vehicles']['description'][$key],
                        ], $vehicleId
                    );
                }
            }*/

            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
