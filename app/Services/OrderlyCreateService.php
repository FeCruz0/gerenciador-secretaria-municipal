<?php

namespace App\Services;

use App\Models\Orderly;
use App\Models\OrderlyUser;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\NotificationCreateService;

class OrderlyCreateService
{
    public function __construct(
        protected OrderlyService $orderlyService,
        protected NotificationCreateService $notificationCreateService,
    ) {
        //
    }

    public function create(array $request)
    {
        try {
            DB::beginTransaction();
            $orderly = $this->orderlyService->create($request);
            if(isset($request['cops'])){
                foreach ($request['cops'] as $cop) {
                    OrderlyUser::create(
                        [
                        'orderly_id' => $orderly->id,
                        'user_id' => $cop,
                        'status' => 'pré cadastrado',
                        ]
                    );
                    //fazer aqui envio de email e notificação ------------------------
                    $arrayNotification = [
                        "type_id" => 1,
                        "status_id" => 2,
                        "sender_id" => 1,
                        "title" => "VOCÊ FOI PRÉ CADASTRDADO! - " . Orderly::find($orderly->id)->title,
                        "users" => array(0 => $cop),
                        "content" => "Esteja na " . Orderly::find($orderly->id)->location . " na Data Marcada: " . Orderly::find($orderly->id)->started_at
                    ];
                    $this->notificationCreateService->create($arrayNotification);
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
