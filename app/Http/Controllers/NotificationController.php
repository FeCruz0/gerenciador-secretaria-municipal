<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\NotificationStatus;
use App\Models\NotificationType;
use App\Models\NotificationUser;
use App\Models\Unit;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\NotificationCreateService;
use App\Services\NotificationUpdateService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService,
        protected NotificationCreateService $notificationCreateService,
        protected NotificationUpdateService $notificationUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Notificações')) {
            abort(403);
        }

        try{
            $unit = Unit::where('web', true)->first();
            //user notifications
            $notifications = Notification::with('users')->whereRelation('users', 'user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            $readeds = $notifications->where('status_id', 1)->values();
            $not_readeds = $notifications->where('status_id', '!=', 1)->values();
            $sendeds = Notification::where('sender_id', Auth::user()->id)->get();
            
            $statuses = NotificationStatus::orderBy('status', 'asc')->get();
            $types = NotificationType::orderBy('title', 'asc')->get();
            $users = User::with('person')->latest()->get(['id', 'email', 'people_id']);

            return Inertia::render('Notification/Index', [
                'unit'        => $unit,
                'readeds'     => $readeds,
                'not_readeds' => $not_readeds,
                'sendeds'     => $sendeds,
                'users'       => $users,
                'statuses'    => $statuses,
                'types'       => $types,
            ]);
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao procurar as notificações Cadastradas!',
            ]);
        }
    }
    
    public function update(
        NotificationRequest $request, $id = null
    ){
        if (! Gate::allows('Editar Notificações')) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            $this->notificationUpdateService->update($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Notificação editada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar a notificação!',
            ]);
        }
    }

    public function store(
        NotificationRequest $request
    ){
        if (! Gate::allows('Criar Notificações')) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            $this->notificationCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Notificação criada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar nova notificação!',
            ]);
        }
    }
    

    public function destroy($notification)
    {
        if (! Gate::allows('Deletar Notificações')) {
            abort(403);
        }

        try{
            $notificationModel = Notification::findOrFail($notification);
            $notificationModel->delete();

            return redirect()->route('notificacoes.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Notificação deletada com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar a notificação!',
            ]);
        }
    }
    
    public function changeReaded(int $idNotification)
    {
        try {
            DB::beginTransaction();
            
            $notification = Notification::findOrFail($idNotification);
            $notification->status_id = 1;
            $notification->save();

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Notificação marcada como lida!',
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao marcar notificação como lida!',
            ]);
        }
    }
}
