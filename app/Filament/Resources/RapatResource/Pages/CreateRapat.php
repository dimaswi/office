<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use App\Models\Rapat;
use App\Models\RuangRapat;
use App\Models\UndanganRapat;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Actions\Action;

class CreateRapat extends CreateRecord
{
    protected static string $resource = RapatResource::class;

    protected function beforeCreate(): void
    {
        $start = Carbon::parse($this->data['starts_at'])->format('Y-m-d H:i:s');
        $end = Carbon::parse($this->data['ends_at'])->format('Y-m-d H:i:s');
        $rapat = Rapat::whereDate('starts_at', '>=', $start)->whereDate('ends_at', '<=', $end)->first();
        $tempat_rapat_dibooking = RuangRapat::where('id', $this->data['tempat_rapat'])->first();

        // dd(!empty($jam));

        if (empty($jam)) {
            if ($rapat->tempat_rapat == $this->data['tempat_rapat']) {
                Notification::make()
                    ->title($tempat_rapat_dibooking->nama_ruang .' sudah dipakai!')
                    ->danger()
                    ->send();

                $this->halt();
            }
        }

        if (!empty($jam)) {
            if ($rapat->tempat_rapat == $this->data['tempat_rapat']) {
                Notification::make()
                    ->title($tempat_rapat_dibooking->nama_ruang .' sudah dipakai!')
                    ->danger()
                    ->send();

                $this->halt();
            }
        }

        // $jam_awal_dibooking = Rapat::whereBetween('starts_at', [$start, $end])->first();
        // $jam_akhir_dibooking = Rapat::whereBetween('ends_at', [$start, $end])->first();
        // dd($jam_awal_dibooking != null or $jam_akhir_dibooking != null);
        // if ($jam_awal_dibooking != null or $jam_akhir_dibooking != null) {
        //     dd($jam_awal_dibooking, $jam_akhir_dibooking);
        //     if ($jam_awal_dibooking->tempat_rapat == $this->data['tempat_rapat']  or $jam_akhir_dibooking->tempat_rapat == $this->data['tempat_rapat']) {
        //         Notification::make()
        //             ->title($tempat_rapat_dibooking->nama_ruang . ' sudah dipakai untuk rapat lainnya!')
        //             ->danger()
        //             ->send();

        //         $this->halt();
        //     }
        // }
    }

    protected function getRedirectUrl(): string
    {
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        $rapat = Rapat::where('unit_id', auth()->user()->unit)->orderBy('created_at', 'desc')->first();
        $undangan_rapat = UndanganRapat::where('rapat_id', $rapat->id)->get();
        $jam_rapat = $rapat->starts_at->isoFormat('dddd, D MMMM Y');

        foreach ($undangan_rapat as $undangan) {
            $user = User::where('id', $undangan->user_id)->first();
            Notification::make()
                ->title('Rapat Baru Ditambahkan')
                ->success()
                ->body(auth()->user()->name . ' mengundang anda rapat pada hari ' . $jam_rapat)
                ->sendToDatabase($user)
                // ->broadcast(User::role('Logistik')->get())
                ->toDatabase();
        }

        return $this->getResource()::getUrl('index');
    }
}
