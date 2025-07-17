<div class="container py-5">

  <!-- Judul -->
  <div class="text-center mb-5">
    <h2 class="fw-bold text-primary">🧾 Detail Pesanan</h2>
    <p class="text-muted">Lihat informasi lengkap pesanan dan produk yang dipesan</p>
  </div>

  <!-- Informasi Pemesan -->
  <div class="card shadow-sm mb-5">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Informasi Pemesan</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-6">
          <table class="table table-borderless">
            <tr>
              <th class="w-50 text-muted">Nama</th>
              <td><?= $pesanan->nama_pemesan ?></td>
            </tr>
            <tr>
              <th class="text-muted">No. Telepon</th>
              <td><?= $pesanan->no_telepon ?></td>
            </tr>
            <tr>
  <th class="text-muted align-top">Alamat Lengkap</th>
  <td>
    <?= $pesanan->alamat_lengkap ?>, RT/RW <?= $pesanan->rt_rw ?> <br>
    Desa <?= $pesanan->desa ?>, Kecamatan <?= $pesanan->kecamatan ?> <br>
    <?= $pesanan->kabupaten ?>, <?= $pesanan->provinsi ?>
  </td>
</tr>

            <tr>
              <th class="text-muted">Tanggal Pesanan</th>
              <td><?= $pesanan->tanggal_pesanan ?></td>
            </tr>
            <tr>
              <th class="text-muted">Tanggal Pengambilan</th>
              <td><?= $pesanan->tanggal_pengambilan ?></td>
            </tr>
          </table>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-6">
          <table class="table table-borderless">
            <tr>
              <th class="w-50 text-muted">Jenis Pemesanan</th>
              <td><?= $pesanan->jenis_pemesanan ?></td>
            </tr>
            <tr>
              <th class="text-muted">Metode Pembayaran</th>
              <td><?= $pesanan->metode_pembayaran ?></td>
            </tr>
            <tr>
              <th class="text-muted">Catatan</th>
              <td><?= $pesanan->catatan ?: '<span class="text-muted">Tidak ada</span>' ?></td>
            </tr>
            <tr>
              <th class="text-muted">Status Pesanan</th>
              <td>
                <span class="badge bg-<?= $pesanan->status_pesanan === 'selesai' ? 'success' : 'warning' ?>">
                  <?= ucfirst($pesanan->status_pesanan) ?>
                </span>
              </td>
            </tr>
            <tr>
              <th class="text-muted">Status Pembayaran</th>
              <td>
                <?php 
                  $status = $pesanan->status_pembayaran ?? 'belum diproses';
                  $badge = match ($status) {
                    'diterima' => 'success',
                    'tidak diterima' => 'danger',
                    default => 'secondary'
                  };
                ?>
                <span class="badge bg-<?= $badge ?>"><?= ucfirst($status) ?></span>
              </td>
            </tr>
            <tr>
              <th class="text-muted">Status Pelunasan</th>
              <td>
                <?php 
                  $status = $pesanan->status_pelunasan; 
                ?>
                <span class="badge bg-<?= $badge ?>"><?= ucfirst($status) ?></span>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Bukti Pembayaran -->
      <div class="mt-4">
        <h6 class="fw-semibold">Bukti Pembayaran:</h6>
        <?php if ($pesanan->bukti_pembayaran): ?>
          <a href="<?= base_url('uploads/' . $pesanan->bukti_pembayaran) ?>" target="_blank">
            <img src="<?= base_url('uploads/' . $pesanan->bukti_pembayaran) ?>" 
                 class="img-fluid rounded shadow-sm mt-2" 
                 style="max-width: 250px;">
          </a>
        <?php else: ?>
          <p class="text-muted mt-2">Belum upload</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Produk yang Dipesan -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0">Produk yang Dipesan</h5>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped table-bordered table-hover mb-0 text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $total_pembayaran = 0;
            foreach ($detail as $d): 
              $total_pembayaran += $d->subtotal;
          ?>
          <tr>
            <td><?= $d->nama_produk ?></td>
            <td><?= $d->jumlah ?></td>
            <td>Rp <?= number_format($d->harga, 0, ',', '.') ?></td>
            <td>Rp <?= number_format($d->subtotal, 0, ',', '.') ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr class="table-warning fw-semibold">
            <td colspan="3" class="text-end">Total Pembayaran</td>
            <td>Rp <?= number_format($total_pembayaran, 0, ',', '.') ?></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

<!-- Tombol Aksi Admin -->
<div class="d-flex justify-content-end gap-2 mb-4 flex-wrap">


<!-- Bukti Sisa Pembayaran -->
<?php if ($pesanan->metode_pembayaran === 'DP'): ?>
  <div class="mt-4">
    <h6 class="fw-semibold">Bukti Sisa Pembayaran:</h6>
    <?php if ($pesanan->bukti_sisa_dp): ?>
      <a href="<?= base_url('uploads/buktiPelunasan/' . $pesanan->bukti_sisa_dp) ?>" target="_blank">
      <img src="<?= base_url('uploads/buktiPelunasan/' . $pesanan->bukti_sisa_dp) ?>"
             class="img-fluid rounded shadow-sm mt-2" 
             style="max-width: 250px;">
      </a>

      <!-- Tombol Konfirmasi Sisa DP -->
      <?php if ($pesanan->status_pembayaran !== 'diterima'): ?>
        <div class="mt-3 d-flex gap-2">
          <form action="<?= site_url('admin/konfirmasi_sisa_dp') ?>" method="post">
            <input type="hidden" name="id_pesanan" value="<?= $pesanan->id_pesanan ?>">
            <button type="submit" name="aksi" value="terima" class="btn btn-success btn-sm">
              <i class="fas fa-check-circle"></i> Konfirmasi Sisa DP
            </button>
          </form>
          <br>
          <form action="<?= site_url('admin/konfirmasi_sisa_dp') ?>" method="post">
            <input type="hidden" name="id_pesanan" value="<?= $pesanan->id_pesanan ?>">
            <button type="submit" name="aksi" value="tolak" class="btn btn-danger btn-sm">
              <i class="fas fa-times-circle"></i> Tolak Sisa DP
            </button>
          </form>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <p class="text-muted mt-2">Belum upload sisa DP</p>
    <?php endif; ?>
  </div>
<?php endif; ?>




  <!-- Tombol kembali -->
  <div class="text-end">
    <br>
    <a href="<?= site_url('admin/tandai_selesai/' . $pesanan->id_pesanan) ?>" 
                   class="btn btn-sm btn-success mb-1"
                   onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                  <i class="fas fa-check-circle"></i> Tandai Selesai
    </a>
    <a href="<?= site_url('admin/data_pesanan') ?>" class="btn btn-outline-secondary px-4 py-2">
      <i class="fas fa-arrow-left"></i> Kembali ke Data Pesanan
    </a>
  </div>

</div>
