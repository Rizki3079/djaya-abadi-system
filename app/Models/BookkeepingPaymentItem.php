<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookkeepingPaymentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookkeeping_id',
        'method_name',
        'amount',
    ];

    public function bookkeeping()
    {
        return $this->belongsTo(Bookkeeping::class);
    }
}