<?php

namespace App\Filament\Resources\RuangRapatResource\Pages;

use App\Filament\Resources\RuangRapatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRuangRapat extends CreateRecord
{
    protected static string $resource = RuangRapatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
