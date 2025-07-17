<div class="container mt-5">
  <h3 class="mb-4">Pesanan Berdasarkan Metode Pembayaran</h3>

  <!-- Form Filter -->
  <form method="GET" action="<?= site_url('admin/pesanan_by_metode') ?>" class="row g-3 mb-4">
    <div class="col-auto">
      <select name="metode" class="form-select" required>
        <option value="">-- Pilih Metode Pembayaran --</option>
        <option value="DP" <?= ($this->input->get('metode') == 'DP') ? 'selected' : '' ?>>DP</option>
        <option value="fullpayment" <?= ($this->input->get('metode') == 'fullpayment') ? 'selected' : '' ?>>Full Payment</option>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Tampilkan</button>
    </div>
  </form>

  <?php if ($this->input->get('metode')): ?>
    <h5>Menampilkan pesanan dengan metode: 
      <span class="badge bg-success"><?= $this->input->get('metode') ?></span>
    </h5>
  <?php endif; ?>

  <!-- Debug: Lihat hasil mentah -->
  <!--
  <pre>
  <?php foreach ($pesanan as $p): ?>
    <?= $p->id_pesanan . ' | [' . $p->metode_pembayaran . ']' . PHP_EOL ?>
  <?php endforeach; ?>
  </pre>
  -->

  <div class="table-responsive mt-3">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID Pesanan</th>
          <th>Nama Pemesan</th>
          <th>No. Telepon</th>
          <th>Tanggal</th>
          <th>Status Pesanan</th>
          <th>Status Pembayaran</th>
          <th>Status Pelunasan</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($pesanan)): ?>
          <?php foreach ($pesanan as $p): ?>
            <tr>
              <td><?= $p->id_pesanan ?></td>
              <td><?= $p->nama_pemesan ?></td>
              <td><?= $p->no_telepon ?></td>
              <td><?= date('d-m-Y', strtotime($p->tanggal_pesanan)) ?></td>
              <td>
                <span class="badge bg-info"><?= ucfirst($p->status_pesanan) ?></span>
              </td>
              <td>
                <span class="badge bg-success"><?= ucfirst($p->metode_pembayaran) ?></span>
              </td>
              <td>
                <span class="badge bg-success"><?= ucfirst($p->status_pelunasan) ?></span>
              </td>
              <td>
                <a href="<?= site_url('admin/detail_pesanan/' . $p->id_pesanan) ?>" class="btn btn-sm btn-primary mb-1">
                  <i class="fas fa-info-circle"></i> Detail
                </a>
                <a href="<?= site_url('admin/tandai_selesai/' . $p->id_pesanan) ?>" 
                   class="btn btn-sm btn-success mb-1"
                   onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                  <i class="fas fa-check-circle"></i> Tandai Selesai
                </a>
                <a href="<?= site_url('admin/kirim_notifikasi/' . $p->id_pesanan) ?>" 
                   class="btn btn-sm btn-warning mb-1"
                   onclick="return confirm('Kirim notifikasi ke pemesan?')">
                  <i class="fas fa-bell"></i> Kirim Notifikasi
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted">
              Tidak ada pesanan dengan metode pembayaran <?= htmlspecialchars($this->input->get('metode')) ?>.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
