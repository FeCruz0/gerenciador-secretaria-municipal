<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Models\User;
use App\Models\Organ;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Role as ModelsRole;
use Inertia\Inertia;

class UsersController extends Controller
{

    public function index()
    {
        if (! Gate::allows('Ver e Listar Usuários')) {
            abort(403, 'This action is unauthorized.');
        }

        $users = User::with(['roles', 'organ'])->get();

        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        if (! Gate::allows('Criar Usuários')) {
            abort(403, 'This action is unauthorized.');
        }

        $roles = ModelsRole::with('permissions')->get();
        $organs = Organ::where('is_active', true)->get(['id', 'name', 'sigla']);

        return Inertia::render('Users/Create', [
            'roles' => $roles,
            'organs' => $organs
        ]);
    }

    public function store(StoreUsersRequest $request)
    {
        if (! Gate::allows('Criar Usuários')) {
            abort(403, 'This action is unauthorized.');
        }

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];

        if (app()->bound('active_organ')) {
            $data['organ_id'] = app('active_organ')->id;
        } else {
            $data['organ_id'] = $request->input('organ_id');
        }

        $user = User::create($data);
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        if (! Gate::allows('Editar Usuários')) {
            abort(403, 'This action is unauthorized.');
        }

        $user->load('roles');
        $roles = ModelsRole::with('permissions')->get();
        $organs = Organ::where('is_active', true)->get(['id', 'name', 'sigla']);

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'roles' => $roles,
            'organs' => $organs
        ]);
    }

    public function update(UpdateUsersRequest $request, User $user): RedirectResponse
    {
        if (! Gate::allows('Editar Usuários')) {
            abort(403);
        }
        $update = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];
        if ($request->input('password')) {
            $update['password'] = Hash::make($request->input('password'));
        }

        if (app()->bound('active_organ')) {
            $update['organ_id'] = app('active_organ')->id;
        } else {
            $update['organ_id'] = $request->input('organ_id');
        }

        $user->update($update);

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        if (! Gate::allows('Ver e Listar Usuários')) {
            abort(403, 'This action is unauthorized.');
        }

        $user->load('roles');

        return Inertia::render('Users/Show', [
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        if (! Gate::allows('Deletar Usuários')) {
            abort(403, 'This action is unauthorized.');
        }

        $user->delete();

        return redirect()->route('users.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('Deletar Usuários')) {
            abort(403, 'This action is unauthorized.');
        }

        User::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}