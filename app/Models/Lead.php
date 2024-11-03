<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'created_by', 'id');
    }

    public function project()
    {
        return $this->hasMany(Project::class)->select('id','lead_id', 'project_name','project_value','project_duration', 'status','created_by', 'date');
    }

    public function created_by(){
        return $this->belongsTo(User::class,'created_by', 'id')->select('id', 'name');
    }
}
