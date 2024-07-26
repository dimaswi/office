<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use App\Models\Rapat;
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
            ->body(auth()->user()->name. ' Menambahkan rapat pada hari '. $jam_rapat)
            ->sendToDatabase($user)
            // ->broadcast(User::role('Logistik')->get())
            ->toDatabase();
        }

        return $this->getResource()::getUrl('index');
    }
}
