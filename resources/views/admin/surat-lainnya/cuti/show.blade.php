@php
  $data = json_decode($submission->data);
@endphp
@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Surat Lainnya</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="javascript:void(0)">Surat Lainnya</a></div>
      <div class="breadcrumb-item">Cuti</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Cuti</h2>
    <p class="section-lead">Detail Pengajuan</p>

    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Informasi Pemohon</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Nama Pemohon</label>
                  <input type="text" class="form-control" value="{{ $submission->user->name }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>NPM Pemohon</label>
                  <input type="text" class="form-control" value="{{ $submission->user->registration_number }}" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Program Studi</label>
                  <input type="text" class="form-control" value="{{ $data->department }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Semester</label>
                  <input type="text" class="form-control text-capitalize" value="{{ $data->semester }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Tahun Ajaran</label>
                  <input type="text" class="form-control" value="{{ $data->academic_year }}" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Nama Orang Tua</label>
                  <input type="text" class="form-control" value="{{ $data->parent_name }}" disabled>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Alasan Cuti</label>
                    <input type="text" class="form-control" value="{{ $data->excuse }}" disabled>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Berkas Pendukung</label>
                    @if($data->supporting_documents_path ?? false)
                      <a href="{{ asset('storage/' . $data->supporting_documents_path) }}" class="btn btn-lg btn-primary form-control" target="_blank">Lihat PDF</a>
                    @else
                      <input type="text" class="form-control bg-white border-0" value="-" disabled>
                    @endif
                  </div>
                </div>
              </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4>Persetujuan & Catatan</h4>
          </div>
          <div class="card-body">
            @if($errors->any())
              <div class="row">
                <div class="col">
                  @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                      {{ $error }}
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            <form action="{{ route('admin.surat-lainnya.cuti.update', $submission->id) }}" method="post">
              @csrf
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Catatan Verifikator</label>
                    <textarea
                      name="{{ Auth::guard('employee')->user()->position->AllowedToVerify ? 'note':'' }}"
                      rows="20"
                      class="form-control"
                      {{ $submission->isAvailableToVerified && Auth::guard('employee')->user()->position->AllowedToVerify && !$submission->rejected_at ? '':'disabled' }}
                    >{{ $submission->verified_note }}</textarea>
                    @if($submission->verified_at)
                      <small id="passwordHelpBlock" class="form-text text-muted">
                        Oleh: {{ $submission->verifiedByEmployee->name }}
                      </small>
                    @endif
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Catatan Approval</label>
                    <textarea
                      name="{{ Auth::guard('employee')->user()->position->AllowedToApprove('cuti') ? 'note':'' }}"
                      rows="20"
                      class="form-control"
                      {{ $submission->isAvailableToApproved && Auth::guard('employee')->user()->position->AllowedToApprove('cuti') && !$submission->rejected_at ? '':'disabled' }}
                    >{{ $submission->approved_note }}</textarea>
                    @if($submission->approved_at)
                      <small id="passwordHelpBlock" class="form-text text-muted">
                        Oleh: {{ $submission->approvedByEmployee->name }}
                      </small>
                    @endif
                  </div>
                </div>
              </div>

              @if($submission->rejected_at)
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label>Alasan Ditolak</label>
                      <textarea
                        rows="20"
                        class="form-control"
                        disabled
                      >{{ $submission->rejected_note }}</textarea>
                      <small id="passwordHelpBlock" class="form-text text-muted">
                        Oleh: {{ $submission->rejectedByEmployee->name }}
                      </small>
                    </div>
                  </div>
                </div>
              @endif

              <div class="row justify-content-end">
                @if($submission->isAvailableToRejected(Auth::guard('employee')->user()->position, 'cuti'))
                  <div class="col-4 text-right">
                    <button type="submit" name="type" value="rejected" class="btn btn-lg btn-danger form-control">Tolak</button>
                  </div>
                @endif

                @if(!$submission->rejected_at)
                  @if($submission->isAvailableToVerified && Auth::guard('employee')->user()->position->AllowedToVerify)
                    <div class="col-4 text-right">
                      <button type="submit" name="type" value="verified" class="btn btn-lg btn-primary form-control {{ ($submission->verified_at != null) ? 'disabled':'' }}">Verifikasi</button>
                    </div>
                  @endif

                  @if($submission->isAvailableToApproved && Auth::guard('employee')->user()->position->AllowedToApprove('cuti'))
                    <div class="col-4 text-right">
                      <button type="submit" name="type" value="approved" class="btn btn-lg btn-primary form-control {{ ($submission->approved_at != null) ? 'disabled':'' }}">Setujui</button>
                    </div>
                  @endif
                @endif
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
