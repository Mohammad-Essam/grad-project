<?php

namespace App\Http\Controllers\training;

use App\Http\Controllers\Controller;
use App\Models\training\Exercise;
use Illuminate\Http\Request;
use App\Models\training\Record;

class RecordController extends Controller
{
	public function __construct()
    {
        $this->middleware('EnsureTokenIsValid');
    }
//TODO: increase user level and check if he earned some badges
    public function store(Request $request)
    {
			$request->validate(['exercise_name'=>'required|exists:exercises,name',
            'count'=>'required','duration'=>'required']);
			$currentUser = getCurrentUser();
            $exercise_id = Exercise::where('name',$request->exercise_name)->id;
            $record = Record::create(['exercise_id'=>$exercise_id,
                                        'duration'=>$request->duration,
                                        'count' => $request->count,
                                        'user_id' => $currentUser->id]);
			return response()->json(['success' => true, 'message' => $record],201);
    }

}
