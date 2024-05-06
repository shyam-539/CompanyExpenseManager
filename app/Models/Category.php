<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'tax_percentage'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    
    use HasFactory;
}
