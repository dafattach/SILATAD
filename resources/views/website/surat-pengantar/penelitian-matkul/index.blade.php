@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Pengantar</li>
      <li>Penelitian Mata Kuliah</li>
    </ol>
    <h2>Penelitian Mata Kuliah</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <!-- History Section -->
    <div class="card shadow-lg border-0 mb-5">
      <div class="card-header bg-gradient-primary text-white">
        <div class="d-flex align-items-center">
          <i class="bi bi-clock-history me-3 fs-4"></i>
          <div>
            <h3 class="mb-0">Surat Pengantar Penelitian Mata Kuliah</h3>
            <p class="mb-0 opacity-75">Riwayat Pengajuan</p>
          </div>
        </div>
      </div>
      <div class="card-body p-4">
        @if ($guide && $guide->fileUrl)
          <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="bi bi-download me-2"></i>
            <div class="d-flex align-items-center gap-3">
              <span>Unduh panduan pengajuan Surat Pengantar Penelitian Mata Kuliah</span>
              <a href="{{ $guide->fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-file-earmark-arrow-down me-1"></i>Unduh
              </a>
            </div>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-dark">
              <tr>
                <th class="text-center" style="width: 60px;">No.</th>
                <th>Nama</th>
                <th class="text-center">Tanggal Pengajuan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $datum)
              <tr class="align-middle">
                <td class="text-center fw-bold">{{ $key+1 }}.</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                      {{ strtoupper(substr($datum->user->name, 0, 1)) }}
                    </div>
                    <span class="fw-medium">{{ $datum->user->name }}</span>
                  </div>
                </td>
                <td class="text-center">
                  <span class="badge bg-light text-dark">{{ $datum->formattedCreatedAt }}</span>
                </td>
                <td class="text-center">
                  <span class="badge bg-{{ $datum->StatusBadge }} px-3 py-2">
                    <i class="bi bi-{{ $datum->approved_at ? 'check-circle' : ($datum->rejected_at ? 'x-circle' : 'clock') }} me-1"></i>
                    {{ $datum->status }}
                  </span>
                </td>
                <td class="text-center">
                  @if($datum->approved_at)
                      <a href="{{ route('surat-pengantar.penelitian-matkul.preview', $datum->id) }}" target="_blank" class="btn btn-success btn-sm">
                        <i class="bi bi-eye me-1"></i>Lihat
                      </a>
                  @elseif($datum->rejected_at)
                      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#rejectionModal{{ $datum->id }}">
                          <i class="bi bi-exclamation-triangle me-1"></i>Alasan
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="rejectionModal{{ $datum->id }}" tabindex="-1" aria-labelledby="rejectionModalLabel{{ $datum->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header bg-warning text-dark">
                                      <h5 class="modal-title" id="rejectionModalLabel{{ $datum->id }}">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Alasan Penolakan
                                      </h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <div class="preserve-whitespace">{!! $datum->rejected_note !!}</div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
          {{ $data->onEachSide(1)->links('vendor.pagination.website') }}
        </div>
      </div>
    </div>

    <!-- Form Section -->
    <div class="card shadow-lg border-0">
      <div class="card-header bg-gradient-success text-white">
        <div class="d-flex align-items-center">
          <i class="bi bi-pencil-square me-3 fs-4"></i>
          <div>
            <h3 class="mb-0">Surat Pengantar Penelitian Mata Kuliah</h3>
            <p class="mb-0 opacity-75">Form Pengajuan</p>
          </div>
        </div>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('surat-pengantar.penelitian-matkul.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
              <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-circle me-2"></i>
                <div>
                  <strong>Terjadi kesalahan:</strong>
                  <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          @endif

          <!-- Student Information -->
          <div class="row mb-4">
            <div class="col-12">
              <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-people me-2"></i>Informasi Mahasiswa
              </h5>
            </div>
            
            <!-- Student 1 -->
            <div class="col-12 mb-3">
              <div class="card border-primary">
                <div class="card-header bg-primary text-white py-2">
                  <h6 class="mb-0"><i class="bi bi-person me-2"></i>Mahasiswa 1 (Pemohon)</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" name="name[]" class="form-control @error('name.0') is-invalid @enderror" value="{{ old('name.0', Auth::user()->name) }}" readonly>
                      @error('name.0')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-medium">NPM Mahasiswa <span class="text-danger">*</span></label>
                      <input type="text" name="registration_number[]" class="form-control @error('registration_number.0') is-invalid @enderror" value="{{ old('registration_number.0', Auth::user()->registration_number) }}" readonly>
                      @error('registration_number.0')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @for($i = 2; $i <= 5; $i++)
            <!-- Student {{ $i }} -->
            <div class="col-12 mb-3">
              <div class="card border-{{ $i == 2 ? 'secondary' : ($i == 3 ? 'info' : ($i == 4 ? 'warning' : 'danger')) }}">
                <div class="card-header bg-{{ $i == 2 ? 'secondary' : ($i == 3 ? 'info' : ($i == 4 ? 'warning' : 'danger')) }} text-white py-2">
                  <h6 class="mb-0"><i class="bi bi-person me-2"></i>Mahasiswa {{ $i }}</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-medium">Nama Lengkap</label>
                      <input type="text" name="name[]" class="form-control @error('name.' . ($i-1)) is-invalid @enderror" value="{{ old('name.' . ($i-1)) }}">
                      @error('name.' . ($i-1))
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-medium">NPM Mahasiswa</label>
                      <input type="text" name="registration_number[]" class="form-control @error('registration_number.' . ($i-1)) is-invalid @enderror" value="{{ old('registration_number.' . ($i-1)) }}">
                      @error('registration_number.' . ($i-1))
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endfor
          </div>

          <!-- Subject Information -->
          <div class="row mb-4">
            <div class="col-12">
              <h5 class="fw-bold text-info mb-3">
                <i class="bi bi-book me-2"></i>Informasi Mata Kuliah
              </h5>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Nama Mata Kuliah <span class="text-danger">*</span></label>
              <input type="text" name="subject_name" class="form-control @error('subject_name') is-invalid @enderror" value="{{ old('subject_name') }}" required>
              @error('subject_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Upload Surat Ajuan <span class="text-danger">*</span></label>
              <input type="file" name="application_letter" class="form-control @error('application_letter') is-invalid @enderror" accept="application/pdf" required>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Upload surat ajuan izin penelitian mata kuliah yang telah diberi TTD oleh dosen pengampu.
              </div>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Format file berupa PDF, maksimal 2MB.
              </div>
              @error('application_letter')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Research Information -->
          <div class="row mb-4">
            <div class="col-12">
              <h5 class="fw-bold text-success mb-3">
                <i class="bi bi-search me-2"></i>Informasi Penelitian
              </h5>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Keperluan Penelitian <span class="text-danger">*</span></label>
              <input type="text" name="research_purpose" class="form-control @error('research_purpose') is-invalid @enderror" value="{{ old('research_purpose') }}" required>
              @error('research_purpose')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Judul Penelitian <span class="text-danger">*</span></label>
              <input type="text" name="research_title" class="form-control @error('research_title') is-invalid @enderror" value="{{ old('research_title') }}" required>
              @error('research_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Company Information -->
          <div class="row mb-4">
            <div class="col-12">
              <h5 class="fw-bold text-warning mb-3">
                <i class="bi bi-building me-2"></i>Informasi Perusahaan
              </h5>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Nama Instansi/Perusahaan <span class="text-danger">*</span></label>
              <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Contoh: PT. Daily Planet, CV. Alexander Family, dll.
              </div>
              @error('company_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Nama Bagian/Divisi <span class="text-danger">*</span></label>
              <input type="text" name="company_division" class="form-control @error('company_division') is-invalid @enderror" value="{{ old('company_division') }}" required>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Contoh: Bagian Penjualan, Divisi Marketing, Bagian Keuangan, Divisi Umum, dll.
              </div>
              @error('company_division')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Nomor Telepon Perusahaan <span class="text-danger">*</span></label>
              <input type="text" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror" value="{{ old('company_phone') }}" required>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Contoh: 021990990, 031880880, 081234567890 (hanya angka).
              </div>
              @error('company_phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Tanggal Mulai Penelitian <span class="text-danger">*</span></label>
              <input type="date" name="starting_date" class="form-control @error('starting_date') is-invalid @enderror" value="{{ old('starting_date') }}" required>
              @error('starting_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-12 mb-4">
              <label class="form-label fw-medium">Alamat Perusahaan <span class="text-danger">*</span></label>
              <input type="text" name="company_address" class="form-control @error('company_address') is-invalid @enderror" value="{{ old('company_address') }}" required>
              <div class="form-text">
                <i class="bi bi-exclamation-triangle me-1 text-warning"></i>WAJIB copas alamat lengkap dari google maps.
              </div>
              @error('company_address')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Additional Notes -->
          <div class="row mb-4">
            <div class="col-12">
              <h5 class="fw-bold text-danger mb-3">
                <i class="bi bi-sticky me-2"></i>Catatan Lain
              </h5>
              <div class="card border-danger">
                <div class="card-body">
                  <label class="form-label fw-medium">Catatan Khusus Untuk Staff</label>
                  <textarea name="note" rows="5" class="form-control @error('note') is-invalid @enderror" placeholder="Perihal atau keterangan lain yang perlu ditambahkan dalam ajuan. Boleh dikosongkan">{{ old('note') }}</textarea>
                  <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>Perihal atau keterangan lain yang perlu ditambahkan dalam ajuan. Boleh dikosongkan
                  </div>
                  @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="d-grid d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary btn-lg px-5">
              <i class="bi bi-send me-2"></i>Ajukan Surat
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<style>
.bg-gradient-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.avatar-sm {
  width: 40px;
  height: 40px;
  font-size: 16px;
  font-weight: bold;
}

.card {
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-2px);
}

.table-hover tbody tr:hover {
  background-color: rgba(0,123,255,0.05);
}

.btn {
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-1px);
}

.form-control:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.badge {
  font-size: 0.875rem;
}

.alert {
  border-radius: 10px;
}

.modal-content {
  border-radius: 15px;
  border: none;
}

.modal-header {
  border-radius: 15px 15px 0 0;
}

.preserve-whitespace {
  white-space: pre-wrap;
}
</style>
@stop