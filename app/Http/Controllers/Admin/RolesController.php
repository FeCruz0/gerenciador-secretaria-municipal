<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use App\Models\Role as ModelsRole;
use App\Models\Permission as ModelsPermission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Enums\Permission as PermissionEnum;

class RolesController extends Controller
{
    /**
     * Display a listing of ModelsRole.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        if (! Gate::allows('Ver e Listar Regras')) {
            abort(403, 'This action is unauthorized.');
        }

        $roles = ModelsRole::withCount('users')->with('permissions')->get();
        
        return Inertia::render('Roles/Index', [
            'roles' => $roles
        ]);
    }

    /**
     * Helper to group permissions by module comments or prefixes
     */
    private function getGroupedPermissions()
    {
        // Get all system permissions from database (to make sure IDs are correct)
        $dbPermissions = ModelsPermission::all();
        
        $grouped = [];
        foreach ($dbPermissions as $perm) {
            $group = $this->resolveGroup($perm->name);
            $grouped[$group][] = $perm;
        }

        ksort($grouped);
        return $grouped;
    }

    /**
     * Helper to resolve the group name for a given permission
     */
    private function resolveGroup(string $permissionName): string
    {
        if (str_contains($permissionName, 'Liderança')) return 'Liderança';
        if (str_contains($permissionName, 'Contratações Diretas')) return 'Contratações Diretas';
        if (str_contains($permissionName, 'Licitações')) return 'Licitações';
        if (str_contains($permissionName, 'Notícias')) return 'Notícias';
        if (str_contains($permissionName, 'Unidade de Conservacao') || str_contains($permissionName, 'Unidade de Conservação')) return 'Unidade de Conservação';
        if (str_contains($permissionName, 'Unidades')) return 'Unidades';
        if (str_contains($permissionName, 'Relatórios de Gestão')) return 'Relatórios de Gestão';
        if (str_contains($permissionName, 'Sobre')) return 'Sobre';
        if (str_contains($permissionName, 'Contratos')) return 'Contratos';
        if (str_contains($permissionName, 'Departamentos')) return 'Departamentos';
        if (str_contains($permissionName, 'Documentos')) return 'Documentos';
        if (str_contains($permissionName, 'E-mails')) return 'E-mails';
        if (str_contains($permissionName, 'Manifestações') || str_contains($permissionName, 'Ouvidoria')) return 'Manifestações / Ouvidoria';
        if (str_contains($permissionName, 'Projetos')) return 'Projetos';
        if (str_contains($permissionName, 'Banners')) return 'Banners';
        if (str_contains($permissionName, 'FAQ')) return 'FAQ';
        if (str_contains($permissionName, 'Galeria')) return 'Galeria';
        if (str_contains($permissionName, 'Notificações')) return 'Notificações';
        if (str_contains($permissionName, 'Atalhos Web')) return 'Atalhos Web';
        if (str_contains($permissionName, 'Usuários')) return 'Usuários';
        if (str_contains($permissionName, 'Módulos da Home')) return 'Módulos da Home';
        if (str_contains($permissionName, 'Entidades')) return 'Gerenciar Entidades';
        if (str_contains($permissionName, 'Regras') || str_contains($permissionName, 'Perfis')) return 'Regras e Perfis';
        if (str_contains($permissionName, 'Desenvolvedor')) return 'Desenvolvedor';

        return 'Outros';
    }


    /**
     * Show the form for creating new ModelsRole.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        if (! Gate::allows('Criar Regras')) {
            abort(403, 'This action is unauthorized.');
        }

        return Inertia::render('Roles/Create', [
            'permissionsGrouped' => $this->getGroupedPermissions()
        ]);
    }

    /**
     * Store a newly created ModelsRole in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreRolesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRolesRequest $request)
    {
        if (! Gate::allows('Criar Regras')) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();

            $role = ModelsRole::create([
                'name' => $request->input('name'),
                'guard_name' => 'web'
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->input('permissions'));
            }

            DB::commit();
            
            return redirect()->route('roles.index')->with('success', 'Regra criada com sucesso!');
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Erro ao criar a regra.');
        }
    }

    /**
     * Show the form for editing ModelsRole.
     *
     * @param  ModelsRole $role
     * @return \Inertia\Response
     */
    public function edit(ModelsRole $role)
    {
        if (! Gate::allows('Editar Regras')) {
            abort(403, 'This action is unauthorized.');
        }
        
        $role->load('permissions');

        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'permissionsGrouped' => $this->getGroupedPermissions()
        ]);
    }

    /**
     * Update ModelsRole in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateRolesRequest  $request
     * @param  ModelsRole $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRolesRequest $request, ModelsRole $role)
    {
        if (! Gate::allows('Editar Regras')) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();
            
            $role->update([
                'name' => $request->input('name')
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->input('permissions'));
            }

            DB::commit();
            
            return redirect()->route('roles.index')->with('success', 'Regra editada com sucesso!');
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Erro ao editar a regra.');
        }
    }

    /**
     * Remove ModelsRole from storage.
     *
     * @param  ModelsRole $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ModelsRole $role)
    {
        if (! Gate::allows('Deletar Regras')) {
            abort(403, 'This action is unauthorized.');
        }

        // Check if role is used by any users
        if ($role->users()->exists()) {
            return redirect()->back()->with('error', 'Esta regra não pode ser excluída pois está associada a usuários ativos.');
        }

        try {
            DB::beginTransaction();

            $role->delete();

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Regra deletada com sucesso!');
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao deletar a regra.');
        }
    }

    /**
     * Delete all selected ModelsRole at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('Deletar Regras')) {
            abort(403, 'This action is unauthorized.');
        }

        $roles = ModelsRole::whereIn('id', request('ids'))->get();
        
        foreach ($roles as $role) {
            if ($role->users()->exists()) {
                continue; // Skip deleting roles that have users
            }
            $role->delete();
        }

        return response()->noContent();
    }
}