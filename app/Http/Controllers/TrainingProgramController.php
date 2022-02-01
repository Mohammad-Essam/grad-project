<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use App\Models\TrainingController;

class TrainingProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TrainingProgram::all(),200);
    }
    public function programsNames()
    {
        return response()->json(TrainingProgram::all()->pluck('name'),200);
    }
    public function day(TrainingProgram $trainingProgram, $day)
    {
        // if($trainingProgram[$day])
        //  $result = $trainingProgram[$day];
        // else
        //     $result = "rest day";
        // return response()->json($result,200);
        return response()->json($trainingProgram->schedule()[intval($day)] ,200);
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingProgram  $trainingProgram
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingProgram $trainingProgram)
    {
        return response()->json($trainingProgram->schedule(),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainingProgram  $trainingProgram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingProgram $trainingProgram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingProgram  $trainingProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingProgram $trainingProgram)
    {
        //
    }
}
