<!-- Modal Import -->
<div class="modal fade" id="modal-import" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('indikator.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Target</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        Silakan download template berikut, isi data sesuai format, dan upload kembali. Pastikan <strong>No Indikator</strong> sesuai dengan master data sistem.
                    </div>
                    <!-- Assuming a template file is stored somewhere. You can adjust the link later. -->
                    <a href="{{ asset('template_import_indikator.xlsx') }}" class="btn btn-outline-info mb-3 btn-sm" target="_blank"><i class="bx bx-download"></i> Download Template</a>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File Excel (xlsx, xls)</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-upload"></i> Proses Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
