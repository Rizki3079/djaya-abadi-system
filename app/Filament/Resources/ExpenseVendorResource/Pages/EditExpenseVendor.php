<?php

namespace App\Filament\Resources\ExpenseVendorResource\Pages;

use App\Filament\Resources\ExpenseVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpenseVendor extends EditRecord
{
    protected static string $resource = ExpenseVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
