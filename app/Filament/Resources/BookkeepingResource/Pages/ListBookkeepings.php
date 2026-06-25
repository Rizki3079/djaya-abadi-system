<?php

namespace App\Filament\Resources\BookkeepingResource\Pages;

use App\Filament\Resources\BookkeepingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookkeepings extends ListRecords
{
    protected static string $resource = BookkeepingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
