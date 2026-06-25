<?php

namespace App\Filament\Resources\ExpenseVendorResource\Pages;

use App\Filament\Resources\ExpenseVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpenseVendors extends ListRecords
{
    protected static string $resource = ExpenseVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
