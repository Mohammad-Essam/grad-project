<?php

namespace App\Http\Controllers\badges;

use App\Http\Controllers\Controller;
use App\Models\badges\Badge;
use App\Models\badges\BadgeRule;
use App\Models\training\Exercise;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function __construct() {
        $this->middleware('EnsureTokenIsAdmin')->only('store');
    }
    
    public function index()
    {
        //
        return response()->json(Badge::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'image'=>'required|mimes:png,jpg,jpeg,gif',
    ]);
    if($request->hasFile('image'))
     $path = $request->file('image')->store('media/badges');

        $badge = Badge::create(['name'=>$request->name,
        'image'=>$path,
        'description'=>$request->description,
        'motivation'=>$request->motivation
]);
        return response()->json($badge,200);
    }
    public function storeRule($name, Request $request)
    {
        $request->validate([
            'exercise_name'=>'required|exists:exercises,name',
            'count'=>'required'
        ]);
        if(Badge::where('name',$name)->exists())
        {
            $rule = BadgeRule::updateOrCreate([
                'badge_name' => $name,
                'exercise_name'=>$request->exercise_name,
            ],['count'=> $request->count]);
            return response()->json(['message'=>$rule?"success":"failed"],201);
        }
        else
        {
            return response()->json(['message'=>'no badge with that name'],404);
        }
    }
    public function show($name)
    {
        $badge = Badge::where('name',$name)->first();
        if(!$badge)
            return response()->json(['message'=>'no badge with this name'],404);
        return response()->json($badge,200);
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($name)
    {
        $badge = Badge::where('name',$name)->first();
        if(!$badge)
            return response()->json(['message'=>'no badge with this name'],404);
        $badge->delete();
        return response()->json(['message'=>'deleted successfully'],201);
    }
}
