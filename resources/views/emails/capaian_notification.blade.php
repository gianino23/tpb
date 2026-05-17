<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; }
        .header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 0.8em; color: #777; }
        .label { font-weight: bold; width: 150px; display: inline-block; }
        .status-diterima { color: green; font-weight: bold; }
        .status-ditolak { color: red; font-weight: bold; }
        .status-menunggu { color: orange; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>Kepada Yth.</h3>
            <p>
                {{ $capaian->user->name }}<br>
                {{ $capaian->opd }}<br>
                Kabupaten/Kota {{ $capaian->wilayah }}
            </p>
        </div>

        <p>Sistem kami telah mencatat 
            @if($capaian->status == 'Menunggu Verifikasi') penerimaan @else pembaruan status @endif 
            dokumen dengan detail sebagai berikut:</p>

        <hr>
        <h4>INFORMASI DOKUMEN</h4>
        <hr>

        <p><span class="label">Nomor Tiket</span> : {{ $capaian->no_tiket }}</p>
        <p><span class="label">Nama Dokumen</span> : {{ $capaian->nama_dokumen }}</p>
        <p><span class="label">Jenis Dokumen</span> : {{ $capaian->jenis_dokumen }}</p>
        <p><span class="label">Dikirim oleh</span> : {{ $capaian->opd }} - Kab/Kota {{ $capaian->wilayah }}</p>
        <p><span class="label">Tanggal Kirim</span> : {{ \Carbon\Carbon::parse($capaian->tanggal_kirim)->format('d F Y, H:i') }} WIB</p>
        
        @if($capaian->tanggal_terima)
        <p><span class="label">Tanggal Terima</span> : {{ \Carbon\Carbon::parse($capaian->tanggal_terima)->format('d F Y, H:i') }} WIB</p>
        @endif

        <p><span class="label">Status</span> : 
            @if($capaian->status == 'Menunggu Verifikasi')
                <span class="status-menunggu">✅ DITERIMA - Menunggu Verifikasi</span>
            @elseif($capaian->status == 'Terverifikasi')
                <span class="status-diterima">✅ TERVERIFIKASI - Dokumen Diterima</span>
            @elseif($capaian->status == 'Ditolak')
                <span class="status-ditolak">❌ DITOLAK - Perlu Perbaikan</span>
            @endif
        </p>

        @if($capaian->keterangan_verifikasi)
        <p><span class="label">Catatan</span> : <span style="color: red;">{{ $capaian->keterangan_verifikasi }}</span></p>
        @endif

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem E-TPB Dinas Lingkungan Hidup Prov. Kalsel. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
