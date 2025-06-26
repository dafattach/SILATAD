@php
    $data = json_decode($submission->data, true)
@endphp

<!DOCTYPE html>
<html lang="en" style="width: 21cm; height: 29cm; margin: 0px;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pengantar Skripsi</title>

    <style>
        .d-block {
            display: block;
        }
        .capitalize {
            text-transform: capitalize;
        }
        .text-center {
            text-align: center;
        }
        .text-justify {
            text-align: justify;
        }
        .text-indent {
            text-indent: 30px;
        }
        .lh-1-5 {
            line-height: 1.5;
        }
        .vertical-align-middle {
            vertical-align: middle;
        }
        .vertical-align-top {
            vertical-align: top;
        }
        .underline {
            text-decoration: underline;
        }
        .bold {
            font-weight: 700;
        }
        .bolder {
            font-weight: 900;
        }
        .w-100 {
            width: 100%;
        }
        .w-50 {
            width: 50%;
        }
        .logo {
            height: auto;
            width: 100px;
        }
        .pb-10 {
            padding-bottom: 10px;
        }
        .py-10 {
            padding-bottom: 10px;
            padding-top: 10px;
        }
        .px-10 {
            padding-left: 10px;
            padding-right: 10px;
        }
        .px-50 {
            padding-left: 50px;
            padding-right: 50px;
        }
        .py-50 {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .mt-20 {
            margin-top: 20px;
        }
        .mt-50 {
            margin-top: 50px;
        }
        .ml-30 {
            margin-left: 30px;
        }
        td:empty::after{
            content: "\00a0";
        }
        .ttd {
            width: 200px;
            height: auto;
        }
        .watermark {
            background-image: url('{{ asset('website/img/logo.svg') }}');
            background-repeat: no-repeat;
            background-size: 99%;
            background-position: top center;
            position: absolute;
            opacity: 0.2;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body style="width: 21cm; height: 29cm; margin: 0px; position: relative;">
    <div class="watermark"></div>
    <div class="px-50 py-50">
        @include('pdf.partials.kop')

        <section class="px-50 mt-20">
            <table class="w-100">
                <tr>
                    <td class="vertical-align-top" style="width: 50%;">
                        <table>
                            <tr>
                                <td>Nomor</td>
                                <td>:</td>
                                <td class="bold">{{ $submission->formattedLetterNumber }}</td>
                            </tr>
                            <tr>
                                <td>Klasifikasi</td>
                                <td>:</td>
                                <td>B I A S A</td>
                            </tr>
                            <tr>
                                <td>Lampiran</td>
                                <td>:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Perihal</td>
                                <td>:</td>
                                <td class="bold underline">Penelitian Tugas Akhir</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="float: right;">
                            <tr>
                                <td></td>
                                <td>Surabaya, {{ Carbon\Carbon::parse($submission->approved_at)->locale('id_ID')->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr class="bold">
                                <td></td>
                                <td>Kepada :</td>
                            </tr>
                            <tr class="bold">
                                <td>Yth.</td>
                                <td>{{ $data['company_division'] }}</td>
                            </tr>
                            <tr class="bold">
                                <td></td>
                                <td>{{ $data['company_name'] }}</td>
                            </tr>
                            <tr class="bold">
                                <td></td>
                                <td>di Tempat</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </section>

        <section class="px-50 mt-50">
            <p class="text-justify text-indent lh-1-5">Dalam rangka menunjang kegiatan Akademik Mahasiswa Nama Fakultas Universitas XYZ, yang melaksanakan tugas akhir.</p>
            <p class="text-justify text-indent lh-1-5">Sehubungan dengan kegiatan tersebut, maka dengan ini diajukan mahasiswa Nama Fakultas;</p>
            <table class="w-100 lh-1-5 ml-30">
                <tr>
                    <td width="180px">Nama Lengkap</td>
                    <td class="vertical-align-top">:</td>
                    <td>{{ $data['name'][0] }}</td>
                </tr>
                <tr>
                    <td width="180px">Nomor NPM</td>
                    <td class="vertical-align-top">:</td>
                    <td>{{ $data['registration_number'][0] }}</td>
                </tr>
                <tr>
                    <td width="180px">Program Studi</td>
                    <td class="vertical-align-top">:</td>
                    <td>{{ $submission->user->department->name }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="180px">Keperluan</td>
                    <td class="vertical-align-top">:</td>
                    <td>{{ $data['research_purpose'] }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="180px">Judul Penelitian</td>
                    <td class="vertical-align-top">:</td>
                    <td>{{ $data['research_title'] }}</td>
                </tr>
            </table>
            <p class="text-justify text-indent lh-1-5">Demikian atas kerja samanya, disampaikan terima kasih.</p>
        </section>

        <section class="px-50 mt-50">
            <table class="w-100">
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="bold capitalize">{{ $submission->approvedByEmployee->position->name }}</td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="bold">Nama Fakultas</td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td style="position: relative;">
                        <img src="{{ asset('website/img/stempel.png') }}" alt="stempel" style="position: absolute; top: 0; left: 0; transform: translate(-25%, -25%); width: 200px; height: auto; z-index: 1;">
                        <img class="ttd" src="{{ $submission->approvedByEmployee->signatureImage }}" alt="ttd" style="position: relative; z-index: 0;">
                    </td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="bold underline">{{ $submission->approvedByEmployee->name }}</td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="">{{ $submission->approvedByEmployee->registration_type }}. {{ $submission->approvedByEmployee->registration_number }}</td>
                </tr>
            </table>
        </section>
    </div>
</body>
</html>
