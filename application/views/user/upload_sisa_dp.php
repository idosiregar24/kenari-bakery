<div class="container my-5">
  <h3 class="mb-4 text-primary"><i class="fas fa-upload"></i> Upload Bukti Pelunasan Sisa DP</h3>

  <div class="card shadow">
    <div class="card-body">
      <form action="<?= base_url('user/proses_upload_sisa_dp/') ?>" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="id_pesanan" value="<?= $pesanan->id_pesanan ?>">

        <div class="mb-3">
          <label for="bukti_sisa_dp" class="form-label">Bukti Pembayaran (JPG, PNG, PDF):</label>
          <input type="file" name="bukti_sisa_dp" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>

        <button type="submit" class="btn btn-success">
          <i class="fas fa-check"></i> Upload
        </button>
        <a href="<?= base_url('user') ?>" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </form>
    </div>
  </div>
</div>
