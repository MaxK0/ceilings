<?php

namespace App\Filament\Resources\CeilingResource\Pages;

use App\Filament\Resources\CeilingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCeilings extends ListRecords
{
    protected static string $resource = CeilingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
