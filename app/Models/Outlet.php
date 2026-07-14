<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function incomeCategories()
    {
        return $this->belongsToMany(
            IncomeCategory::class,
            'outlet_income_categories'
        );
    }                                                                                   

    public function paymentMethods()
    {
        return $this->belongsToMany(
            PaymentMethod::class,
            'outlet_payment_methods'
        );
    }

    public function getIncomeItemsTemplate(): array
    {
        return $this->incomeCategories
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'amount' => 0,
                ];
            })
            ->values()
            ->toArray();
    }

    public function getPaymentItemsTemplate(): array
    {
        return $this->paymentMethods
            ->map(function ($method) {
                return [
                    'method_name' => $method->name,
                    'amount' => 0,
                ];
            })
            ->values()
            ->toArray();
    }
}