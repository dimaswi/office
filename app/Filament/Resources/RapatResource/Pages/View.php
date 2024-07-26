<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use App\Models\Rapat;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class View extends ViewRecord
{
    protected static string $resource = RapatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\Action::make('keputusan')->icon('heroicon-o-chat-bubble-bottom-center-text')->form([
            //     TextInput::make('keputusan_rapat')
            //         ->label('Keputusan')
            //         ->placeholder('Masukan Keputusan Rapat')
            //         ->required(),
            // ])
            //     ->action(function (array $data, Rapat $record): void {
            //         Rapat::where('id', $record->id)->update([
            //             'keputusan_rapat' => $data['keputusan_rapat']
            //         ]);

            //         Notification::make()
            //             ->title('Berhasil Disimpan!')
            //             ->success()
            //             ->send();
            //     }),
            Actions\Action::make('undangan_rapat')
                ->label('Undangan Rapat')
                ->icon('heroicon-o-envelope')
                ->color('warning')
                ->url(fn (Rapat $record) => route('rapat.undangan', $record)),
            Actions\Action::make('hasil_rapat')
                ->label('Hasil Rapat')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->url(fn (Rapat $record) => route('rapat.hasil', $record)),
            Actions\Action::make('dokumentasi')->label('Dokumentasi')->icon('heroicon-o-camera')
                ->url(
                    function (Rapat $record) {
                        return RapatResource::getUrl('edit', ['record' => $record->id]);
                    }
                ),
            Actions\Action::make('daftar_hadir')->label('Daftar Hadir')->icon('heroicon-o-user-group')->url(
                function (Rapat $record) {
                    return RapatResource::getUrl('daftar_hadir', ['record' => $record->id]);
                },
            ),
            Actions\Action::make('notulen')->icon('heroicon-o-clipboard-document-list')->url(
                function (Rapat $record) {
                    return RapatResource::getUrl('notulen', ['record' => $record->id]);
                },
            ),
            Actions\EditAction::make()->label('Edit')->icon('heroicon-o-pencil-square')->color('warning'),
        ];
    }
}
