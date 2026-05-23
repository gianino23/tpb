@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white mb-0">Menunggu Verifikasi</h6>
                            <h3 class="text-white mb-0">{{ $countMenunggu }}</h3>
                        </div>
                        <i class="bx bx-time bx-lg opacity-50"></i>
                    </div>
                    <a href="{{ route('capaian_kabupaten.index', ['status' => 'Menunggu Verifikasi']) }}" class="text-white small mt-3 d-block">Lihat Detail <i class="bx bx-right-arrow-alt"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white mb-0">Terverifikasi</h6>
                            <h3 class="text-white mb-0">{{ $countTerverifikasi }}</h3>
                        </div>
                        <i class="bx bx-check-shield bx-lg opacity-50"></i>
                    </div>
                    <a href="{{ route('capaian_kabupaten.index', ['status' => 'Terverifikasi']) }}" class="text-white small mt-3 d-block">Lihat Detail <i class="bx bx-right-arrow-alt"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white mb-0">Ditolak</h6>
                            <h3 class="text-white mb-0">{{ $countDitolak }}</h3>
                        </div>
                        <i class="bx bx-x-circle bx-lg opacity-50"></i>
                    </div>
                    <a href="{{ route('capaian_kabupaten.index', ['status' => 'Ditolak']) }}" class="text-white small mt-3 d-block">Lihat Detail <i class="bx bx-right-arrow-alt"></i></a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== IMPORT EXCEL SECTION (Operator Kabupaten/Kota only) ===== --}}
    @if(auth()->user()->level == 'Operator Kabupaten/Kota')
    <div class="card mb-4" style="border-top: 4px solid #1D4ED8;">
        <div class="card-header py-3" style="background: linear-gradient(135deg, #1B2A4A 0%, #1D4ED8 100%);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-upload text-white" style="font-size:1.4rem"></i>
                    <div>
                        <h5 class="mb-0 text-white fw-bold">Upload Capaian Indikator TPB via Excel</h5>
                        <small class="text-white opacity-75">
                            <i class="bx bx-check-circle"></i>
                            {{ \App\Models\Indikator::where('status','Terverifikasi')->count() }} indikator tersedia dari Admin — tinggal upload capaian
                        </small>
                    </div>
                </div>
                <span class="badge bg-light text-dark fw-normal">
                    <i class="bx bx-info-circle"></i> Upload menggantikan seluruh data capaian Anda sebelumnya
                </span>
            </div>
        </div>
        <div class="card-body py-4">

            {{-- Import Summary --}}
            @if(session('import_capaian_summary'))
            @php $sum = session('import_capaian_summary'); @endphp
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <strong><i class="bx bx-bar-chart-alt-2"></i> Hasil Import Capaian Tahun {{ $sum['year'] }}</strong>
                <div class="mt-1">
                    ✅ Berhasil: <strong>{{ $sum['success'] }}</strong> baris &nbsp;|&nbsp;
                    ❌ Gagal: <strong>{{ $sum['failed'] }}</strong> baris &nbsp;|&nbsp;
                    Disimpan ke kolom: <code>{{ $sum['field'] }}</code>
                </div>
                @if(count($sum['errors']) > 0)
                <hr class="my-2">
                <ul class="mb-0 small">
                    @foreach($sum['errors'] as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Step Progress Bar --}}
            <div class="d-flex align-items-center mb-4 gap-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width:32px;height:32px;background:#1D4ED8;font-size:14px;">1</div>
                    <span class="fw-semibold small">Unduh Template</span>
                </div>
                <div style="flex:1;height:2px;background:#dee2e6;margin:0 10px;"></div>
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width:32px;height:32px;background:#F59E0B;font-size:14px;">2</div>
                    <span class="fw-semibold small">Isi Capaian di Excel</span>
                </div>
                <div style="flex:1;height:2px;background:#dee2e6;margin:0 10px;"></div>
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width:32px;height:32px;background:#059669;font-size:14px;">3</div>
                    <span class="fw-semibold small">Upload Kembali</span>
                </div>
            </div>

            <div class="row g-3">

                {{-- STEP 1: Download Template --}}
                <div class="col-md-4">
                    <div class="border rounded-3 p-4 h-100" style="border-color: #BFDBFE !important; background: #EFF6FF;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:28px;height:28px;min-width:28px;background:#1D4ED8;font-size:13px;">1</div>
                            <strong class="text-dark">Unduh Template Excel</strong>
                        </div>
                        <p class="small text-muted mb-3">Template sudah berisi <strong>{{ \App\Models\Indikator::where('status','Terverifikasi')->count() }} nama indikator</strong>, target nasional, satuan, GAP, status, dan rekap. Anda hanya perlu mengisi kolom <span class="fw-bold text-primary">★ Capaian</span>.</p>
                        <form action="{{ route('capaian_kabupaten.download-template') }}" method="GET">
                            <div class="mb-2">
                                <label class="form-label small mb-1 fw-semibold">Pilih Tahun Data</label>
                                <select name="year" id="dl-year" class="form-select form-select-sm">
                                    @for($y = date('Y'); $y >= date('Y')-4; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100 mt-1">
                                <i class="bx bx-download me-1"></i> Unduh template_capaian_<span id="dl-year-label">{{ date('Y') }}</span>.xlsx
                            </button>
                        </form>
                    </div>
                </div>

                {{-- STEP 2: Instructions --}}
                <div class="col-md-4">
                    <div class="border rounded-3 p-4 h-100" style="border-color: #FDE68A !important; background: #FFFBEB;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:28px;height:28px;min-width:28px;background:#F59E0B;font-size:13px;">2</div>
                            <strong class="text-dark">Isi Kolom Capaian di Excel</strong>
                        </div>
                        <p class="small text-muted mb-2">Buka file yang diunduh, isi <strong>hanya kolom berwarna biru (★ Capaian)</strong>. Kolom lain sudah terisi otomatis dari sistem.</p>
                        <div class="small">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge" style="background:#DBEAFE;color:#1D4ED8;border:1px solid #93C5FD;">Kolom Biru</span>
                                <span class="text-muted">= wajib isi (★ CAPAIAN)</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-light text-dark border">Kolom Putih</span>
                                <span class="text-muted">= dari sistem, jangan ubah</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="background:#D1FAE5;color:#059669;border:1px solid #6EE7B7;">Kolom Hijau</span>
                                <span class="text-muted">= dihitung otomatis (GAP & Status)</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="background:#FEF3C7;color:#92400E;border:1px solid #FCD34D;">Kolom Coklat</span>
                                <span class="text-muted">= opsional (Sumber Data & Catatan)</span>
                            </div>
                        </div>
                        <hr class="my-2">
                        <small class="text-muted"><i class="bx bx-info-circle text-warning"></i> Simpan sebagai <strong>.xlsx</strong> sebelum upload.</small>
                    </div>
                </div>

                {{-- STEP 3: Upload --}}
                <div class="col-md-4">
                    <div class="border rounded-3 p-4 h-100" style="border-color: #A7F3D0 !important; background: #F0FDF4;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:28px;height:28px;min-width:28px;background:#059669;font-size:13px;">3</div>
                            <strong class="text-dark">Upload File yang Sudah Diisi</strong>
                        </div>
                        <p class="small text-muted mb-3">Format: <code>.xlsx</code> · Maks 10MB · Hanya file dari template resmi sistem.</p>
                        <form action="{{ route('capaian_kabupaten.import-excel') }}" method="POST" enctype="multipart/form-data" id="importCapaianForm">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small mb-1 fw-semibold">Tahun Data</label>
                                <select name="year" class="form-select form-select-sm" required>
                                    @for($y = date('Y'); $y >= date('Y')-4; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small mb-1 fw-semibold">File Excel (.xlsx / .xls)</label>
                                <div id="drop-zone" class="border rounded-2 d-flex flex-column align-items-center justify-content-center p-3 text-center"
                                    style="border-style:dashed!important;cursor:pointer;min-height:90px;transition:background 0.2s;"
                                    onclick="document.getElementById('capaian-file-input').click()"
                                    ondragover="event.preventDefault();this.style.background='#DCFCE7'"
                                    ondragleave="this.style.background=''"
                                    ondrop="handleDrop(event)">
                                    <i class="bx bx-cloud-upload mb-1" style="font-size:1.8rem;color:#059669;"></i>
                                    <span class="small text-muted" id="drop-label">Klik atau drag & drop file Excel</span>
                                </div>
                                <input type="file" id="capaian-file-input" name="file" accept=".xlsx,.xls" class="d-none" required onchange="updateDropLabel(this)">
                            </div>
                            <button type="submit" class="btn btn-success btn-sm w-100 mt-1" id="importBtn">
                                <i class="bx bx-upload me-1"></i> Proses Upload
                            </button>
                        </form>
                    </div>
                </div>

            </div>{{-- end row --}}
        </div>
    </div>
    @endif
    {{-- ===== END IMPORT EXCEL SECTION ===== --}}

    <div class="card">

        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4 mb-3">
                    <h4 class="mb-0"><span class="text-muted fw-light">Data /</span> Capaian</h4>
                </div>
                <div class="col-md-4 mb-3">
                    <form action="{{ route('capaian_kabupaten.index') }}" method="GET" id="filterForm">
                        <select name="status" class="form-control" onchange="document.getElementById('filterForm').submit()">
                            <option value="">-- Filter Semua Status --</option>
                            <option value="Menunggu Verifikasi" {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="Terverifikasi" {{ request('status') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </form>
                </div>
                <div class="col-md-4 mb-3 text-end">
                    @if(auth()->user()->level == 'Operator Kabupaten/Kota')
                    <button type="button" class="btn rounded-pill btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                        <i class="bx bx-plus"></i> AJUKAN CAPAIAN
                    </button>
                    @endif
                    @if(request('status'))
                        <a href="{{ route('capaian_kabupaten.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="bx bx-reset"></i> Reset Filter</a>
                    @endif
                </div>
            </div>

            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr class="text-nowrap">
                            <th>No Tiket</th>
                            <th>Wilayah</th>
                            <th>OPD</th>
                            <th>Status Capaian</th>
                            <th>Sumber Data</th>
                            <th>Catatan</th>
                            <th>Tgl Kirim</th>
                            <th>Tgl Terima</th>
                            <th>Status</th>
                            <th>File</th>
                            <th style="width:100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($capaians as $data)
                        <tr>
                            <td><code>{{ $data->no_tiket }}</code></td>
                            <td>{{ $data->wilayah }}</td>
                            <td>{{ $data->opd }}</td>
                            <td>
                                @if($data->kategori_capaian == 'SS')
                                    <span class="badge bg-success">Tercapai (SS)</span>
                                @elseif($data->kategori_capaian == 'SB')
                                    <span class="badge bg-warning">Dalam Proses (SB)</span>
                                @elseif($data->kategori_capaian == 'BB')
                                    <span class="badge bg-danger">Belum Tercapai (BB)</span>
                                @else
                                    {{ $data->kategori_capaian }}
                                @endif
                            </td>
                            <td>{{ $data->nama_dokumen }}</td>
                            <td>{{ $data->jenis_dokumen }}</td>
                            <td>{{ $data->tanggal_kirim ? \Carbon\Carbon::parse($data->tanggal_kirim)->format('d-m-Y H:i') : '-' }}</td>
                            <td>{{ $data->tanggal_terima ? \Carbon\Carbon::parse($data->tanggal_terima)->format('d-m-Y H:i') : '-' }}</td>
                            <td>
                                @if($data->status == 'Menunggu Verifikasi')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($data->status == 'Terverifikasi')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif($data->status == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $data->status }}</span>
                                @endif

                                @if($data->keterangan_verifikasi)
                                    <div class="mt-1 small">
                                        <i class="bx bx-info-circle"></i> {{ $data->keterangan_verifikasi }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @php $files = json_decode($data->files, true); @endphp
                                @if($files)
                                    @foreach($files as $file)
                                        <a href="{{ asset('storage/capaian_dokumen/'.$file) }}" target="_blank" class="badge bg-info"><i class="bx bx-download"></i> Lihat</a>
                                    @endforeach
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-info btn-detail" data-id="{{ $data->id }}" title="Detail"><i class="bx bx-show"></i></button>
                                    
                                    @if(auth()->user()->level == 'Administrator' || auth()->user()->level == 'Operator Provinsi')
                                        @if($data->status == 'Menunggu Verifikasi')
                                        <button type="button" class="btn btn-primary btn-review" data-id="{{ $data->id }}" title="Review & Verifikasi"><i class="bx bx-check-shield"></i></button>
                                        @endif
                                    @endif
                                    
                                    @if(auth()->user()->level == 'Administrator' || (auth()->user()->level == 'Operator Kabupaten/Kota' && ($data->status == 'Menunggu Verifikasi' || $data->status == 'Ditolak')))
                                    <button type="button" class="btn btn-warning btn-edit" data-id="{{ $data->id }}" title="Edit"><i class="bx bx-edit"></i></button>
                                    <form action="{{ route('capaian_kabupaten.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus"><i class="bx bx-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('capaian_kabupaten.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajukan Capaian Kabupaten/Kota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">TPB</label>
                            <select name="tpb_id" class="form-control select2" required>
                                <option value="" disabled selected>Pilih TPB</option>
                                @foreach($tpbs as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_tpb }} - {{ $t->nama_tpb }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode / Nama Indikator</label>
                            <select name="indikator_id" class="form-control select2" required>
                                <option value="" disabled selected>Pilih Indikator TPB</option>
                                @foreach($indikators as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_indikator }} - {{ $t->nama_indikator_tpb }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Target Nasional</label>
                            <select name="target_id" class="form-control select2" required>
                                <option value="" disabled selected>Pilih Target Nasional</option>
                                @foreach($targets as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_target }} - {{ $t->nama_target }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data RPJMD</label>
                            <select name="rpjmd_id" class="form-control select2" required>
                                <option value="" disabled selected>Pilih RPJMD</option>
                                @foreach($rpjmds as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_indikator_rpjmd }} - {{ $t->indikator_kinerja }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">OPD</label>
                            <input type="text" name="opd" class="form-control" value="{{ auth()->user()->dinas }}" readonly required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Data</label>
                            <select name="year" id="manual-year" class="form-control select2" required>
                                @for($y = date('Y'); $y >= date('Y')-4; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" placeholder="Contoh: % / Indeks / Dokumen">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">★ Capaian <span id="manual-year-label">{{ date('Y') }}</span></label>
                            <input type="text" name="capaian_manual" class="form-control" placeholder="Contoh: 74.60 / Ada / Belum" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">GAP</label>
                            <input type="text" name="gap" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="kategori_capaian" class="form-control select2" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="SS">Tercapai (SS)</option>
                                <option value="SB">Dalam Proses (SB)</option>
                                <option value="BB">Belum Tercapai (BB)</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sumber Data</label>
                            <input type="text" name="nama_dokumen" class="form-control" placeholder="Contoh: BPS / Dinas terkait">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catatan Tambahan</label>
                            <input type="text" name="jenis_dokumen" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Upload File (Multiple, Optional)</label>
                            <input type="file" name="files[]" class="form-control" multiple accept=".pdf,.doc,.docx">
                            <small class="text-muted">Tahan tombol Ctrl/Command untuk memilih lebih dari satu file.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Capaian</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="formEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Capaian Kabupaten/Kota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">TPB</label>
                            <select name="tpb_id" id="edit_tpb_id" class="form-control select2-edit" required>
                                @foreach($tpbs as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_tpb }} - {{ $t->nama_tpb }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode / Nama Indikator</label>
                            <select name="indikator_id" id="edit_indikator_id" class="form-control select2-edit" required>
                                @foreach($indikators as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_indikator }} - {{ $t->nama_indikator_tpb }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Target Nasional</label>
                            <select name="target_id" id="edit_target_id" class="form-control select2-edit" required>
                                @foreach($targets as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_target }} - {{ $t->nama_target }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data RPJMD</label>
                            <select name="rpjmd_id" id="edit_rpjmd_id" class="form-control select2-edit" required>
                                @foreach($rpjmds as $t)
                                    <option value="{{ $t->id }}">{{ $t->no_indikator_rpjmd }} - {{ $t->indikator_kinerja }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">OPD</label>
                            <input type="text" name="opd" id="edit_opd" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Data</label>
                            <select name="year" id="edit_year" class="form-control select2-edit" required>
                                @for($y = date('Y'); $y >= date('Y')-4; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" placeholder="Contoh: % / Indeks / Dokumen">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">★ Capaian <span id="edit_year_label">{{ date('Y') }}</span></label>
                            <input type="text" name="capaian_manual" id="edit_capaian_manual" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">GAP</label>
                            <input type="text" name="gap" id="edit_gap" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="kategori_capaian" id="edit_kategori_capaian" class="form-control select2-edit" required>
                                <option value="SS">Tercapai (SS)</option>
                                <option value="SB">Dalam Proses (SB)</option>
                                <option value="BB">Belum Tercapai (BB)</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sumber Data</label>
                            <input type="text" name="nama_dokumen" id="edit_nama_dokumen" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catatan Tambahan</label>
                            <input type="text" name="jenis_dokumen" id="edit_jenis_dokumen" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Upload File Baru (Optional)</label>
                            <input type="file" name="files[]" class="form-control" multiple accept=".pdf,.doc,.docx">
                            <small class="text-muted">Biarkan kosong jika tidak ingin menambah file.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Review -->
<div class="modal fade" id="modalReview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review Capaian Kabupaten/Kota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Silakan berikan keterangan untuk verifikasi atau penolakan data ini.</p>
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Keterangan / Catatan</label>
                        <textarea id="keterangan_verifikasi" class="form-control" rows="3" placeholder="Masukkan alasan jika ditolak atau catatan tambahan jika diverifikasi..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnReject" class="btn btn-danger">Tolak Data</button>
                <button type="button" id="btnVerify" class="btn btn-success">Verifikasi & Terima</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Capaian Kabupaten/Kota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th width="30%">No Tiket</th><td><code id="detail_no_tiket"></code></td></tr>
                    <tr><th>Wilayah</th><td id="detail_wilayah"></td></tr>
                    <tr><th>OPD</th><td id="detail_opd"></td></tr>
                    <tr><th>TPB</th><td id="detail_tpb"></td></tr>
                    <tr><th>Kode / Nama Indikator</th><td id="detail_indikator"></td></tr>
                    <tr><th>Target Nasional</th><td id="detail_target"></td></tr>
                    <tr><th>RPJMD</th><td id="detail_rpjmd"></td></tr>
                    <tr><th>Tahun N-4</th><td id="detail_n4"></td></tr>
                    <tr><th>Tahun N-3</th><td id="detail_n3"></td></tr>
                    <tr><th>Tahun N-2</th><td id="detail_n2"></td></tr>
                    <tr><th>Tahun N-1</th><td id="detail_n1"></td></tr>
                    <tr><th>★ Capaian Tahun N</th><td id="detail_n"></td></tr>
                    <tr><th>Gap</th><td id="detail_gap"></td></tr>
                    <tr><th>Status Capaian</th><td id="detail_kategori"></td></tr>
                    <tr><th>Sumber Data</th><td id="detail_nama_dokumen"></td></tr>
                    <tr><th>Catatan Tambahan</th><td id="detail_jenis_dokumen"></td></tr>
                    <tr><th>Tgl Kirim</th><td id="detail_tgl_kirim"></td></tr>
                    <tr><th>Tgl Terima</th><td id="detail_tgl_terima"></td></tr>
                    <tr><th>Status</th><td id="detail_status"></td></tr>
                    <tr><th>Keterangan Verifikasi</th><td id="detail_keterangan_verifikasi" class="text-danger fw-bold"></td></tr>
                    <tr><th>File Dokumen</th><td id="detail_files"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    // ===== Import Excel Helpers =====
    function updateDropLabel(input) {
        const label = document.getElementById('drop-label');
        const zone  = document.getElementById('drop-zone');
        if (input.files && input.files[0]) {
            label.textContent = '✅ ' + input.files[0].name;
            zone.style.background = '#DCFCE7';
        }
    }

    function handleDrop(event) {
        event.preventDefault();
        const zone  = document.getElementById('drop-zone');
        const input = document.getElementById('capaian-file-input');
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            input.files = files;
            updateDropLabel(input);
        }
        zone.style.background = '';
    }

    // Update download button label when year changes
    document.addEventListener('DOMContentLoaded', function () {
        const dlYear = document.getElementById('dl-year');
        const dlLabel = document.getElementById('dl-year-label');
        if (dlYear && dlLabel) {
            dlYear.addEventListener('change', function () {
                dlLabel.textContent = this.value;
            });
        }

        // Show loading state on import form submit
        const importForm = document.getElementById('importCapaianForm');
        if (importForm) {
            importForm.addEventListener('submit', function () {
                const btn = document.getElementById('importBtn');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
            });
        }
    });
    // ===== End Import Excel Helpers =====

    $(document).ready(function() {

        $('.select2').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalCreate'),
            width: '100%'
        });

        $('.select2-edit').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalEdit'),
            width: '100%'
        });

        $('#manual-year').on('change', function() {
            $('#manual-year-label').text(this.value);
        });

        $('#edit_year').on('change', function() {
            $('#edit_year_label').text(this.value);
        });

        // Edit Button Click
        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: `{{ route('capaian_kabupaten.index') }}/${id}/edit`,
                type: 'GET',
                success: function(data) {
                    $('#formEdit').attr('action', `{{ route('capaian_kabupaten.index') }}/${id}`);
                    $('#edit_tpb_id').val(data.tpb_id).trigger('change');
                    $('#edit_target_id').val(data.target_id).trigger('change');
                    $('#edit_indikator_id').val(data.indikator_id).trigger('change');
                    $('#edit_rpjmd_id').val(data.rpjmd_id).trigger('change');
                    $('#edit_opd').val(data.opd);
                    const currentYear = new Date().getFullYear();
                    const yearFields = [
                        { year: currentYear, value: data.tahun_n },
                        { year: currentYear - 1, value: data.tahun_n1 },
                        { year: currentYear - 2, value: data.tahun_n2 },
                        { year: currentYear - 3, value: data.tahun_n3 },
                        { year: currentYear - 4, value: data.tahun_n4 },
                    ];
                    const filledYear = yearFields.find(item => item.value && item.value !== '-');
                    $('#edit_year').val(filledYear ? filledYear.year : currentYear).trigger('change');
                    $('#edit_capaian_manual').val(filledYear ? filledYear.value : '');
                    $('#edit_gap').val(data.gap);
                    $('#edit_kategori_capaian').val(data.kategori_capaian).trigger('change');
                    $('#edit_nama_dokumen').val(data.nama_dokumen);
                    $('#edit_jenis_dokumen').val(data.jenis_dokumen);
                    
                    $('#modalEdit').modal('show');
                }
            });
        });

        // Detail Button Click
        $('.btn-detail').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: `{{ route('capaian_kabupaten.index') }}/${id}/edit`,
                type: 'GET',
                success: function(data) {
                    $('#detail_no_tiket').text(data.no_tiket);
                    $('#detail_wilayah').text(data.wilayah);
                    $('#detail_opd').text(data.opd);
                    $('#detail_tpb').text(data.tpb ? data.tpb.no_tpb + ' - ' + data.tpb.nama_tpb : '-');
                    $('#detail_target').text(data.target ? data.target.no_target + ' - ' + data.target.nama_target : '-');
                    $('#detail_indikator').text(data.indikator ? data.indikator.no_indikator + ' - ' + data.indikator.target_rpjmd : '-');
                    $('#detail_rpjmd').text(data.rpjmd ? data.rpjmd.no_indikator_rpjmd + ' - ' + data.rpjmd.indikator_kinerja : '-');
                    $('#detail_n4').text(data.tahun_n4);
                    $('#detail_n3').text(data.tahun_n3);
                    $('#detail_n2').text(data.tahun_n2);
                    $('#detail_n1').text(data.tahun_n1);
                    $('#detail_n').text(data.tahun_n);
                    $('#detail_gap').text(data.gap);
                    const statusCapaianLabels = {
                        SS: 'Tercapai (SS)',
                        SB: 'Dalam Proses (SB)',
                        BB: 'Belum Tercapai (BB)'
                    };
                    $('#detail_kategori').text(statusCapaianLabels[data.kategori_capaian] || data.kategori_capaian || '-');
                    $('#detail_nama_dokumen').text(data.nama_dokumen);
                    $('#detail_jenis_dokumen').text(data.jenis_dokumen);
                    $('#detail_tgl_kirim').text(data.tanggal_kirim);
                    $('#detail_tgl_terima').text(data.tanggal_terima ? data.tanggal_terima : '-');
                    $('#detail_status').text(data.status);
                    $('#detail_keterangan_verifikasi').text(data.keterangan_verifikasi ? data.keterangan_verifikasi : '-');
                    
                    var filesHtml = '';
                    if(data.files) {
                        var files = JSON.parse(data.files);
                        files.forEach(function(file) {
                            filesHtml += `<a href="{{ asset('storage/capaian_dokumen') }}/${file}" target="_blank" class="badge bg-info me-1"><i class="bx bx-download"></i> ${file}</a>`;
                        });
                    }
                    $('#detail_files').html(filesHtml);

                    $('#modalDetail').modal('show');
                }
            });
        });

        // Review Button Click
        var currentReviewId = null;
        $('.btn-review').on('click', function() {
            currentReviewId = $(this).data('id');
            $('#keterangan_verifikasi').val('');
            $('#modalReview').modal('show');
        });

        $('#btnVerify').on('click', function() {
            submitReview('verify');
        });

        $('#btnReject').on('click', function() {
            if($('#keterangan_verifikasi').val() == '') {
                alert('Keterangan wajib diisi jika menolak data!');
                return;
            }
            submitReview('reject');
        });

        function submitReview(action) {
            var url = action == 'verify' ? "{{ route('capaian_kabupaten.verify', ':id') }}".replace(':id', currentReviewId) : "{{ route('capaian_kabupaten.reject', ':id') }}".replace(':id', currentReviewId);
            var $button = action == 'verify' ? $('#btnVerify') : $('#btnReject');
            var originalText = $button.html();

            $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    keterangan_verifikasi: $('#keterangan_verifikasi').val()
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    const message = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Terjadi kesalahan saat memproses data.';
                    alert(message);
                    $button.prop('disabled', false).html(originalText);
                }
            });
        }

        // Auto-open detail if parameter exists in URL
        const urlParams = new URLSearchParams(window.location.search);
        const detailId = urlParams.get('detail');
        if (detailId) {
            $('.btn-detail[data-id="' + detailId + '"]').first().trigger('click');
        }
    });
</script>
@endsection
