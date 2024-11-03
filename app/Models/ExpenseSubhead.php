<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSubhead extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function expenseHead(){
    	return $this->belongsTo(ExpenseHead::class,'expense_head_id', 'id');
    }

    public function expenses(){
        return $this->hasMany(Expense::class, 'expense_subhead_id', 'id');
    }
}
