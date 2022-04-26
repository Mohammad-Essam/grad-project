<?php

namespace App\Http\Controllers\training;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\training\Exercise;
class ExerciseController extends Controller
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
        return response()->json(['exercises'=>Exercise::all()],200);    
    }

    public function exercisesNames()
    {
        return response()->json(['exercisesNames'=>Exercise::all()->pluck('name')],200);    
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			$request->validate(['name'=>'required',
            'video'=>'required|mimes:mp4,mov,ogg,qt,mkv,flv',
            'description'=>'required','exp'=>'required' ]);
			$currentUser = getCurrentUser();
            if($request->hasFile('video'))
             $path = $request->file('video')->store('media/exercises');

             $exercise = Exercise::create(['name'=>$request->name,
                                            'video'=>$path,
                                            'description' => $request->description,
                                            'uploader_id' => $currentUser->id,
                                            'exp'=>$request->exp]);
			return response()->json(['success' => true, 'message' => $exercise],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($exercise)
    {
        $exercise = Exercise::where('name',$exercise)->first();
        if(!$exercise)
            return response()->json(['message'=>'no exercise with that name'],404);
        return response()->json($exercise,200);     
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
