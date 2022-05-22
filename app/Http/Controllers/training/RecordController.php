<?php

namespace App\Http\Controllers\training;

use App\Http\Controllers\Controller;
use App\Models\badges\Badge;
use App\Models\training\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\training\Record;
use Illuminate\Support\Facades\DB;

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
            $exercise = Exercise::where('name',$request->exercise_name)->first();
            $exercise_name = $exercise->name;
            $record = Record::create(['exercise_name'=>$exercise_name,
                                        'duration' => intval($request->duration),
                                        'count' => intval($request->count),
                                        'user_id' => $currentUser->id]
                                    );
            $currentUser = getCurrentUser();
            $currentUser->exp += $exercise->exp * intval($request->count);
            $currentUser->save();
            
            $exercised = $currentUser->exercised()
                ->select('exercise_name','count','duration')->get()
                ->groupBy('exercise_name')
                ->map(function ($exercise){
                $totalCount = 0;
                foreach ($exercise as $ex) {
                    $totalCount += $ex->count;
                }            
                return $totalCount;
                });
            $badges = collect([]);
            $c = 0;
            foreach (Badge::all() as $badge) {
                $flag = true;
                $badge->makeHidden(['rules']);
                foreach ($badge->rules as $rule) {
                    if($exercised->has($rule->exercise_name))
                     {
                       if($exercised[$rule->exercise_name] < $rule->count)
                        {
                            $flag = false;
                            break;
                        }
                    }
                    else
                        {
                            $flag = false;
                            break;
                        }
                }
                if($flag) 
                {   
                    $already = DB::table('user_has_badges')
                        ->where('user_id',$currentUser->id)
                        ->where('badge_name',$badge->name)->first();
                        
                    if($already== null)
                    {
                        $badges[$c++] = $badge;
                        DB::table('user_has_badges')->insert([
                                [
                                    'user_id'=>$currentUser->id,
                                    'badge_name'=>$badge->name,
                                    'status'=>0,
                                ]
                            ]);
                    }
                }
            }
            
            if($c>0)
                return response()->json(['success' => true, 'message' => $record,'granted_badges' => $badges],201);
            else
			    return response()->json(['success' => true, 'message' => $record],201);
    }

    public function index()
    {
        $currentUser = getCurrentUser();
        $exercised = $currentUser->exercised()
            ->select('exercise_name','count','duration')->get();
        return $exercised->groupBy('exercise_name')
            ->map(function ($exercise){
            $totalCount = 0;
            foreach ($exercise as $ex) {
                $totalCount += $ex->count;
            }            
            return $totalCount;
        });
    }

}
