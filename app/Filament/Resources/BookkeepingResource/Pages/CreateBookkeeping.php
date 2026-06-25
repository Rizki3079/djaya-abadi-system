<?php

namespace App\Filament\Resources\BookkeepingResource\Pages;

use App\Filament\Resources\BookkeepingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookkeeping extends CreateRecord
{
    protected static string $resource = BookkeepingResource::class;

    protected function afterCreate(): void
    {
        $this->record->update([
            'total_income' => $this->record->incomeItems()->sum('amount'),
            'total_non_cash' => $this->record->paymentItems()->sum('amount'),
            'total_expense' => $this->record->expenseItems()->sum('amount'),
        ]);

        $this->record->update([
            'cash_on_hand' =>
                $this->record->total_income
                - $this->record->total_non_cash
                - $this->record->total_expense
                - $this->record->owner_note_amount,
        ]);
    }
}