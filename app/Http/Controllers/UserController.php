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
        $users = User::all();
        return view('user.index', compact('users'));
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
        if($request->ajax()){
            $user = new User;
            $user->user_name = $request->user_name;
            $user->lastname = $request->lastname;
            $user->student_code = $request->student_code;
            $user->city_residence = $request->city_residence;
            $user->hometown = $request->hometown;
            $user->nationality = $request->nationality;
            $user->email = $request->email;
            $user->save();

            return response()->json([
                'id'        => $user->user_name,
                'name'      => $user->lastname,
                'name'      => $user->student_code,
                'name'      => $user->city_residence,
                'name'      => $user->hometown,
                'name'      => $user->nationality,
                'address'   => $user->email]);
        };
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
            ->first();

        $userProgram = UserProgram::where('fk_user', $user->id)->get();
        $programs = Program::all();
        $roles = Role::all();

        return view('user.show', compact('user', 'userProgram', 'programs', 'roles'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
