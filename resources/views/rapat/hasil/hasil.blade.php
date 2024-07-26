<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data_rapat->agenda_rapat }}</title>
</head>

<style>
    table,
    tr {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .center {
        margin-left: auto;
        margin-right: auto;
    }

    .row_atas {
        padding: 5px;
        text-align: left;
    }
</style>

<body
    style="margin-left: 10px; margin-right: 10px; margin-top: -6%; font-family: Arial, Helvetica, sans-serif; font-size: 11pt">

    <div style="text-align: left">
        <img src="{{ $kop }}" height="178" width="700" alt="">
    </div>

    <hr>

    <br>

    <div style="text-align: center; margin-top: 5px">
        <h1>
            <u>
                <b>
                    NOTULEN RAPAT
                </b>
            </u>
        </h1>
    </div>


    <table class="center">
        <tr>
            <td class="row_atas">Pembahasan Rapat</td>
            <td class="row_atas">:</td>
            <td class="row_atas">{{ $data_rapat->agenda_rapat }}</td>
            <td class="row_atas" colspan="3"></td>
        </tr>
        <tr>
            <td class="row_atas">Tanggal Rapat</td>
            <td class="row_atas">:</td>
            <td class="row_atas">{{ $tanggal_rapat }}</td>
            <td class="row_atas">Jam</td>
            <td class="row_atas">:</td>
            <td class="row_atas">{{ $data_rapat->jam_rapat }}</td>
        </tr>
        <tr>
            <td class="row_atas">Tempat Rapat</td>
            <td class="row_atas">:</td>
            <td class="row_atas">{{ $data_rapat->tempat_rapat }}</td>
            <td class="row_atas" colspan="3"></td>
        </tr>
        <tr>
            <td class="row_atas">Pimpinan Rapat</td>
            <td class="row_atas">:</td>
            <td class="row_atas">{{ $pimpinan->name }}</td>
            <td class="row_atas" colspan="3"></td>
        </tr>
        <tr>
            <td class="row_atas">Notulensi</td>
            <td class="row_atas">:</td>
            <td class="row_atas">{{ auth()->user()->name }}</td>
            <td class="row_atas" colspan="3"></td>
        </tr>
        <tr>
            <td class="row_atas" style="vertical-align: top">Undangan Rapat</td>
            <td class="row_atas" style="vertical-align: top">:</td>
            <td class="row_atas" style="vertical-align: top">
                <ol>
                    @foreach ($peserta as $undangan)
                        <li>{{ $undangan->name }}</li>
                    @endforeach
                </ol>
            </td>
            <td class="row_atas" style="vertical-align: top" colspan="3"></td>
        </tr>
        <tr>
            <td class="row_atas">Agenda Rapat</td>
            <td class="row_atas">:</td>
            <td class="row_atas">{{ $data_rapat->agenda_rapat }}</td>
            <td class="row_atas" colspan="3"></td>
        </tr>
        <tr>
            <td class="row_atas" colspan="6">Keputusan Rapat</td>
        </tr>
        <tr>
            <td class="row_atas">
                <ol>
                    @foreach ($notulen as $isi_notulen)
                        <li>{{ $isi_notulen->notulen }}</li>
                    @endforeach
                </ol>
            </td>
            <td class="row_atas" colspan="5"></td>
        </tr>
    </table>

    <br>

    <table style="border: none" class="center">
        <tr style="border: none">
            <td>&nbsp;</td>
            <td style="text-align: center">NOTULENSI RAPAT</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td style="text-align: center">PIMIPINAN RAPAT</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="border: none">
            <td>&nbsp;</td>
            <td style="text-align: center"><img src="data:image/png;base64, {!! $qrcode_notulensi !!}"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center"><img src="data:image/png;base64, {!! $qrcode_pimpinan !!}"></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="border: none">
            <td>&nbsp;</td>
            <td style="text-align: center">{{ $notulensi }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">{{ $pimpinan->name }}</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <div style="page-break-after: always"></div>

    <div style="text-align: left">
        <img src="{{ $kop }}" height="178" width="700" alt="">
    </div>

    <hr>

    <br>

    <div>
        <p>
            <b>Dokumentasi : </b>
        </p>
        <img src="{{ $dokumentasi }}" width="700" alt="">
    </div>

</body>

</html>
