<div class="container mt-5">
  <h3 class="mb-4">📦 Data Pesanan</h3>

  <!-- Notifikasi flash -->
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
  <?php endif; ?>

  <!-- Notifikasi jika ada pesanan baru -->
  <?php 
    $pesanan_baru = array_filter($pesanan, function($p) {
      return $p->status_pesanan != 'Pesanan Selesai' 
             && $p->status_pembayaran != 'diterima'
             && $p->status_pembayaran != 'ditolak';
    });
  ?>
  <?php if (count($pesanan_baru) > 0): ?>
    <div class="alert alert-info">
      <strong>🔔 Ada <?= count($pesanan_baru) ?> pesanan baru</strong> yang menunggu konfirmasi.
    </div>
  <?php endif; ?>

  <!-- Tombol filter -->
  <a href="?filter=baru" class="btn btn-primary mb-3">Tampilkan Pesanan Baru Masuk</a>
  <a href="<?= base_url('admin/data_pesanan') ?>" class="btn btn-secondary mb-3">Tampilkan Semua</a>

  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Nama Pemesan</th>
        <th>No. Telepon</th>
        <th>Tanggal</th>
        <th>Pembayaran</th>
        <th>Status Pesanan</th>
        <th>Status Pembayaran</th>
        <th>Bukti Pembayaran</th>
        <th>Status Pelunasan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pesanan as $p): ?>

        <?php
          // Sembunyikan pesanan yang sudah selesai
          if ($p->status_pesanan == 'diterima') continue;

          // Sembunyikan pesanan yang ditolak
          if ($p->status_pembayaran == 'ditolak') continue;

          // Jika ada filter baru, hanya tampilkan pesanan yang belum diterima
          if (isset($_GET['filter']) && $_GET['filter'] == 'baru') {
            if ($p->status_pembayaran == 'diterima') continue;
          }
        ?>

        <tr>
          <td><?= $p->id_pesanan ?></td>
          <td><?= $p->nama_pemesan ?></td>
          <td><?= $p->no_telepon ?></td>
          <td><?= $p->tanggal_pesanan ?></td>
          <td><?= $p->metode_pembayaran ?></td>
          <td><?= $p->status_pesanan ?></td>
          <td>
            <span class="badge bg-<?= $p->status_pembayaran == 'diterima' ? 'success' : 'warning' ?>">
              <?= $p->status_pembayaran ?>
            </span>
          </td>

          <td>
            <?php if (!empty($p->bukti_pembayaran)): ?>
              <a href="<?= base_url('uploads/' . $p->bukti_pembayaran) ?>" target="_blank">
                <img src="<?= base_url('uploads/' . $p->bukti_pembayaran) ?>" width="80" class="img-thumbnail">
              </a>
            <?php else: ?>
              <span class="text-muted">Belum Upload</span>
            <?php endif; ?>
          </td>
          <td><?= $p->status_pelunasan ?></td>

          <td>
            <a href="<?= site_url('admin/detail_pesanan/' . $p->id_pesanan) ?>" class="btn btn-info btn-sm mb-1">
              Detail
            </a>

            <?php if ($p->status_pembayaran != 'diterima'): ?>
              <a href="<?= site_url('admin/konfirmasi_pembayaran/' . $p->id_pesanan) ?>"
                 class="btn btn-success btn-sm mb-1"
                 onclick="return confirm('Konfirmasi pembayaran sudah diterima?')">
                Konfirmasi
              </a>
            <?php endif; ?>

            <?php if ($p->status_pembayaran != 'tidak diterima'): ?>
              <a href="<?= site_url('admin/tolak_pembayaran/' . $p->id_pesanan) ?>"
                 class="btn btn-danger btn-sm mb-1"
                 onclick="return confirm('Tolak pembayaran pesanan ini?')">
                Tolak
              </a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
