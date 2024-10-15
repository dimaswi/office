<?php

namespace App\Filament\Resources\RuangRapatResource\Pages;

use App\Filament\Resources\RuangRapatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRuangRapat extends EditRecord
{
    protected static string $resource = RuangRapatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
