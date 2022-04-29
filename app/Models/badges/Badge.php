<?php

namespace App\Models\badges;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    public function rules()
    {
        return $this->hasMany(BadgeRule::class,'badge_name','name');
    }
    public function getRulesAttribute($value)
    {
        return $this->rules()->get();
    }


    public $timestamps = false;
    protected $fillable=[
        'name',
        'description',
        'image',
        'motivation',
    ];
    protected $hidden = [
        'pivot',
    ];
    protected $appends =[
        'rules',
    ];
    protected $primaryKey  = 'name';
    public $incrementing = false;
    protected $keyType = 'string';

}
