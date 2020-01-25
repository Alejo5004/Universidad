<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Program;
use App\Campus;
use App\Faculty;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = DB::table('programs')
            ->join('faculties', 'programs.fk_faculty', '=', 'faculties.id_faculty')
            ->join('campuses', 'programs.fk_campus', '=', 'campuses.id')
            ->select('programs.*', 'faculties.faculty_name', 'faculties.id_faculty', 'campuses.campus_name', 'campuses.id')
            ->get();
        $campuses = Campus::all();
        $faculties = Faculty::all();

        return view('program.index', compact('programs', 'campuses', 'faculties'));
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
            $program = new Program;
            $program->program_name  = $request->program_name;
            $program->modality      = $request->modality;
            $program->status        = $request->status;
            $program->fk_faculty    = $request->fk_faculty;
            $program->fk_campus     = $request->fk_campus;
            $program->save();

            $faculty = DB::table('faculties')
                ->join('programs', 'programs.fk_faculty', '=', 'faculties.id_faculty')
                ->select('faculties.faculty_name')
                ->where('faculties.id_faculty', $program->fk_faculty)
                ->first();

            $campus = DB::table('campuses')
                ->join('programs', 'programs.fk_campus', '=', 'campuses.id')
                ->select('campuses.campus_name')
                ->where('campuses.id', $program->fk_campus)
                ->first();

            return response()->json([
                'id_program'    => $program->id_program,
                'program_name'  => $program->program_name,
                'modality'      => $program->modality,
                'status'        => $program->status,
                'faculty_name'  => $faculty->faculty_name,
                'campus_name'   => $campus->campus_name,
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

            $program = Program::where('id_program', $id)->first();
            $program->program_name  = $request->program_name;
            $program->modality      = $request->modality;
            $program->status        = $request->status;
            $program->fk_faculty    = $request->fk_faculty;
            $program->fk_campus     = $request->fk_campus;
            $program->save();

            // $programs = Program::all();
            $programs = DB::table('programs')
                ->join('faculties', 'programs.fk_faculty', '=', 'faculties.id_faculty')
                ->join('campuses', 'programs.fk_campus', '=', 'campuses.id')
                ->select('programs.*', 'faculties.faculty_name', 'faculties.id_faculty', 'campuses.campus_name', 'campuses.id')
                ->get();

            return response()->json(['programs'=> $programs]);
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
        Program::destroy($id);

        return redirect()->route('programas.index');
    }
}
