<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\comptitive\Challenge;
use Illuminate\Console\Command;

class CleanChallenges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:challenge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $MINUTES = 1;
        $challenges = Challenge::where('state',0)->get();
        foreach ($challenges as $challenge) {
            // echo $now->diffInMinutes($challenge->created_at)."\n";
            // $difference = time() - $challenge->created_at ;
            // if($difference > 1)
            // {
            //     $challenge->delete();
            // }
            if(Carbon::now()->diffInMinutes($challenge->created_at) >= $MINUTES)
            {
                $challenge->delete();
            }
        }
        return 0;
    }
}
