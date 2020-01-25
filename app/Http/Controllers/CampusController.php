<?php

namespace App\Http\Controllers;

use App\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campuses = Campus::all();
        return view('campus.index', compact('campuses'));
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

            $campus = new Campus;
            $campus->campus_name = $request->campus_name;
            $campus->campus_address = $request->campus_address;
            $campus->save();

            return response()->json(['id'=> $campus->id, 'name' => $campus->campus_name, 'address' => $campus->campus_address]);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function show(campus $campus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function edit(campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){

            $campus = Campus::where('id', $id)->first();
            $campus->campus_name = $request->campus_name;
            $campus->campus_address = $request->campus_address;
            $campus->save();

            $campuses = Campus::all();

            return response()->json(['campuses'=> $campuses]);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campus = Campus::where('id', $id)->first();
        $campus->delete();

        return redirect()->route('campus.index');
    }
}
