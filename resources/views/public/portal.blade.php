<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Portal Publik Transparansi | E-TPB</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />
  <style>
    * { box-sizing: border-box; }
    html, body { margin: 0; }
    body {
      font-family: 'Public Sans', sans-serif;
      background:
        radial-gradient(circle at top left, rgba(105,108,255,.12), transparent 30%),
        radial-gradient(circle at top right, rgba(41,181,246,.12), transparent 26%),
        linear-gradient(180deg, #f7f8ff 0%, #eef2ff 100%);
      color: #182230;
      overflow-x: hidden;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes softFloat {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-6px); }
    }
    @keyframes glowPulse {
      0%, 100% { box-shadow: 0 12px 30px rgba(67, 89, 113, .06); }
      50% { box-shadow: 0 16px 38px rgba(91, 99, 255, .14); }
    }
    @keyframes shimmer {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }
    .wrap { max-width: 1240px; margin: 0 auto; padding: 24px 18px 40px; }
    .topbar {
      display: flex; align-items: center; justify-content: space-between; gap: 14px;
      margin-bottom: 18px;
    }
    .brand {
      display: flex; align-items: center; gap: 14px;
      background: rgba(255,255,255,.82);
      border: 1px solid #edf0f5;
      border-radius: 20px;
      padding: 14px 18px;
      box-shadow: 0 12px 30px rgba(67, 89, 113, .06);
      min-width: 0;
      animation: fadeUp .6s ease both;
    }
    .brand-badge{
      width: 46px; height: 46px; border-radius: 14px;
      display:flex; align-items:center; justify-content:center;
      background: linear-gradient(135deg, rgba(105,108,255,.18), rgba(41,181,246,.16));
      color:#5b63ff; font-size: 1.2rem; flex: 0 0 auto;
    }
    .brand h2, .brand p { margin: 0; }
    .brand h2 { font-size: 1rem; line-height: 1.2; }
    .brand p { color: #7c8da5; font-size: .88rem; }
    .pill {
      display:inline-flex; align-items:center; gap:.45rem;
      background:#fff; border:1px solid #e7ebf3; border-radius:999px;
      padding:.55rem .85rem; color:#5a6880; font-weight:700; font-size:.9rem;
      box-shadow: 0 10px 22px rgba(67, 89, 113, .05);
      white-space: nowrap;
      animation: fadeUp .75s ease both;
    }
    .hero {
      background: linear-gradient(135deg, rgba(105,108,255,.14), rgba(255,255,255,.96) 45%, rgba(41,181,246,.08));
      border: 1px solid #e8ebf5;
      border-radius: 26px;
      box-shadow: 0 16px 42px rgba(67, 89, 113, .08);
      padding: 28px;
      display: grid;
      grid-template-columns: 1.25fr .95fr;
      gap: 22px;
      align-items: center;
      position: relative;
      overflow: hidden;
      animation: fadeUp .75s ease both;
    }
    .hero::before,
    .hero::after {
      content: "";
      position: absolute;
      inset: auto;
      border-radius: 999px;
      pointer-events: none;
      filter: blur(2px);
      opacity: .9;
    }
    .hero::before {
      width: 160px;
      height: 160px;
      top: -40px;
      right: -36px;
      background: radial-gradient(circle, rgba(105,108,255,.16), transparent 68%);
      animation: softFloat 8s ease-in-out infinite;
    }
    .hero::after {
      width: 120px;
      height: 120px;
      left: -24px;
      bottom: -28px;
      background: radial-gradient(circle, rgba(41,181,246,.12), transparent 68%);
      animation: softFloat 10s ease-in-out infinite reverse;
    }
    .eyebrow {
      color: #6670ff; font-weight: 800; font-size: .78rem; letter-spacing: .12em;
      text-transform: uppercase; margin-bottom: 10px;
      animation: fadeUp .65s ease both;
    }
    h1 {
      margin: 0 0 12px;
      font-size: clamp(2rem, 3.2vw, 3.4rem);
      line-height: 1.03;
      letter-spacing: 0;
      max-width: 14ch;
      animation: fadeUp .8s ease both;
    }
    .lead {
      margin: 0;
      color: #51647b;
      font-size: 1.05rem;
      line-height: 1.7;
      max-width: 760px;
      animation: fadeUp .95s ease both;
    }
    .hero-side {
      background: rgba(255,255,255,.76);
      border: 1px solid #edf0f5;
      border-radius: 22px;
      padding: 18px;
      backdrop-filter: blur(12px);
      animation: glowPulse 4.5s ease-in-out infinite, fadeUp .85s ease both;
    }
    .hero-side h3 { margin: 0 0 14px; font-size: 1rem; }
    .kpis { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 12px; }
    .kpi {
      background: #fff;
      border: 1px solid #edf0f5;
      border-radius: 18px;
      padding: 16px;
      box-shadow: 0 10px 24px rgba(67, 89, 113, .05);
      animation: fadeUp .85s ease both;
    }
    .kpi .label { color: #7c8da5; font-size: .84rem; margin-bottom: 6px; }
    .kpi .value { font-size: 1.8rem; font-weight: 800; color: #182230; line-height: 1; }
    .kpi .hint { margin-top: 8px; color: #6e7f95; font-size: .84rem; }
    .section { margin-top: 22px; }
    .section-head {
      display:flex; justify-content:space-between; align-items:flex-end; gap:12px; flex-wrap:wrap;
      margin-bottom: 12px;
    }
    .section-head h2 { margin: 0; font-size: 1.2rem; }
    .section-head span { color:#7c8da5; font-size:.92rem; }
    .summary-grid {
      display:grid;
      grid-template-columns: repeat(4, minmax(0,1fr));
      gap: 14px;
    }
    .summary {
      background: #fff;
      border: 1px solid #edf0f5;
      border-radius: 20px;
      padding: 18px;
      box-shadow: 0 12px 28px rgba(67, 89, 113, .06);
      animation: fadeUp .75s ease both;
    }
    .summary .label { color:#7c8da5; font-size:.88rem; }
    .summary .value { margin-top: 8px; font-size: 2rem; font-weight: 800; }
    .summary .desc { margin-top: 8px; color:#6e7f95; font-size:.88rem; line-height:1.45; }
    .summary.primary .value { color:#5b63ff; }
    .summary.success .value { color:#21a95e; }
    .summary.warning .value { color:#f0a202; }
    .summary.danger .value { color:#ef4b3f; }
    .panel {
      background:#fff;
      border:1px solid #edf0f5;
      border-radius: 20px;
      box-shadow: 0 12px 28px rgba(67, 89, 113, .06);
      overflow: hidden;
    }
    .panel-inner { padding: 18px; }
    .progress-list { display:grid; gap: 14px; }
    .progress-row { display:grid; grid-template-columns: 1.35fr .65fr; gap: 16px; align-items:center; }
    .progress-title { margin: 0 0 6px; font-weight: 700; }
    .progress-meta { color:#7c8da5; font-size:.9rem; }
    .bar {
      height: 12px;
      background: #edf0f5;
      border-radius: 999px;
      overflow: hidden;
      margin-top: 10px;
    }
    .bar > span {
      display:block;
      height:100%;
      border-radius: inherit;
      background: linear-gradient(90deg, #5b63ff, #29b5f6, #7c8dff);
      background-size: 200% 100%;
      animation: shimmer 3.4s linear infinite;
    }
    .trend {
      display:flex; align-items:center; justify-content:flex-end; gap:10px;
      font-weight:800;
      color:#182230;
    }
    .trend small {
      font-weight:700; color:#6e7f95; background:#f5f7fb; border:1px solid #edf0f5;
      border-radius:999px; padding:.3rem .55rem;
    }
    .insight {
      display:grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 14px;
    }
    .insight-card {
      padding: 18px;
      border-radius: 18px;
      border: 1px solid #edf0f5;
      background: linear-gradient(180deg, #fff, #fbfcff);
      animation: fadeUp .8s ease both;
    }
    .insight-card strong { display:block; margin-bottom: 6px; }
    .insight-card p { margin: 0; color:#607186; line-height:1.55; }
    .timeline { display:grid; gap: 12px; }
    .timeline-item {
      display:grid;
      grid-template-columns: 82px 1fr auto;
      gap: 14px;
      align-items:center;
      padding: 14px 16px;
      border: 1px solid #edf0f5;
      border-radius: 16px;
      background: linear-gradient(180deg, #fff, #fbfcff);
      animation: fadeUp .7s ease both;
    }
    .timeline-item time {
      color:#5b63ff;
      font-weight:800;
      font-size:.84rem;
    }
    .timeline-item .main { font-weight:700; margin-bottom: 4px; }
    .timeline-item .sub { color:#6e7f95; font-size:.9rem; }
    .status {
      padding:.45rem .7rem;
      border-radius:999px;
      font-weight:800;
      font-size:.8rem;
      border:1px solid transparent;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .status:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 20px rgba(67, 89, 113, .08);
    }
    .status.ok { background:#eaf8ef; color:#1f8f4d; border-color:#cfeedd; }
    .status.proc { background:#fff7e6; color:#b97700; border-color:#ffe4b5; }
    .status.bad { background:#fdecea; color:#c63f32; border-color:#fad1cd; }
    .footer {
      text-align:center;
      color:#7c8da5;
      margin-top: 18px;
      font-size:.92rem;
    }
    @media (max-width: 1024px) {
      .hero, .summary-grid, .insight { grid-template-columns: 1fr 1fr; }
      .progress-row { grid-template-columns: 1fr; }
      .timeline-item { grid-template-columns: 1fr; justify-items: start; }
    }
    @media (max-width: 767.98px) {
      .wrap { padding: 16px 14px 30px; }
      .topbar { flex-direction: column; align-items: stretch; }
      .brand { width: 100%; }
      .pill { width: 100%; justify-content: center; }
      .hero { grid-template-columns: 1fr; padding: 20px; border-radius: 20px; }
      .summary-grid, .kpis, .insight { grid-template-columns: 1fr; }
      h1 { max-width: none; font-size: 1.8rem; }
    }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation: none !important;
        transition: none !important;
        scroll-behavior: auto !important;
      }
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="topbar">
      <div class="brand">
        <div class="brand-badge"><i class="bx bx-line-chart"></i></div>
        <div>
          <h2>Portal Publik Transparansi E-TPB</h2>
          <p>Dinas Lingkungan Hidup Provinsi Kalimantan Selatan</p>
        </div>
      </div>
      <div class="pill"><i class="bx bx-shield-quarter"></i> Terbuka untuk masyarakat</div>
    </div>

    <div class="hero">
      <div>
        <div class="eyebrow">Portal publik transparansi</div>
        <h1>Data capaian TPB yang terverifikasi, mudah dipantau masyarakat</h1>
        <p class="lead">
          Portal ini menampilkan hasil capaian yang sudah diverifikasi pemerintah daerah,
          sehingga masyarakat dapat melihat perkembangan janji RPJMD secara terbuka, rapi, dan mudah dipahami.
        </p>
      </div>
      <div class="hero-side">
        <h3>Ringkasan cepat</h3>
        <div class="kpis">
          <div class="kpi">
            <div class="label">Publikasi data</div>
            <div class="value">{{ $publikasiRate }}%</div>
            <div class="hint">{{ $totalTerverifikasi }} dari {{ $totalData }} data sudah terverifikasi</div>
          </div>
          <div class="kpi">
            <div class="label">Indikator aktif</div>
            <div class="value">{{ $indikatorCount }}</div>
            <div class="hint">Indikator yang siap dipantau publik</div>
          </div>
          <div class="kpi">
            <div class="label">TPB tersedia</div>
            <div class="value">{{ $tpbCount }}</div>
            <div class="hint">Kelompok tujuan pembangunan berkelanjutan</div>
          </div>
          <div class="kpi">
            <div class="label">Status menunggu</div>
            <div class="value">{{ $totalMenunggu }}</div>
            <div class="hint">Masih dalam proses verifikasi</div>
          </div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-head">
        <h2>Gambaran data publik</h2>
        <span>Angka utama yang paling relevan untuk masyarakat</span>
      </div>
      <div class="summary-grid">
        <div class="summary primary">
          <div class="label">Data Terverifikasi</div>
          <div class="value">{{ $totalTerverifikasi }}</div>
          <div class="desc">Sudah lolos verifikasi dan tampil di portal publik.</div>
        </div>
        <div class="summary success">
          <div class="label">Indikator Aktif</div>
          <div class="value">{{ $indikatorCount }}</div>
          <div class="desc">Indikator yang dapat dipantau melalui TPB dan RPJMD.</div>
        </div>
        <div class="summary warning">
          <div class="label">Menunggu Verifikasi</div>
          <div class="value">{{ $totalMenunggu }}</div>
          <div class="desc">Data masuk tetapi belum ditayangkan ke publik.</div>
        </div>
        <div class="summary danger">
          <div class="label">Ditolak</div>
          <div class="value">{{ $totalDitolak }}</div>
          <div class="desc">Data yang belum memenuhi validasi dan perlu perbaikan.</div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-head">
        <h2>Komposisi publikasi</h2>
        <span>Proporsi data yang sudah siap untuk masyarakat</span>
      </div>
      <div class="panel">
        <div class="panel-inner">
          @php
            $published = $totalTerverifikasi;
            $pending = $totalMenunggu;
            $rejected = $totalDitolak;
            $safeTotal = max(1, $totalData);
            $publishedPct = round(($published / $safeTotal) * 100);
            $pendingPct = round(($pending / $safeTotal) * 100);
            $rejectedPct = round(($rejected / $safeTotal) * 100);
          @endphp
          <div class="progress-list">
            <div class="progress-row">
              <div>
                <div class="progress-title">Terverifikasi</div>
                <div class="progress-meta">{{ $published }} data siap dipublikasikan</div>
                <div class="bar"><span style="width: {{ $publishedPct }}%"></span></div>
              </div>
              <div class="trend">
                {{ $publishedPct }}% <small>siap publik</small>
              </div>
            </div>
            <div class="progress-row">
              <div>
                <div class="progress-title">Menunggu Verifikasi</div>
                <div class="progress-meta">{{ $pending }} data masih antre validasi</div>
                <div class="bar"><span style="width: {{ $pendingPct }}%; background: linear-gradient(90deg, #f0a202, #f4b942)"></span></div>
              </div>
              <div class="trend">
                {{ $pendingPct }}% <small>proses</small>
              </div>
            </div>
            <div class="progress-row">
              <div>
                <div class="progress-title">Ditolak</div>
                <div class="progress-meta">{{ $rejected }} data perlu perbaikan</div>
                <div class="bar"><span style="width: {{ $rejectedPct }}%; background: linear-gradient(90deg, #ef4b3f, #ff7a6e)"></span></div>
              </div>
              <div class="trend">
                {{ $rejectedPct }}% <small>perlu revisi</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-head">
        <h2>Sorotan terbaru</h2>
        <span>Data terverifikasi paling baru yang ditampilkan ke publik</span>
      </div>
      <div class="insight">
        <div class="insight-card">
          <strong>Transparansi capaian</strong>
          <p>Warga dapat melihat perkembangan indikator yang sudah diverifikasi tanpa harus masuk ke sistem.</p>
        </div>
        <div class="insight-card">
          <strong>Ruang pemantauan</strong>
          <p>Informasi disusun agar mudah dipahami, dari TPB, indikator, sampai status capaian per data.</p>
        </div>
        <div class="insight-card">
          <strong>Publikasi terukur</strong>
          <p>Portal menekankan data yang siap publik agar informasi tetap bersih, relevan, dan dapat dipercaya.</p>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-head">
        <h2>Rangkuman terbaru</h2>
        <span>Update data yang terakhir diverifikasi</span>
      </div>
      <div class="panel">
        <div class="panel-inner timeline">
          @forelse($highlights as $item)
            <div class="timeline-item">
              <time>{{ $item->tanggal_terima ? \Carbon\Carbon::parse($item->tanggal_terima)->format('d M') : '-' }}</time>
              <div>
                <div class="main">{{ $item->tpb->nama_tpb ?? 'TPB' }} - {{ $item->indikator->nama_indikator_tpb ?? 'Indikator' }}</div>
                <div class="sub">OPD {{ $item->opd }} | Status {{ $item->kategori_capaian ?? '-' }} | {{ $item->wilayah ?? '-' }}</div>
              </div>
              <span class="status {{ ($item->kategori_capaian ?? '') === 'SS' ? 'ok' : (($item->kategori_capaian ?? '') === 'SB' ? 'proc' : 'bad') }}">
                {{ $item->kategori_capaian ?? '-' }}
              </span>
            </div>
          @empty
            <div class="muted">Belum ada data terverifikasi yang dipublikasikan.</div>
          @endforelse
        </div>
      </div>
    </div>

    <div class="footer">
      Portal ini terbuka untuk masyarakat tanpa login.
    </div>
  </div>
</body>
</html>
