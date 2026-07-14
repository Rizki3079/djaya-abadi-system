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
        $this->record->recalculateTotals();
    }
}
