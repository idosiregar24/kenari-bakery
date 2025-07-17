<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white">
      <h4 class="mb-0">📝 Form Feedback Pesanan</h4>
    </div>
    <div class="card-body">
      <form action="<?= site_url('user/simpan_feedback') ?>" method="post">
        <!-- ID Pesanan (hidden) -->
        <input type="hidden" name="id_pesanan" value="<?= $pesanan->id_pesanan ?>">

        <!-- Tanggal Pesanan -->
        <div class="mb-3">
          <label class="form-label">ID Pesanan</label>
          <input type="text" class="form-control" value="<?= $pesanan->id_pesanan ?>" readonly>
        </div>
        
        <!-- Komentar -->
        <div class="mb-3">
          <label class="form-label">Komentar</label>
          <textarea name="komentar" class="form-control" rows="4" placeholder="Tulis pendapat Anda tentang pesanan..." required></textarea>
        </div>

        <!-- Tombol Submit -->
        <div class="d-flex justify-content-end">
          <a href="<?= site_url('user/pesanan_selesai') ?>" class="btn btn-secondary me-2">Kembali</a>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Kirim Feedback
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
