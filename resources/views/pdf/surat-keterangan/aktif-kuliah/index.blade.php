@php
    $data = json_decode($submission->data, true)
@endphp

<!DOCTYPE html>
<html lang="en" style="width: 21cm; height: 29cm; margin: 0px;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Aktif Kuliah</title>

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
        .mt-30 {
            margin-top: 30px;
        }
        .mt-40 {
            margin-top: 40px;
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
            background-image: url('{{ asset('website/img/logo-upn.png') }}');
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
            <div class="text-center">
                <span class="d-block bold underline" style="font-size: 18px;">SURAT KETERANGAN AKTIF KULIAH</span>
                <span style="font-size: 18px;">Nomor: {{ $submission->formattedLetterNumber }}</span>
            </div>
        </section>

        <section class="px-50 mt-20">
            <p class="text-justify text-indent lh-1-5">Yang bertanda tangan di bawah ini :</p>
            <table class="w-100 ml-30">
                <tr>
                    <td class="vertical-align-top" width="20px">1.</td>
                    <td class="vertical-align-top" width="230px">Nama</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $submission->approvedByEmployee->name }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">{{ $submission->approvedByEmployee->registration_type }}</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $submission->approvedByEmployee->registration_number }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Pangkat / Golongan</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $submission->approvedByEmployee->rank ?? '-' }} / {{ $submission->approvedByEmployee->class ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Jabatan</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top capitalize">{{ $submission->approvedByEmployee->position->name }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Pada Universitas</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">UPN "Veteran" Jawa Timur</td>
                </tr>
            </table>
        </section>

        <section class="px-50">
            <p class="text-justify text-indent lh-1-5">Dengan ini menyatakan yang sesungguhnya bahwa :</p>
            <table class="w-100 ml-30">
                <tr>
                    <td class="vertical-align-top" width="20px">2.</td>
                    <td class="vertical-align-top" width="230px">Nama</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">NPM</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['registration_number'] }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Program Studi</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['department'] }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Semester</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['semester'] }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Pada Tahun Akademik</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['academic_year'] }}</td>
                </tr>
            </table>
        </section>

        <section class="px-50">
            <p class="text-justify text-indent lh-1-5">Wali anak tersebut :</p>
            <table class="w-100 ml-30">
                <tr>
                    <td class="vertical-align-top" width="20px">3.</td>
                    <td class="vertical-align-top" width="230px">Nama</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['parent_name'] }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">NRP / NIP</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['parent_employee_number'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Pangkat / Golongan</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['parent_employee_position'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Instansi</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['parent_company_name'] }}</td>
                </tr>
                <tr>
                    <td class="vertical-align-top" width="20px"></td>
                    <td class="vertical-align-top" width="230px">Keperluan</td>
                    <td class="vertical-align-top" width="5px">:</td>
                    <td class="vertical-align-top">{{ $data['used_for'] }}</td>
                </tr>
            </table>
            <p class="text-justify text-indent lh-1-5">Demikian surat keterangan ini dibuat dengan sesungguhnya.</p>
        </section>

        <section class="px-50 mt-20">
            <table class="w-100">
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="capitalize" style="padding-bottom: 10px;">Surabaya, {{ Carbon\Carbon::parse($submission->approved_at)->locale('id_ID')->translatedFormat('d F Y') }}</td>
                </tr>
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
