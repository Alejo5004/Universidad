<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Role::where('id_role', Auth::user()->fk_role)->first();

        if($role->role_name == 'Estudiante'){
            return redirect()->route('usuarios.show', [Auth::user()->slug]);
        }else{
            return redirect()->route('usuarios.index');
        }
    }
}
