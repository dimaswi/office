<?php

namespace App\Http\Controllers\Rapat;

use App\Http\Controllers\Controller;
use App\Models\Notulen;
use App\Models\Rapat;
use App\Models\RuangRapat;
use App\Models\Unit;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HasilRapatController extends Controller
{
    public function __invoke(Rapat $rapat)
    {
        $unit = Unit::find($rapat->unit_id);
        $undangan = DB::table('undangan_rapats')
        ->join('users', 'users.id', '=', 'undangan_rapats.user_id')
        ->join('units', 'units.id', '=', 'users.unit')
        ->where('undangan_rapats.status', 1)
        ->where('undangan_rapats.rapat_id', $rapat->id)
        ->get();
        $kop_surat = base64_encode(file_get_contents(url('/images/'.$unit->kop)));
        $tempat_rapat = RuangRapat::where('id', $rapat->tempat_rapat)->first();
        $tanggal_rapat = $rapat->starts_at->isoFormat('dddd, D MMMM Y');
        $pimpinan_rapat = User::where('id', $rapat->user_id)->first();
        $qrcode_pimpinan = base64_encode(QrCode::format('svg')->merge('images/logo/logo.png', 0.4, true)->size(80)->errorCorrection('H')->generate($pimpinan_rapat->name));
        $notulensi = auth()->user()->name;
        $qrcode_notulensi = base64_encode(QrCode::format('svg')->merge('images/logo/logo.png', 0.4, true)->size(80)->errorCorrection('H')->generate($notulensi));
        $notulen = Notulen::where('rapat_id', $rapat->id)->get();
        $dokumentasi = base64_encode(file_get_contents(url('/images/'.$rapat->dokumentasi)));

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
        ->loadView('rapat.hasil.hasil',
        [
            'tempat_rapat' => $tempat_rapat,
            'data_rapat' => $rapat,
            'peserta' => $undangan,
            'kop' => 'data:image/png;base64,'.$kop_surat,
            'tanggal_rapat' => $tanggal_rapat,
            'qrcode_pimpinan' => $qrcode_pimpinan,
            'pimpinan' => $pimpinan_rapat,
            'qrcode_notulensi' => $qrcode_notulensi,
            'notulensi' => $notulensi,
            'notulen' => $notulen,
            'dokumentasi' => 'data:image/png;base64,'.$dokumentasi,
        ]
        )->download($rapat->agenda_rapat. '.pdf');
    }
}
