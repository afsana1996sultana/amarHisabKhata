<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseHead extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function expenseSubHeads(){
    //     return $this->hasMany(ExpenseSubhead::class, 'expense_head_id', 'id');
    // }
}
