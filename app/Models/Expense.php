<?php

namespace App\Models;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(ExpenseCategory::class,'category_id');
    }
}
