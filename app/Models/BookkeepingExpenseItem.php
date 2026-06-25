<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookkeepingExpenseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookkeeping_id',
        'expense_vendor_id',
        'invoice_number',
        'invoice_date',
        'payment_status',
        'description',
        'amount',
        'attachment',
    ];

    public function bookkeeping()
    {
        return $this->belongsTo(Bookkeeping::class);
    }

    public function expenseVendor()
    {
        return $this->belongsTo(ExpenseVendor::class);
    }
}