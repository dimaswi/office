<?php

namespace App\Filament\Resources\CutiResource\Pages;

use App\Filament\Resources\CutiResource;
use App\Models\Bagian;
use App\Models\Unit;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCuti extends CreateRecord
{
    protected static string $resource = CutiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $unit = Unit::where('id', auth()->user()->unit)->first();
        $bagian = Bagian::where('id', $unit->bagian)->first();

        $data['karyawan'] = auth()->id();
        $data['kepala_unit'] = auth()->user()->unit;
        $data['kepala_bagian'] = $bagian->id;

        if ($unit->kepala_unit == auth()->user()->id) {
            $data['status'] = 2;
        } else if ($bagian->kepala_bagian == auth()->user()->id) {
            $data['status'] = 3;
        } else {
            $data['status'] = 1;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
