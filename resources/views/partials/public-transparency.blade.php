<section class="public-transparency-banner">
  <div class="public-transparency-card">
    <div class="public-transparency-text">
      <h2>Portal Publik Transparansi (untuk masyarakat)</h2>
      <p>
        Data capaian yang sudah terverifikasi dipublikasikan ke website.
        Masyarakat bisa melihat sendiri apakah janji RPJMD pemerintah daerah
        terpenuhi atau tidak.
      </p>
    </div>
  </div>
</section>

<style>
  .public-transparency-banner {
    width: 100%;
  }

  .public-transparency-card {
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 18px;
    box-shadow: 0 12px 30px rgba(67, 89, 113, 0.08);
    padding: 1.35rem 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .public-transparency-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
      linear-gradient(90deg, rgba(105, 108, 255, 0.08), transparent 30%),
      radial-gradient(circle at top right, rgba(41, 181, 246, 0.12), transparent 35%);
    pointer-events: none;
  }

  .public-transparency-text {
    position: relative;
    z-index: 1;
    max-width: 980px;
  }

  .public-transparency-text h2 {
    margin: 0 0 .35rem;
    color: #182230;
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: 0;
  }

  .public-transparency-text p {
    margin: 0;
    color: #4f627a;
    font-size: 1.05rem;
    line-height: 1.55;
    max-width: 980px;
  }

  @media (max-width: 767.98px) {
    .public-transparency-card {
      padding: 1.05rem 1rem;
      border-radius: 14px;
    }

    .public-transparency-text h2 {
      font-size: 1.15rem;
    }

    .public-transparency-text p {
      font-size: .95rem;
    }
  }
</style>
