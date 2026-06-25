<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function outlets()
    {
        return $this->belongsToMany(
            Outlet::class,
            'outlet_income_categories'
        );
    }
}