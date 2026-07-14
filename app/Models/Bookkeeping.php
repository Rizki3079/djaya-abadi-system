<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookkeeping extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'user_id',
        'bookkeeping_date',
        'tax',
        'service',
        'owner_note_amount',
        'total_income',
        'total_non_cash',
        'total_expense',
        'cash_on_hand',
        'notes',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomeItems()
    {
        return $this->hasMany(BookkeepingIncomeItem::class);
    }

    public function paymentItems()
    {
        return $this->hasMany(BookkeepingPaymentItem::class);
    }

    public function expenseItems()
    {
        return $this->hasMany(BookkeepingExpenseItem::class);
    }

    public function recalculateTotals(): void
    {
        // Net Sales
        $netSales = $this->incomeItems()->sum('amount');

        // Total Pendapatan (Gross)
        $totalIncome =
            $netSales
            + $this->tax
            + $this->service;

        // Total Non Cash
        $totalNonCash = $this->paymentItems()->sum('amount');

        // Total Pengeluaran
        $totalExpense = $this->expenseItems()->sum('amount');

        // Cash On Hand
        $cashOnHand =
            $totalIncome
            - $totalNonCash
            - $totalExpense
            - $this->owner_note_amount;

        $this->update([
            'total_income' => $totalIncome,
            'total_non_cash' => $totalNonCash,
            'total_expense' => $totalExpense,
            'cash_on_hand' => $cashOnHand,
        ]);
    }
}