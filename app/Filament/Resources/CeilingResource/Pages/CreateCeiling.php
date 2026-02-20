<?php

namespace App\Filament\Resources\CeilingResource\Pages;

use App\Filament\Resources\CeilingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCeiling extends CreateRecord
{
    protected static string $resource = CeilingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
