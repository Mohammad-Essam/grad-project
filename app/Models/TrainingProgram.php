<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Exercise;

class TrainingProgram extends Model
{
    use HasFactory;
    public function schedule()
    {
        $all = DB::table('program_has_exercise')->where('program_id',$this->id)->get();
        foreach ($all as $element) {
            $element->exercise_name = Exercise::find($element->exercise_id)->name;
            $element->exercise = Exercise::find($element->exercise_id);
        }
        $days = $all->groupBy('day');
        return $days;
    }
}
