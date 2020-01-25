<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faculty;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::all();

        return view('faculty.index', compact('faculties'));
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
            $faculty = new Faculty;
            $faculty->faculty_name          = $request->faculty_name;
            $faculty->faculty_description   = $request->faculty_description;
            $faculty->save();

            return response()->json([
                'id_faculty'            => $faculty->id_faculty,
                'faculty_name'          => $faculty->faculty_name,
                'faculty_description'   => $faculty->faculty_description,
            ]);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if($request->ajax()){

            $faculty = Faculty::where('id_faculty', $id)->first();
            $faculty->faculty_name          = $request->faculty_name;
            $faculty->faculty_description   = $request->faculty_description;
            $faculty->save();

            $faculties = Faculty::all();

            return response()->json(['faculties'=> $faculties]);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Faculty::destroy($id);

        return redirect()->route('facultades.index');
    }
}
