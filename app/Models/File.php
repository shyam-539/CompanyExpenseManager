<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['expense_id', 'file'];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
    
    use HasFactory;
}
