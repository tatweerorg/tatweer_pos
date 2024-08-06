<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Pos\ExpenseController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(ExpenseController::class,'category_id');
    }
}
