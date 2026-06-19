<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationStatus;
use App\Models\NotificationType;
use App\Models\NotificationUser;
use App\Models\Unit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class NotificationMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });
    }

    private function createNotificationSetup()
    {
        // Cria status obrigatórios
        $readStatus = NotificationStatus::create(['id' => 1, 'status' => 'Lida']);
        $notReadStatus = NotificationStatus::create(['id' => 2, 'status' => 'Não Lida']);
        
        // Cria tipo de notificação
        $type = NotificationType::create(['id' => 1, 'title' => 'Alerta Geral', 'active' => 1]);

        // Cria uma unit com web = true
        $org = Organization::create(['title' => 'Org', 'active' => 1]);
        Unit::create([
            'name' => 'Secretaria de Saúde',
            'sigla' => 'SESAU',
            'phone' => '12345678',
            'web' => true,
            'city_id' => 1,
            'organization_id' => $org->id,
        ]);

        return [$readStatus, $notReadStatus, $type];
    }

    public function test_admin_can_view_notification_index()
    {
        $user = User::factory()->create();
        list($readStatus, $notReadStatus, $type) = $this->createNotificationSetup();

        // Cria uma notificação para o usuário
        $notification = Notification::create([
            'type_id'      => $type->id,
            'status_id'    => $notReadStatus->id,
            'sender_id'    => $user->id,
            'title'        => 'Notificação de Teste',
            'content'      => 'Conteúdo da notificação.',
        ]);

        NotificationUser::create([
            'notification_id' => $notification->id,
            'user_id'         => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/notificacoes');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Notification/Index'));
    }

    public function test_admin_can_store_notification()
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();
        list($readStatus, $notReadStatus, $type) = $this->createNotificationSetup();

        $response = $this->actingAs($user)->post('/notificacoes', [
            'type_id'   => $type->id,
            'status_id' => $notReadStatus->id,
            'sender_id' => $user->id,
            'title'     => 'Nova Notificação',
            'content'   => 'Mensagem importante',
            'users'     => [$targetUser->id],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('notifications', [
            'title'     => 'Nova Notificação',
            'sender_id' => $user->id,
        ]);
        
        $notification = Notification::where('title', 'Nova Notificação')->first();
        $this->assertDatabaseHas('notification_user', [
            'notification_id' => $notification->id,
            'user_id'         => $targetUser->id,
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();
        $this->createNotificationSetup();

        $response = $this->actingAs($user)->post('/notificacoes', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['type_id', 'status_id', 'sender_id', 'title']);
    }

    public function test_admin_can_update_notification()
    {
        $user = User::factory()->create();
        list($readStatus, $notReadStatus, $type) = $this->createNotificationSetup();

        $notification = Notification::create([
            'type_id'      => $type->id,
            'status_id'    => $notReadStatus->id,
            'sender_id'    => $user->id,
            'title'        => 'Notificação Original',
            'content'      => 'Mensagem original',
        ]);

        $response = $this->actingAs($user)->put("/notificacoes/{$notification->id}", [
            'notification_id' => $notification->id,
            'type_id'         => $type->id,
            'status_id'       => $readStatus->id,
            'sender_id'       => $user->id,
            'title'           => 'Notificação Editada',
            'content'         => 'Mensagem editada',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('notifications', [
            'id'        => $notification->id,
            'title'     => 'Notificação Editada',
            'status_id' => $readStatus->id,
        ]);
    }

    public function test_admin_can_delete_notification()
    {
        $user = User::factory()->create();
        list($readStatus, $notReadStatus, $type) = $this->createNotificationSetup();

        $notification = Notification::create([
            'type_id'      => $type->id,
            'status_id'    => $notReadStatus->id,
            'sender_id'    => $user->id,
            'title'        => 'Notificação para Deletar',
            'content'      => 'Apague-me',
        ]);

        $response = $this->actingAs($user)->delete("/notificacoes/{$notification->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('notifications', [
            'id' => $notification->id,
        ]);
    }

    public function test_admin_can_mark_notification_as_read()
    {
        $user = User::factory()->create();
        list($readStatus, $notReadStatus, $type) = $this->createNotificationSetup();

        $notification = Notification::create([
            'type_id'      => $type->id,
            'status_id'    => $notReadStatus->id,
            'sender_id'    => $user->id,
            'title'        => 'Notificação não lida',
            'content'      => 'Ainda pendente',
        ]);

        $response = $this->actingAs($user)->get("/notification/readed/{$notification->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('notifications', [
            'id'        => $notification->id,
            'status_id' => 1, // ID do status 'Lida'
        ]);
    }

    public function test_unauthenticated_user_cannot_access_notifications()
    {
        $response = $this->get('/notificacoes');

        $response->assertRedirect('/login');
    }
}
