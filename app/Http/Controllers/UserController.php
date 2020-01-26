<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Faculty;
use App\Role;
use App\Campus;
use App\Program;
use App\UserProgram;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
            ->join('roles', 'roles.id_role', '=', 'users.fk_role')
            ->select('users.*', 'roles.*')
            ->orderBy('users.id')
            ->get();
            
        $programs1 = DB::table('users')
            ->join('programs', 'programs.id_program', '=', 'users.fk_program1')
            ->select('users.*','programs.program_name', 'programs.id_program')
            ->orderBy('users.id')
            ->get();

        $programs2 = DB::table('users')
            ->join('programs', 'programs.id_program', '=', 'users.fk_program2')
            ->select('users.*','programs.program_name', 'programs.id_program')
            ->orderBy('users.id')
            ->get();

        return view('user.index', compact('users', 'programs1', 'programs2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = DB::table('users')
            ->join('roles', 'roles.id_role', '=', 'users.fk_role')
            ->select('users.*', 'roles.*')
            ->where('users.slug', '=', $slug)
            ->first();

        $program1 = DB::table('programs')
            ->join('users', 'programs.id_program', '=', 'users.fk_program1')
            ->select('users.*', 'programs.program_name', 'programs.id_program')
            ->where('users.slug', '=', $slug)
            ->first();

        $program2 = DB::table('programs')
            ->join('users', 'programs.id_program', '=', 'users.fk_program2')
            ->select('users.*', 'programs.program_name', 'programs.id_program')
            ->where('users.slug', '=', $slug)
            ->first();

        $programs = Program::all();
        $roles = Role::all();
        
        return view('user.show', compact('user', 'programs', 'program1', 'program2', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        if($request->ajax()){
            $user = User::where('slug', $slug)->first();
            $user->name             = $request->name;
            $user->lastname         = $request->lastname;
            $user->student_code     = $request->student_code;
            $user->city_residence   = $request->city_residence;
            $user->hometown         = $request->hometown;
            $user->nationality      = $request->nationality;
            $user->email            = $request->email;
            $user->fk_program1      = $request->fk_program1;
            $user->fk_program2      = $request->fk_program2;
            $user->fk_role          = $request->fk_role;
            $user->save();

            $program1 = Program::where('id_program', $user->fk_program1)->first();
            $program2 = Program::where('id_program', $user->fk_program2)->first();

            return response()->json([
                'user_name'     => $user->user_name,
                'lastname'      => $user->lastname,
                'student_code'  => $user->student_code,
                'city_residence'=> $user->city_residence,
                'hometown'      => $user->hometown,
                'nationality'   => $user->nationality,
                'email'         => $user->email,
                'fk_role'       => $user->fk_role,
                'program1'      => $program1->program_name,
                'program2'      => $program2->program_name,
            ]);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->first();
        $user->delete();

        return redirect()->route('usuarios.index');
    }
}
