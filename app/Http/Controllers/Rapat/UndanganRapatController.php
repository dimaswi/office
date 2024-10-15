<?php

namespace App\Http\Controllers\Rapat;

use App\Http\Controllers\Controller;
use App\Models\Rapat;
use App\Models\RuangRapat;
use App\Models\UndanganRapat;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UndanganRapatController extends Controller
{
    public function __invoke(Rapat $rapat)
    {
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        $unit = Unit::find($rapat->unit_id);
        $pimpinan_rapat = User::where('id', $rapat->user_id)->first();
        $undangan = DB::table('undangan_rapats')
                    ->join('users', 'users.id', '=', 'undangan_rapats.user_id')
                    ->where('undangan_rapats.rapat_id', $rapat->id)
                    ->get();
        $tempat_rapat = RuangRapat::where('id', $rapat->tempat_rapat)->first();
        $kop_surat = base64_encode(file_get_contents(url('/images/'.$unit->kop)));
        $tanggal_undangan = $rapat->created_at->isoFormat('dddd, D MMMM Y');
        $tanggal_rapat = $rapat->starts_at->isoFormat('dddd, D MMMM Y');
        $qrcode = base64_encode(QrCode::format('svg')->merge('images/logo/logo.png', 0.4, true)->size(80)->errorCorrection('H')->generate($pimpinan_rapat->name));
        // dd(url("images/".$unit->kop));
        // dd($undangan);
        return Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ])->setHttpContext([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ])
        ->loadView('rapat.undangan.undangan',
        [
            'tempat_rapat' => $tempat_rapat,
            'data_rapat' => $rapat,
            'data_unit' => $unit,
            'undangan_rapat' => $undangan,
            'kop' => 'data:image/png;base64,'.$kop_surat,
            'tanggal_rapat' => $tanggal_rapat,
            'tanggal_undangan' => $tanggal_undangan,
            'pimpinan_rapat' => $pimpinan_rapat->name,
            'qr' => $qrcode,
        ]
        )->download($rapat->agenda_rapat. '.pdf');
    }
}
