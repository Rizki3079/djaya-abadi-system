<?php

namespace App\Filament\Resources\BookkeepingResource\Pages;

use App\Filament\Resources\BookkeepingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookkeeping extends EditRecord
{
    protected static string $resource = BookkeepingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
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
