<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'name');
    }

    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id', 'id');
    }
}

