<?php

namespace App\Models\training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\training\Exercise;

class TrainingProgram extends Model
{
    use HasFactory;
    public function schedule()
    {
        $all = ProgramHasExercises::where('program_id',$this->id)->get();
        // foreach ($all as $element) {
        //     // $element->exercise_name = Exercise::find($element->exercise_name)->name;
        //     $element->exercise = Exercise::find($element->exercise_id);
        // }
        $days = $all->groupBy('day');
        return $days;
    }
    protected $fillable =[
        'name',
        'description',
        'uploader_id'
    ];
    
}
