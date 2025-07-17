<div class="container my-5">
  <h3 class="mb-4 text-primary">
    <i class="fas fa-clipboard-list"></i> Pesanan Saya
  </h3>

  <?php
  // Hitung jumlah pesanan yang tidak dibatalkan
  $ada_pesanan = false;
 foreach ($pesanan as $p) {
  if ($p->status_pesanan !== 'Dibatalkan' || $p->status_pelunasan == 'belum lunas') {
    $ada_pesanan = true;
    break;
    }
  }
  ?>

  <?php if ($ada_pesanan): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-warning text-center">
          <tr>
            <th>ID Pesanan</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Pembayaran</th>
            <th>Metode</th>
            <th>Total</th>
            <th>Status Pelunasan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php foreach ($pesanan as $p): ?>
            <?php if ($p->status_pesanan == 'Dibatalkan') continue; ?>
            <tr>
              <td><?= htmlspecialchars($p->id_pesanan) ?></td>
              <td><?= date('d M Y', strtotime($p->tanggal_pesanan)) ?></td>
              <td>
                <span class="badge bg-<?= $p->status_pesanan == 'Pesanan Selesai' ? 'success' : 'warning' ?>">
                  <?= $p->status_pesanan ?>
                </span>
              </td>
              <td>
                <span class="badge bg-<?= $p->status_pembayaran == 'diterima' ? 'success' : 'secondary' ?>">
                  <?= ucfirst($p->status_pembayaran) ?>
                </span>
              </td>
              <td><?= $p->metode_pembayaran ?></td>
              <td>
                Rp <?= $p->total_pembayaran !== null ? number_format($p->total_pembayaran, 0, ',', '.') : '0' ?>
              </td>
              <td>
              <?= $p->status_pelunasan ?>
              </td>
              <td>
  <a href="<?= base_url('user/detail_pesanan/' . $p->id_pesanan) ?>" class="btn btn-sm btn-outline-primary mb-1">
    <i class="fas fa-eye"></i> Detail
  </a>

  <?php if ($p->status_pesanan != 'Pesanan Selesai' && $p->status_pembayaran != 'diterima'): ?>
    <a href="<?= base_url('user/form_batal/' . $p->id_pesanan) ?>" 
       class="btn btn-sm btn-outline-danger mb-1"
       onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
      <i class="fas fa-times"></i> Batalkan
    </a>
  <?php endif; ?>

  <!-- Upload Bukti Pembayaran Awal (jika belum diterima) -->
  <?php if ($p->status_pembayaran == 'proses'): ?>
    <a href="<?= base_url('user/upload_sisa_dp/' . $p->id_pesanan) ?>" 
       class="btn btn-sm btn-success mb-1">
      <i class="fas fa-upload"></i> Upload Bukti
    </a>
  <?php endif; ?>

  <!-- Upload Sisa DP (jika metode DP dan belum lunas) -->
  <?php if ($p->metode_pembayaran == 'DP' && $p->status_pembayaran == 'diterima' && $p->status_pelunasan == 'belum lunas'): ?>
    <a href="<?= base_url('user/upload_sisa_dp/'.$p->id_pesanan) ?>" 
       class="btn btn-sm btn-warning mb-1">
      <i class="fas fa-upload"></i> Upload Sisa DP
    </a>
  <?php endif; ?>
</td>

              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">
      <i class="fas fa-info-circle"></i> Anda belum memiliki pesanan yang aktif.
    </div>
  <?php endif; ?>
</div>
