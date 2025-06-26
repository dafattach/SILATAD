@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Lainnya</li>
      <li>Cuti</li>
    </ol>
    <h2>Cuti</h2>
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
            <h3 class="mb-0">Surat Lainnya Cuti</h3>
            <p class="mb-0 opacity-75">Riwayat Pengajuan</p>
          </div>
        </div>
      </div>
      <div class="card-body p-4">
        @if ($guide && $guide->fileUrl)
          <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="bi bi-download me-2"></i>
            <div class="d-flex align-items-center gap-3">
              <span>Unduh panduan pengajuan Cuti</span>
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
                      <a href="{{ route('surat-lainnya.cuti.preview', $datum->id) }}" target="_blank" class="btn btn-success btn-sm">
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
            <h3 class="mb-0">Surat Lainnya Cuti</h3>
            <p class="mb-0 opacity-75">Form Pengajuan</p>
          </div>
        </div>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('surat-lainnya.cuti.store') }}" method="post" enctype="multipart/form-data">
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
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}" readonly>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">NPM Mahasiswa <span class="text-danger">*</span></label>
              <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ Auth::user()->registration_number }}" readonly>
              @error('registration_number')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-medium">Program Studi <span class="text-danger">*</span></label>
              <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ Auth::user()->department->name }}" readonly>
              @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-medium">Semester <span class="text-danger">*</span></label>
              <select name="semester" class="form-control @error('semester') is-invalid @enderror" required>
                  <option value="">Pilih Semester...</option>
                  <option value="genap">Genap</option>
                  <option value="ganjil">Ganjil</option>
              </select>
              @error('semester')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-medium">Tahun Ajaran <span class="text-danger">*</span></label>
              <select name="academic_year" class="form-control @error('academic_year') is-invalid @enderror" required>
                  <option value="">Pilih Tahun Ajaran...</option>
                  @php
                      $now = Carbon\Carbon::now()->subYear(1);
                  @endphp
                  @for ($i = 0; $i < 5; $i++)
                      <option value="{{ $now->year + $i . "/" . $now->year + $i + 1}}">{{ $now->year + $i . "/" . $now->year + $i + 1}}</option>
                  @endfor
              </select>
              @error('academic_year')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Parent Information -->
          <div class="row mb-4">
            <div class="col-12">
              <h5 class="fw-bold text-success mb-3">
                <i class="bi bi-person-badge me-2"></i>Informasi Orang Tua
              </h5>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label fw-medium">Nama Orang Tua <span class="text-danger">*</span></label>
              <input type="text" name="parent_name" class="form-control @error('parent_name') is-invalid @enderror" required>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Orang tua yang akan bertanda tangan.
              </div>
              @error('parent_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Leave Information -->
          <div class="row mb-4">
            <div class="col-12">
              <h5 class="fw-bold text-info mb-3">
                <i class="bi bi-calendar-event me-2"></i>Informasi Cuti
              </h5>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Alasan Cuti <span class="text-danger">*</span></label>
              <input type="text" name="excuse" class="form-control @error('excuse') is-invalid @enderror" required>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Alasan ingin mengambil cuti.
              </div>
              @error('excuse')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-medium">Berkas Pendukung <span class="text-danger">*</span></label>
              <input type="file" name="supporting_documents" class="form-control @error('supporting_documents') is-invalid @enderror" accept="application/pdf" required>
              <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>Format file berupa PDF, maksimal 2MB.
              </div>
              <div class="form-text mt-0">
                <i class="bi bi-exclamation-triangle me-1 text-warning"></i>Cantumkan semua berkas pendukung yang relevan dalam 1 file pdf.
              </div>
              @error('supporting_documents')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
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