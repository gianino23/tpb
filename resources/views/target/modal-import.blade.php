<!-- Modal Import Data Target -->
<div class="modal fade" id="modal-import" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('target.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Indikator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-1"></i>
                        Upload file Excel untuk mengimport data Indikator. File harus memiliki kolom: <strong>No TPB</strong>, <strong>No Indikator</strong>, <strong>Indikator TPB</strong>.
                    </div>

                    <a href="{{ route('target.download-template') }}" class="btn btn-outline-info mb-3 btn-sm" target="_blank">
                        <i class="bx bx-download"></i> Download Template
                    </a>

                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File Excel (xlsx, xls)</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".xlsx, .xls" required>
                    </div>

                    <div class="alert alert-warning small py-2 mb-0">
                        <i class="bx bx-info-circle me-1"></i>
                        Data yang sudah ada <strong>tidak akan dihapus</strong>. Import hanya akan menambahkan data baru. Data dengan No Indikator yang sudah ada akan dilewati.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-upload me-1"></i> Proses Import
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
