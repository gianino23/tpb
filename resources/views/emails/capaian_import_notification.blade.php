<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; }
        .header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 0.8em; color: #777; }
        .label { font-weight: bold; width: 180px; display: inline-block; }
        .badge { background-color: #2563eb; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>Kepada Yth. Operator Provinsi</h3>
            <p>E-TPB Dinas Lingkungan Hidup Prov. Kalimantan Selatan</p>
        </div>

        <p>Kami menginformasikan bahwa telah dilakukan pengunggahan massal data capaian melalui Excel oleh Operator Kabupaten/Kota dengan ringkasan sebagai berikut:</p>

        <hr>
        <h4>RINGKASAN UNGGAHAN MASSEL (EXCEL)</h4>
        <hr>

        <p><span class="label">Nama Pengirim</span> : {{ $user->name }}</p>
        <p><span class="label">Instansi/OPD</span> : {{ $user->dinas ?? '-' }}</p>
        <p><span class="label">Wilayah</span> : Kabupaten/Kota {{ $user->wilayah ?? '-' }}</p>
        <p><span class="label">Tahun Data Capaian</span> : <strong>{{ $importYear }}</strong></p>
        <p><span class="label">Jumlah Data Diimport</span> : <span class="badge">{{ $successCount }} Baris Data</span></p>
        <p><span class="label">Waktu Unggah</span> : {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</p>
        <p><span class="label">Status Pengajuan</span> : <span style="color: orange; font-weight: bold;">Menunggu Verifikasi</span></p>

        <p style="margin-top: 20px;">Silakan masuk ke panel admin E-TPB untuk meninjau dan melakukan verifikasi terhadap data-data tersebut.</p>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem E-TPB Dinas Lingkungan Hidup Prov. Kalsel. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
