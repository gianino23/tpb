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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    * { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; }
    body {
      font-family: 'Public Sans', sans-serif;
      background: #f8f9fa;
      color: #2b303a;
      overflow-x: hidden;
      padding: 40px 20px;
    }
    .container {
      max-width: 1000px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }
    
    /* Premium Card Styles */
    .dashboard-card {
      background: #ffffff;
      border: 1px solid #eef0f3;
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    
    .card-header {
      margin-bottom: 24px;
    }
    
    .card-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #1e293b;
      margin: 0 0 6px 0;
    }
    
    .card-subtitle {
      font-size: 0.9rem;
      color: #64748b;
      margin: 0;
    }
    
    /* Selection Area */
    .filter-section {
      display: flex;
      flex-direction: column;
      gap: 16px;
      margin-bottom: 24px;
    }
    
    .filter-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    
    .filter-label {
      font-size: 0.85rem;
      font-weight: 600;
      color: #475569;
    }
    
    .filter-select {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      background-color: #fafaf9;
      font-size: 0.95rem;
      font-weight: 500;
      color: #1e293b;
      outline: none;
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-size: 16px;
      transition: border-color 0.2s, background-color 0.2s;
    }
    
    .filter-select:focus {
      border-color: #cbd5e1;
      background-color: #ffffff;
    }
    
    /* Header Button */
    .header-action-container {
      display: flex;
      justify-content: flex-end;
      margin-top: -8px;
      margin-bottom: 20px;
    }
    
    .btn-action {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #ffffff;
      border: 1.5px solid #1e293b;
      border-radius: 8px;
      padding: 8px 16px;
      font-size: 0.88rem;
      font-weight: 600;
      color: #1e293b;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.2s, transform 0.1s;
    }
    
    .btn-action:hover {
      background-color: #f8fafc;
    }
    
    .btn-action:active {
      transform: scale(0.98);
    }
    
    /* KPI Grid */
    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }
    
    .kpi-card {
      background: #fafaf9;
      border: 1px solid #f1f1ef;
      border-radius: 12px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 100px;
    }
    
    .kpi-title {
      font-size: 0.78rem;
      font-weight: 600;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.02em;
    }
    
    .kpi-value {
      font-size: 1.75rem;
      font-weight: 800;
      color: #1e293b;
      margin: 8px 0;
      line-height: 1;
    }
    
    .kpi-value.green { color: #15803d; }
    .kpi-value.orange { color: #b45309; }
    .kpi-value.blue { color: #1d4ed8; }
    
    .kpi-desc {
      font-size: 0.8rem;
      color: #64748b;
      font-weight: 500;
    }
    
    /* Legend area */
    .legend-container {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 16px;
      font-size: 0.85rem;
      font-weight: 600;
      color: #475569;
    }
    
    .legend-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    
    .legend-dot {
      width: 10px;
      height: 10px;
      border-radius: 2px;
    }
    
    .legend-dot.green { background-color: #22c55e; }
    .legend-dot.orange { background-color: #f97316; }
    .legend-dot.red { background-color: #ef4444; }
    
    /* Table styling */
    .table-container {
      width: 100%;
      overflow-x: auto;
      margin-bottom: 20px;
    }
    
    .custom-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 0.9rem;
    }
    
    .custom-table th {
      background-color: #f5f5f3;
      color: #475569;
      font-weight: 700;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.05em;
      padding: 12px 16px;
      border-bottom: 1px solid #e2e8f0;
    }
    
    .custom-table td {
      padding: 16px;
      border-bottom: 1px solid #f1f5f9;
      color: #334155;
      font-weight: 500;
    }
    
    .custom-table tr:last-child td {
      border-bottom: none;
    }
    
    .custom-table tbody tr {
      transition: background-color 0.15s;
    }
    
    .custom-table tbody tr:hover {
      background-color: #fafafa;
    }
    
    .year-cell {
      font-weight: 700;
      color: #0f172a;
    }
    
    /* Badges */
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    
    .status-badge.green {
      background-color: #f0fdf4;
      color: #166534;
      border: 1px solid #dcfce7;
    }
    
    .status-badge.orange {
      background-color: #fffbeb;
      color: #92400e;
      border: 1px solid #fef3c7;
    }
    
    .status-badge.red {
      background-color: #fef2f2;
      color: #991b1b;
      border: 1px solid #fee2e2;
    }
    
    /* Custom Progress Bar */
    .progress-cell {
      display: flex;
      align-items: center;
      gap: 12px;
      min-width: 140px;
    }
    
    .progress-wrapper {
      flex-grow: 1;
      height: 8px;
      background-color: #f1f5f9;
      border-radius: 9999px;
      overflow: hidden;
      max-width: 100px;
    }
    
    .progress-fill {
      height: 100%;
      border-radius: 9999px;
    }
    
    .progress-fill.green { background-color: #22c55e; }
    .progress-fill.orange { background-color: #f97316; }
    .progress-fill.red { background-color: #ef4444; }
    
    .progress-text {
      font-weight: 700;
      color: #0f172a;
      min-width: 32px;
    }
    
    .trend-text {
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    
    .trend-text.up {
      color: #166534;
    }
    
    .trend-text.neutral {
      color: #64748b;
    }
    
    /* Chart Section */
    .chart-container {
      width: 100%;
      height: 280px;
      margin-top: 15px;
      margin-bottom: 20px;
      display: none;
    }
    
    /* Comparison Ranking badge */
    .rank-number {
      font-weight: 700;
      color: #64748b;
      width: 24px;
    }
    
    /* Footer section */
    .portal-footer {
      text-align: center;
      padding: 20px 0 40px;
      color: #94a3b8;
      font-size: 0.85rem;
      border-top: 1px solid #e2e8f0;
      margin-top: 20px;
    }

    @media (max-width: 768px) {
      .kpi-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .btn-action {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    
    <!-- CARD 1: Evaluasi Capaian TPB -->
    <div class="dashboard-card">
      <div class="card-header">
        <h1 class="card-title">Evaluasi capaian TPB per tahun — masa RPJMD 2022-2026</h1>
        <p class="card-subtitle">Pilih kabupaten/kota dan tahun untuk melihat ringkasan dan grafik perkembangan capaian indikator</p>
      </div>
      
      <!-- Filter Controls -->
      <div class="filter-section">
        <div class="filter-group">
          <label class="filter-label" for="regionSelect">Kabupaten/kota</label>
          <select id="regionSelect" class="filter-select">
            <option value="Banjar">Banjar</option>
            <option value="Barito Kuala">Barito Kuala</option>
            <option value="Banjarbaru">Banjarbaru</option>
            <option value="Banjarmasin">Banjarmasin</option>
            <option value="Hulu Sungai Selatan">Hulu Sungai Selatan</option>
            <option value="Hulu Sungai Tengah">Hulu Sungai Tengah</option>
            <option value="Hulu Sungai Utara">Hulu Sungai Utara</option>
            <option value="Kotabaru">Kotabaru</option>
            <option value="Tabalong">Tabalong</option>
            <option value="Tanah Bumbu">Tanah Bumbu</option>
            <option value="Tanah Laut">Tanah Laut</option>
            <option value="Tapin">Tapin</option>
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label" for="viewSelect">Tampilan</label>
          <select id="viewSelect" class="filter-select">
            <option value="table">Tabel per tahun</option>
            <option value="chart">Grafik tren</option>
            <option value="both">Keduanya</option>
          </select>
        </div>
      </div>
      
      <!-- Guide Button -->
      <div class="header-action-container">
        <a href="#" class="btn-action" onclick="alert('Panduan membaca: pilih Kabupaten/Kota untuk melihat rincian evaluasi target TPB. Kategori AB menandakan capaian target sudah terpenuhi (Sangat Sesuai), SB berarti dalam proses (Sesuai), dan BB belum terpenuhi.')">Panduan baca <i class="bx bx-right-arrow-alt"></i></a>
      </div>
      
      <!-- KPI stats grid -->
      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-title">Total indikator RPJMD</div>
          <div class="kpi-value" id="kpiTotal">17</div>
          <div class="kpi-desc">Indikator TPB</div>
        </div>
        
        <div class="kpi-card">
          <div class="kpi-title">Tercapai 2026</div>
          <div class="kpi-value green" id="kpiTercapai">12</div>
          <div class="kpi-desc" id="kpiTercapaiPct">70% dari total</div>
        </div>
        
        <div class="kpi-card">
          <div class="kpi-title">Dalam proses 2026</div>
          <div class="kpi-value orange" id="kpiProses">3</div>
          <div class="kpi-desc">Perlu percepatan</div>
        </div>
        
        <div class="kpi-card">
          <div class="kpi-title">Kenaikan 2022→2026</div>
          <div class="kpi-value blue" id="kpiKenaikan">+20%</div>
          <div class="kpi-desc">Progres 6 tahun</div>
        </div>
      </div>
      
      <!-- Legend -->
      <div class="legend-container" id="tableLegend">
        <div class="legend-item">
          <span class="legend-dot green"></span>
          <span>Tercapai (AB)</span>
        </div>
        <div class="legend-item">
          <span class="legend-dot orange"></span>
          <span>Dalam proses (SB)</span>
        </div>
        <div class="legend-item">
          <span class="legend-dot red"></span>
          <span>Belum tercapai (BB)</span>
        </div>
      </div>
      
      <!-- Table View -->
      <div class="table-container" id="yearlyTableContainer">
        <table class="custom-table">
          <thead>
            <tr>
              <th>Tahun</th>
              <th>Total Indikator</th>
              <th>Tercapai (AB)</th>
              <th>Dalam Proses (SB)</th>
              <th>Belum Tercapai (BB)</th>
              <th>% Capaian</th>
              <th>Tren</th>
            </tr>
          </thead>
          <tbody id="yearlyTableBody">
            <!-- Populated via Javascript -->
          </tbody>
        </table>
      </div>
      
      <!-- Chart View -->
      <div class="chart-container" id="chartContainer">
        <canvas id="trendChart"></canvas>
      </div>
      
    </div>
    
    <!-- CARD 2: Perbandingan Semua Kabupaten/Kota -->
    <div class="dashboard-card">
      <div class="card-header">
        <h2 class="card-title">Perbandingan semua kabupaten/kota — tahun terpilih</h2>
        <p class="card-subtitle">Peringkat capaian berdasarkan persentase indikator yang tercapai (AB)</p>
      </div>
      
      <div class="filter-section">
        <div class="filter-group">
          <label class="filter-label" for="yearSelect">Tahun</label>
          <select id="yearSelect" class="filter-select">
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
          </select>
        </div>
      </div>
      
      <div class="header-action-container">
        <a href="#" class="btn-action" onclick="alert('Membuka analisis lanjut untuk perbandingan indikator regional...')">Analisis lanjut <i class="bx bx-right-arrow-alt"></i></a>
      </div>
      
      <div class="table-container">
        <table class="custom-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Kabupaten/Kota</th>
              <th>Total</th>
              <th>AB</th>
              <th>SB</th>
              <th>BB</th>
              <th>% Tercapai</th>
            </tr>
          </thead>
          <tbody id="comparisonTableBody">
            <!-- Populated via Javascript -->
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- FOOTER -->
    <div class="portal-footer">
      Portal Transparansi Publik TPB &copy; 2026 - Dinas Lingkungan Hidup Provinsi Kalimantan Selatan
    </div>
    
  </div>

  <script>
    // Live database verified dashboard data
    const regionsBaseline = @json($dashboardData);

    let trendChartInstance = null;


    // DOM Elements
    const regionSelect = document.getElementById('regionSelect');
    const viewSelect = document.getElementById('viewSelect');
    const yearSelect = document.getElementById('yearSelect');
    const yearlyTableBody = document.getElementById('yearlyTableBody');
    const comparisonTableBody = document.getElementById('comparisonTableBody');
    const chartContainer = document.getElementById('chartContainer');
    const yearlyTableContainer = document.getElementById('yearlyTableContainer');
    const tableLegend = document.getElementById('tableLegend');

    // KPI DOM Elements
    const kpiTotal = document.getElementById('kpiTotal');
    const kpiTercapai = document.getElementById('kpiTercapai');
    const kpiTercapaiPct = document.getElementById('kpiTercapaiPct');
    const kpiProses = document.getElementById('kpiProses');
    const kpiKenaikan = document.getElementById('kpiKenaikan');

    // Update Year-per-year Table
    function updateYearlyTable(region) {
      const dataList = regionsBaseline[region];
      yearlyTableBody.innerHTML = '';

      dataList.forEach(row => {
        const isUp = row.trend.includes('+');
        const trendClass = isUp ? 'up' : 'neutral';
        const progressFillColor = row.percent >= 60 ? 'green' : (row.percent >= 40 ? 'orange' : 'red');

        yearlyTableBody.innerHTML += `
          <tr>
            <td class="year-cell">${row.year}</td>
            <td>${row.total}</td>
            <td><span class="status-badge green">${row.ab} indikator</span></td>
            <td><span class="status-badge orange">${row.sb} indikator</span></td>
            <td><span class="status-badge red">${row.bb} indikator</span></td>
            <td>
              <div class="progress-cell">
                <div class="progress-wrapper">
                  <div class="progress-fill ${progressFillColor}" style="width: ${row.percent}%"></div>
                </div>
                <span class="progress-text">${row.percent}%</span>
              </div>
            </td>
            <td>
              <span class="trend-text ${trendClass}">
                ${row.trend}
              </span>
            </td>
          </tr>
        `;
      });
      
      // Update KPIs based on the selected region (displaying 2026 data as latest)
      const data2022 = dataList.find(y => y.year === 2022);
      const data2026 = dataList.find(y => y.year === 2026);
      
      kpiTotal.textContent = data2026.total;
      kpiTercapai.textContent = data2026.ab;
      kpiTercapaiPct.textContent = `${data2026.percent}% dari total`;
      kpiProses.textContent = data2026.sb;
      
      const percent2022 = data2022 ? data2022.percent : 0;
      const diff = data2026.percent - percent2022;
      kpiKenaikan.textContent = `${diff >= 0 ? '+' : ''}${diff}%`;
    }

    // Update Comparison Rankings Table
    function updateComparisonTable(year) {
      const yearInt = parseInt(year);
      const yearDataList = [];

      Object.keys(regionsBaseline).forEach(regionName => {
        const yrData = regionsBaseline[regionName].find(y => y.year === yearInt);
        if (yrData) {
          yearDataList.push({
            name: regionName,
            total: yrData.total,
            ab: yrData.ab,
            sb: yrData.sb,
            bb: yrData.bb,
            percent: yrData.percent
          });
        }
      });

      // Sort by % Capaian DESC
      yearDataList.sort((a, b) => b.percent - a.percent);

      comparisonTableBody.innerHTML = '';
      yearDataList.forEach((row, index) => {
        const progressFillColor = row.percent >= 60 ? 'green' : (row.percent >= 40 ? 'orange' : 'red');
        
        comparisonTableBody.innerHTML += `
          <tr>
            <td><div class="rank-number">${index + 1}</div></td>
            <td style="font-weight: 700; color: #1e293b;">${row.name}</td>
            <td>${row.total}</td>
            <td><span class="status-badge green">${row.ab}</span></td>
            <td><span class="status-badge orange">${row.sb}</span></td>
            <td><span class="status-badge red">${row.bb}</span></td>
            <td>
              <div class="progress-cell">
                <div class="progress-wrapper">
                  <div class="progress-fill ${progressFillColor}" style="width: ${row.percent}%"></div>
                </div>
                <span class="progress-text">${row.percent}%</span>
              </div>
            </td>
          </tr>
        `;
      });
    }

    // Render / Update Chart.js Trend Graph
    function updateTrendChart(region) {
      const dataList = regionsBaseline[region];
      const labels = dataList.map(y => y.year.toString());
      const percentages = dataList.map(y => y.percent);

      if (trendChartInstance) {
        trendChartInstance.destroy();
      }

      const ctx = document.getElementById('trendChart').getContext('2d');
      trendChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Persentase Capaian (%)',
            data: percentages,
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.3,
            pointRadius: 6,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#22c55e',
            pointBorderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          },
          scales: {
            y: {
              min: 0,
              max: 100,
              grid: { color: '#f1f5f9' },
              ticks: { font: { family: 'Public Sans', weight: '500' } }
            },
            x: {
              grid: { display: false },
              ticks: { font: { family: 'Public Sans', weight: '700' } }
            }
          }
        }
      });
    }

    // Setup displays based on view selection
    function handleViewChange() {
      const mode = viewSelect.value;
      
      if (mode === 'table') {
        yearlyTableContainer.style.display = 'block';
        tableLegend.style.display = 'flex';
        chartContainer.style.display = 'none';
      } else if (mode === 'chart') {
        yearlyTableContainer.style.display = 'none';
        tableLegend.style.display = 'none';
        chartContainer.style.display = 'block';
        updateTrendChart(regionSelect.value);
      } else {
        yearlyTableContainer.style.display = 'block';
        tableLegend.style.display = 'flex';
        chartContainer.style.display = 'block';
        updateTrendChart(regionSelect.value);
      }
    }

    // Event listeners
    regionSelect.addEventListener('change', (e) => {
      updateYearlyTable(e.target.value);
      if (viewSelect.value !== 'table') {
        updateTrendChart(e.target.value);
      }
    });

    viewSelect.addEventListener('change', handleViewChange);

    yearSelect.addEventListener('change', (e) => {
      updateComparisonTable(e.target.value);
    });

    // Initialize Default State
    window.addEventListener('DOMContentLoaded', () => {
      updateYearlyTable('Banjar');
      updateComparisonTable('2022');
      handleViewChange();
    });
  </script>
</body>
</html>
