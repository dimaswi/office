<?php

namespace App\Filament\Resources\KeluarResource\Pages;

use App\Filament\Resources\KeluarResource;
use App\Models\Keluar;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListKeluars extends ListRecords
{
    protected static string $resource = KeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah')->icon('heroicon-o-plus-circle')->color('success'),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('Surat Keluar');
    }

    public function getTabs(): array
    {
        $proses = Keluar::where('user', auth()->user()->id)->where('status', 0)->count();
        $setuju = Keluar::where('user', auth()->user()->id)->where('status', 1)->count();
        $revisi = Keluar::where('user', auth()->user()->id)->where('status', 2)->count();
        // dd($revisi);
        $masuk = Keluar::where('status', 0)->count();
        $selesai = Keluar::where('status', 1)->count();
        $revisi_direktur = Keluar::where('status', 2)->count();

        if (auth()->user()->hasRole('Direktur')) {
            return [
                'masuk' => Tab::make('Masuk')
                ->badge($masuk)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 0)),
                'selesai' => Tab::make('Selesai')
                ->badge($selesai)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1)),
                'revisi' => Tab::make('Revisi')
                ->badge($revisi_direktur)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 2)),

            ];
        } else {
            return [
                'proses' => Tab::make('Proses')
                ->badge($proses)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 0)->where('user', auth()->user()->id)),
                'revisi' => Tab::make('Revisi')
                ->badge($revisi)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 2)->where('user', auth()->user()->id)),
                'setuju' => Tab::make('Setuju')
                ->badge($setuju)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1)->where('user', auth()->user()->id)),
            ];
        }
    }
}
