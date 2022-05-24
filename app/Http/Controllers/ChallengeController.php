<?php

namespace App\Http\Controllers;

use App\Models\comptitive\Challenge;
use App\Models\User;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware('EnsureTokenIsValid');
    }

    public function index()
    {
        return response()->json(Challenge::class);
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

        $request->validate([
            'exercise_name'=>'required|exists:exercises,name',
            'reps'=>'required',
        ]);
        $currentUser = getCurrentUser();
        Challenge::create([
            'exercise_name' => $request->exercise_name,
            'reps' => $request->reps,
            'player_one_id' => $currentUser->id,
        ]);
        return response()->json(['status' => true,'message'=>'wait for an oponent'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\comptitive\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function accept($challenge_id)
    {
        $challenge = Challenge::where('id',$challenge_id)->first();
        $challenge->state = 1;
        $challenge->save();
    }

    public function storeScore($challenge_id)
    {
        $challenge = Challenge::where('id',$challenge_id)->first();
        $currentUser = getCurrentUser();
        $win = false;
        if($challenge->state == 1)
        {
            //increase by one.
            if($challenge->player_one_id == $currentUser->id)
            {
                $challenge->player_one_score += 1;
                $challenge->save();
            }

            if($challenge->player_two_id == $currentUser->id)
            {
                $challenge->player_two_score += 1;
                $challenge->save();
            }

            if($challenge->player_one_score >= $challenge->reps)
            {
                $challenge->state = 2;
                $challenge->save();    
                $challenge->winner_username = User::where('id',$challenge->player_one_id)->first()->username;
                $win = true;
            }

            if($challenge->player_two_score >= $challenge->reps)
            {
                $challenge -> state = 2;
                $challenge -> save();
                $challenge->winner_username = User::where('id',$challenge->player_two_id)->first()->username;
                $win = true;
            }
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\comptitive\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\comptitive\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\comptitive\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        //
    }
}
