<?php

namespace App\Console;
use Carbon\Carbon;
use App\Console\Commands\CleanChallenges;
use App\Models\comptitive\Challenge;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        CleanChallenges::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Challenge::create([
            //     'exercise_name' => "push up",
            //     'reps' => 4284,
            //     'player_one_id' => 3,
            // ]);


            $challenges = Challenge::where('state',0)->get();
            foreach ($challenges as $challenge) {
            if(Carbon::now()->diffInMinutes($challenge->created_at) >= 1)
            {
                $challenge->delete();
            }
        }

        })->everyMinute();

        // $schedule->command('clean:challenge')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
