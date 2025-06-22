@extends('admin.layout')

@section('styles')
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
</style>
@stop

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Profil</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Profil</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Pengaturan Profil</h4>
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
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required value="{{ $employee->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email Aktif" required value="{{ $employee->email }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="selectPosition">Jabatan</label>
                    <select id="selectPosition" class="form-control" disabled>
                      <option value="" disabled selected>Pilih Jabatan Pegawai</option>
                      @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{ $position->id == $employee->employee_position_id ? 'selected':'' }}>{{ strtoupper($position->name) }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="selectDepartment">Jurusan</label>
                    <select id="selectDepartment" class="form-control" disabled>
                      <option value="" disabled selected>Pilih Jurusan Pegawai</option>
                      @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ $department->id == $employee->department_id ? 'selected':'' }}>{{ $department->name }} ({{ $department->short_name }})</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Jenis Nomor Induk</label>
                    <select name="registration_type" class="form-control">
                      <option value="" disabled {{ !$employee->registration_type ? 'selected' : '' }}>Pilih Jenis Nomor Induk</option>
                      <option value="NIP" {{ $employee->registration_type == 'NIP' ? 'selected' : '' }}>NIP</option>
                      <option value="NRP" {{ $employee->registration_type == 'NRP' ? 'selected' : '' }}>NRP</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Nomor Induk</label>
                    <input type="text" name="registration_number" class="form-control" placeholder="3578*****" required value="{{ $employee->registration_number }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Pangkat</label>
                    <input type="text" name="rank" class="form-control" placeholder="Contoh: Penata, Pembina, dll" required value="{{ $employee->rank }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Golongan</label>
                    <input type="text" name="class" class="form-control" placeholder="Contoh: III C, IV C, dll" required value="{{ $employee->class }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group position-relative">
                    <label for="inputSignature">Tanda Tangan</label>
                    <input id="inputSignature" type="file" name="signature" class="custom-file-input" accept="image/png">
                    <label class="custom-file-label" for="inputSignature">Pilih Tanda Tangan (PNG)</label>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                    <label for="previewSignature">Preview Tanda Tangan</label>
                    <section>
                      <table class="w-100">
                        <tr class="text-center">
                          <td class="bold capitalize">{{ $employee->position->name }}</td>
                        </tr>
                        <tr class="text-center">
                          <td class="bold">Nama Fakultas</td>
                        </tr>
                        <tr class="text-center">
                          <td><img class="ttd" src="{{ $employee->signatureImage }}" alt="ttd"></td>
                        </tr>
                        <tr class="text-center">
                          <td class="bold underline">{{ $employee->name }}</td>
                        </tr>
                        <tr class="text-center">
                          <td class="bold">{{ $employee->registration_type }}. {{ $employee->registration_number }}</td>
                        </tr>
                      </table>
                    </section>
                  </div>
                </div>
                <!-- <div class="col">
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="********" required>
                  </div>
                </div> -->
              </div>
  
              <div class="row justify-content-end">
                <div class="col-4">
                  <button type="submit" class="btn btn-lg btn-primary form-control">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
