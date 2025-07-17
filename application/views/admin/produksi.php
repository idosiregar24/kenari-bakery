<div class="container mt-5">
  <!-- Header dan Tombol Cetak -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">📦 Daftar Pesanan Produksi</h3>
    <a href="<?= site_url('admin/cetak_pdf_produksi?start=' . $this->input->get('start') . '&end=' . $this->input->get('end')) ?>" 
       target="_blank" class="btn btn-danger">
      <i class="fas fa-file-pdf"></i> Cetak PDF
    </a>
  </div>

  <!-- Form Filter Tanggal -->
  <form method="get" action="<?= site_url('admin/produksi') ?>" class="row g-3 align-items-end mb-4">
    <div class="col-md-3">
      <label for="start">Dari Tanggal:</label>
      <input type="date" id="start" name="start" class="form-control" value="<?= $this->input->get('start') ?>">
    </div>
    <div class="col-md-3">
      <label for="end">Sampai Tanggal:</label>
      <input type="date" id="end" name="end" class="form-control" value="<?= $this->input->get('end') ?>">
    </div>
    <div class="col-md-6 d-flex">
      <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-filter"></i> Filter
      </button>
      <a href="<?= site_url('admin/produksi') ?>" class="btn btn-secondary">
        <i class="fas fa-sync-alt"></i> Reset
      </a>
    </div>
  </form>

  <!-- Tabel Pesanan -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-dark text-center">
        <tr>
          <th>ID Pesanan</th>
          <th>Nama Pemesan</th>
          <th>Detail Produk</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($pesanan)): ?>
          <?php foreach ($pesanan as $p): ?>
            <tr>
              <td class="text-center"><?= $p->id_pesanan ?></td>
              <td><?= $p->nama_pemesan ?></td>
              <td>
                <?php if (!empty($p->detail_produk)): ?>
                  <ul class="mb-0 ps-3">
                    <?php foreach ($p->detail_produk as $item): ?>
                      <li><?= $item->nama_produk ?> - <?= $item->jumlah ?> pcs</li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  <em class="text-muted">Tidak ada detail produk</em>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a href="<?= site_url('admin/ubah_status_pesanan_produksi/' . $p->id_pesanan) ?>" 
                   class="btn btn-success btn-sm"
                   onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                  Tandai Selesai
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center text-muted">
              Tidak ada pesanan untuk ditampilkan.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
