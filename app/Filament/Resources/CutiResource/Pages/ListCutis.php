<?php

namespace App\Filament\Resources\CutiResource\Pages;

use App\Filament\Resources\CutiResource;
use App\Models\Bagian;
use App\Models\Cuti;
use App\Models\Unit;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCutis extends ListRecords
{
    protected static string $resource = CutiResource::class;

    protected function getHeaderActions(): array
    {
        if (auth()->user()->hasRole('Verifikator Cuti') and auth()->user()->hasRole('Kepala Unit') and auth()->user()->hasRole('Kepala Bagian')) {
            return [];
        } else {
            return [
                Actions\CreateAction::make()->label('Ajukan Cuti')->color('success')->icon('heroicon-o-plus-circle'),
            ];
        }
    }

    public function getTabs(): array
    {
        $unit = Unit::where('id', auth()->user()->unit)->first();
        $bagian = Bagian::where('id', $unit->bagian)->first();
        if (auth()->user()->hasRole('Kepala Unit') and auth()->user()->hasRole('Verifikator Cuti')) {
            return [
                'kepala_unit' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 4)->where('kepala_unit', auth()->user()->unit))->badge(Cuti::query()->where('status', 4)->where('kepala_unit', auth()->user()->unit)->count())->badgeColor('info'),
                'draft' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 0))->badge(Cuti::query()->where('status', 0)->where('karyawan', auth()->user()->id)->count())->badgeColor('info'),
                'review kabag' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 5))->badge(Cuti::query()->where('status', 5)->where('karyawan', auth()->user()->id)->count())->badgeColor('info'),
                'pengajuan' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 1))->badge(Cuti::query()->where('status', 1)->where('karyawan', auth()->user()->id)->count())->badgeColor('warning'),
                'setujui' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 2))->badge(Cuti::query()->where('status', 2)->where('karyawan', auth()->user()->id)->count())->badgeColor('success'),
                'ditolak' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 3))->badge(Cuti::query()->where('status', 3)->where('karyawan', auth()->user()->id)->count())->badgeColor('danger'),
            ];
        } else if (auth()->user()->hasRole('Kepala Bagian') and auth()->user()->hasRole('Verifikator Cuti')) {
            return [
                'kepala_bagian' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 5))->where('kepala_bagian', $bagian->id)->badge(Cuti::query()->where('status', 5)->where('kepala_bagian', $bagian->id)->count())->badgeColor('info'),
                'draft' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 0))->badge(Cuti::query()->where('status', 0)->where('karyawan', auth()->user()->id)->count())->badgeColor('info'),
                'pengajuan' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 1))->badge(Cuti::query()->where('status', 1)->where('karyawan', auth()->user()->id)->count())->badgeColor('warning'),
                'setujui' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 2))->badge(Cuti::query()->where('status', 2)->where('karyawan', auth()->user()->id)->count())->badgeColor('success'),
                'ditolak' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 3))->badge(Cuti::query()->where('status', 3)->where('karyawan', auth()->user()->id)->count())->badgeColor('danger'),
            ];
        } else if (auth()->user()->hasRole('Verifikator Cuti')) {
            return [
                'pengajuan' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 1))->badge(Cuti::query()->where('status', 1)->count())->badgeColor('warning'),
                'setujui' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 2))->badge(Cuti::query()->where('status', 2)->count())->badgeColor('success'),
                'ditolak' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 3))->badge(Cuti::query()->where('status', 3)->count())->badgeColor('danger'),
            ];
        } else {
            return [
                'draft' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 0))->badge(Cuti::query()->where('status', 0)->where('karyawan', auth()->user()->id)->count())->badgeColor('info'),
                'review kanit' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 4))->badge(Cuti::query()->where('status', 4)->where('karyawan', auth()->user()->id)->count())->badgeColor('info'),
                'review kabag' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 5))->badge(Cuti::query()->where('status', 5)->where('karyawan', auth()->user()->id)->count())->badgeColor('info'),
                'pengajuan' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 1))->badge(Cuti::query()->where('status', 1)->where('karyawan', auth()->user()->id)->count())->badgeColor('warning'),
                'setujui' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 2))->badge(Cuti::query()->where('status', 2)->where('karyawan', auth()->user()->id)->count())->badgeColor('success'),
                'ditolak' => Tab::make()
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 3))->badge(Cuti::query()->where('status', 3)->where('karyawan', auth()->user()->id)->count())->badgeColor('danger'),
            ];
        }
    }
}
