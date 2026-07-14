<?php

namespace App\Filament\Resources\BookkeepingResource\Pages;

use App\Filament\Resources\BookkeepingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookkeeping extends CreateRecord
{
    protected static string $resource = BookkeepingResource::class;

    protected function afterCreate(): void
    {
        $this->record->recalculateTotals();
    }
}