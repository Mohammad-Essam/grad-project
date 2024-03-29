<?php

namespace App\Http\Controllers;

use App\Models\comptitive\Challenge;
use App\Models\training\Record;
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

    //TODO: prevent my challenges from appearing to me
    public function index()
    {
        $currentUser = getCurrentUser();
        $challenges = Challenge::where('player_one_id','!=',$currentUser->id)->where('state',0)->get();
        return response()->json(['challenges'=>$challenges]);
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
        $challenge = Challenge::create([
            'exercise_name' => $request->exercise_name,
            'reps' => $request->reps,
            'player_one_id' => $currentUser->id,
        ]);
        return response()->json(['status' => true,'message'=>'wait for an oponent','id'=>$challenge->id],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\comptitive\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function accept($challenge_id)
    {
        $currentUser = getCurrentUser();
        $challenge = Challenge::where('id',$challenge_id)->first();
        if(!$challenge)
        return response()->json(['success'=>false,'message'=>'no challenge with that id'],404);

        if($challenge->player_one_id == $currentUser->id)
        {
            return response()->json(['success'=>false,'message'=>'you cant accept your own challenge'],401);
        }
        $challenge->state = 1;
        $challenge->player_two_id = $currentUser->id;
        $challenge->save();
        return response()->json(['success'=>true,'message'=>'accepted successfully'],201);
    }

    public function incrementScore($challenge_id)
    {
        $challenge = Challenge::where('id',$challenge_id)->first();
        $currentUser = getCurrentUser();
        if(!$challenge)
        return response()->json(['success'=>false,'message'=>'no challenge with that id'],404);

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
                $challenge->winner_username = User::where('id',$challenge->player_one_id)->first()->username;
                $challenge->save();    
                
                
                $win = true;
            }

            if($challenge->player_two_score >= $challenge->reps)
            {
                $challenge -> state = 2;
                $challenge->winner_username = User::where('id',$challenge->player_two_id)->first()->username;
                $challenge -> save();
                $win = true;
            }
            if($win)
            {
                //TODO: remove the 60 and put something real;
                $record = Record::create(['exercise_name'=>$challenge->exercise_name,
                                        'duration' => 60,
                                        'count' => intval($challenge->player_one_score),
                                        'user_id' => $challenge->player_one_id]
                                    );
                $record = Record::create(['exercise_name'=>$challenge->exercise_name,
                'duration' => 60,
                'count' => intval($challenge->player_two_score),
                'user_id' => $challenge->player_two_id]
            );
            
        
            }
        }

        return response()->json(['state'=>$challenge->state,'winner'=>$challenge->winner_username?$challenge->winner_username:""],201);
    }

    
    public function increase($challenge_id,Request $request)
    {
        $challenge = Challenge::where('id',$challenge_id)->first();
        $currentUser = getCurrentUser();
        if(!$challenge)
        return response()->json(['success'=>false,'message'=>'no challenge with that id'],404);
        $opponenetName = "";
        $opponentScore = 0;
        $myScore = 0;
        $myUsername = "";
        $win = false;
        if($challenge->state == 1)
        {
            //increase by one.
            if($challenge->player_one_id == $currentUser->id)
            {
                $challenge->player_one_score += $request->score;
                $challenge->save();
                $opponenetName = $challenge->playerTwo->username;
                $opponentScore = $challenge->player_two_score;
                $myScore = $challenge->player_one_score;
                $myUsername = $challenge->playerOne->username;
            }

            if($challenge->player_two_id == $currentUser->id)
            {
                $challenge->player_two_score += $request->score;
                $challenge->save();
                $opponenetName = $challenge->playerOne->username;
                $opponentScore = $challenge->player_one_score;
                $myScore = $challenge->player_two_score;
                $myUsername = $challenge->playerTwo->username;
            }

            if($challenge->player_one_score >= $challenge->reps)
            {
                $challenge->state = 2;
                $challenge->winner_username = User::where('id',$challenge->player_one_id)->first()->username;
                $challenge->save();    
                
                
                $win = true;
            }

            if($challenge->player_two_score >= $challenge->reps)
            {
                $challenge -> state = 2;
                $challenge->winner_username = User::where('id',$challenge->player_two_id)->first()->username;
                $challenge -> save();
                $win = true;
            }
            if($win)
            {
                //TODO: remove the 60 and put something real;
                $record = Record::create(['exercise_name'=>$challenge->exercise_name,
                                        'duration' => 60,
                                        'count' => intval($challenge->player_one_score),
                                        'user_id' => $challenge->player_one_id]
                                    );
                $record = Record::create(['exercise_name'=>$challenge->exercise_name,
                'duration' => 60,
                'count' => intval($challenge->player_two_score),
                'user_id' => $challenge->player_two_id]
            );
            }
        }
        if($challenge->state == 2)
        {
            if($challenge->player_one_id == $currentUser->id)
            {
                $opponenetName = $challenge->playerTwo->username;
                $opponentScore = $challenge->player_two_score;
                $myScore = $challenge->player_one_score;
                $myUsername = $challenge->playerOne->username;
            }
    
            if($challenge->player_two_id == $currentUser->id)
            {
                $opponenetName = $challenge->playerOne->username;
                $opponentScore = $challenge->player_one_score;
                $myScore = $challenge->player_two_score;
                $myUsername = $challenge->playerTwo->username;
            }
        }
        return response()->json(['state'=>$challenge->state,'winner'=>$challenge->winner_username?$challenge->winner_username:"",
        'opponent_name'=>$opponenetName, 'opponent_score' => $opponentScore,
        'my_username' => $myUsername, 'my_score' => $myScore],201);
    }


    public function show($challenge_id)
    {
        $myScore = 0;
        $myUsername = "";
        $opponenetName = "";
        $opponentScore = 0;
        $challenge = Challenge::where('id',$challenge_id)->first();
        if(!$challenge)
        return response()->json(['success'=>false,'message'=>'no challenge with that id'],404);

        $currentUser = getCurrentUser();

        if($challenge->player_one_id == $currentUser->id)
        {
            $opponenetName = $challenge->playerTwo->username;
            $opponentScore = $challenge->player_two_score;
            $myScore = $challenge->player_one_score;
            $myUsername = $challenge->playerOne->username;
        }

        if($challenge->player_two_id == $currentUser->id)
        {
            $opponenetName = $challenge->playerOne->username;
            $opponentScore = $challenge->player_one_score;
            $myScore = $challenge->player_two_score;
            $myUsername = $challenge->playerTwo->username;
        }

        return response()->json(['state'=>$challenge->state,'winner'=>$challenge->winner_username,
        'opponent_name'=>$opponenetName, 'opponent_score' => $opponentScore,
        'my_username' => $myUsername, 'my_score' => $myScore],201);
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
