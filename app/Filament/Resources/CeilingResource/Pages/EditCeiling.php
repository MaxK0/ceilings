<?php

namespace App\Filament\Resources\CeilingResource\Pages;

use App\Filament\Resources\CeilingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCeiling extends EditRecord
{
    protected static string $resource = CeilingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
