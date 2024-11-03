<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function expenseHead(){
        return $this->belongsTo(ExpenseHead::class,'expense_head_id', 'id')->select('id', 'title');
    }

    public function expenseSubHead(){
        return $this->belongsTo(ExpenseSubhead::class,'expense_subhead_id', 'id')->select('id', 'expense_head_id', 'title');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id')->select('id', 'project_name');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'name');
    }
}
