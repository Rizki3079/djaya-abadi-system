<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookkeepingIncomeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookkeeping_id',
        'name',
        'amount',
    ];

    public function bookkeeping()
    {
        return $this->belongsTo(Bookkeeping::class);
    }
}