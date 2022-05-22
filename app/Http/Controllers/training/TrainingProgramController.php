<?php

namespace App\Http\Controllers\training;

use App\Models\training\TrainingProgram;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TrainingProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('EnsureTokenIsValid');
        $this->middleware('EnsureTokenIsAdmin')->only('store');
    }
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
        $request->validate(['name'=>'required',
        'description'=>'required' ]);
        $currentUser = getCurrentUser();
        $program = TrainingProgram::create([
            'name'=>$request->name,
            'description' => $request->description,
            'uploader_id' => $currentUser->id]);
        return response()->json(['success' => true, 'message' =>$program],201);  
    }
    public function storeExercises(Request $request, $trainingProgram)
    {
        $program = TrainingProgram::where('name',$trainingProgram)->first();
        if(!$program)
            return response()->json(['message'=>'no program with that name'],404);
        
        $request->validate([
            'name'=>'required|exists:exercises,name',
            'reps'=>'required',
            'sets'=>'required',
            'day'=>'required']);

        $workout = DB::table("program_has_exercises")->insert([
            [
                'program_id'=>$program->id,
                'exercise_name'=>$request->name,
                'sets'=>$request->sets,
                'day'=>$request->day,
                'reps'=>$request->reps,
                'order'=>$request->order?$request->order:1,
            ]
        ]);
        return response()->json(['success' => true],201);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingProgram  $trainingProgram
     * @return \Illuminate\Http\Response
     */
    public function show($trainingProgram)
    {
        $trainingProgram = TrainingProgram::where('name',$trainingProgram)->first();
        if(!$trainingProgram)
            return response()->json(['message'=>'no program with that name'],404);
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
