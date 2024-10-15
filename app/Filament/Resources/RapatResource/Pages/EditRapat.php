<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use App\Models\Notulen;
use App\Models\Rapat;
use App\Models\UndanganRapat;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRapat extends EditRecord
{
    protected static string $resource = RapatResource::class;

    protected function getHeaderActions(): array
    {
        // dd($this->record);
        return [
            Actions\Action::make('Detail')->icon('heroicon-o-information-circle')->url(
                function (Rapat $record) {
                    return RapatResource::getUrl('view', ['record' => $record->id]);
                },
            ),
            Actions\DeleteAction::make()->modalHeading('Hapus Semua Data Rapat?')
                ->action(function (Rapat $record,  \Filament\Actions\DeleteAction $action) {
                    UndanganRapat::where('rapat_id', $record->id)->delete();
                    Notulen::where('rapat_id', $record->id)->delete();
                    $record->delete();
                    $action->success();
                }),
        ];
    }
}
