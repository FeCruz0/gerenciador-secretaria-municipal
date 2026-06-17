<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $pageConfigs = ['blankPage' => true];

        return Inertia::render('Auth/Register', [
            'pageConfigs' => $pageConfigs,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'active' => 0,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('status', 'Conta criada com sucesso! Aguarde a aprovação do administrador para acessar o sistema.');
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'active' => 0,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        
        $pageConfigs = ['pageHeader' => false];

        return view('admin/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
    }
}
