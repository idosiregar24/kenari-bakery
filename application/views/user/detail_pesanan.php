<div class="container py-5">
  <h3 class="mb-4">🧾 Detail Pesanan</h3>

  <div class="row mb-3">
    <div class="col-md-6">
      <p><strong>Nama :</strong> <?= $pesanan->nama_pemesan ?></p>
      <p><strong>Alamat :</strong> <?= $pesanan->alamat?></p>
<td>
    
  </td>

      <p><strong>Tanggal Pesanan :</strong> <?= $pesanan->tanggal_pesanan ?></p>
    </div>
    <div class="col-md-6">
      <p><strong>Metode Pembayaran :</strong> <?= $pesanan->metode_pembayaran ?></p>
      <p><strong>Status Pembayaran :</strong> <?= $pesanan->status_pembayaran ?></p>
      <p><strong>Status Pesanan :</strong> <?= $pesanan->status_pesanan ?></p>
      <p><strong>Status Pelunasan :</strong> <?= $pesanan->status_pelunasan ?></p>
      <p><strong>Jenis Pemesanan  :</strong> <?= $pesanan->jenis_pemesanan?></p>
    </div>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $total = 0;
        foreach ($detail as $d):
        $total += $d->subtotal;
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
      <tr>
        <th colspan="3" class="text-end">Total</th>
        <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
      </tr>
    </tfoot>
  </table>

  <!-- Tambahkan Notifikasi Upload Sisa DP -->
  <?php if ($pesanan->metode_pembayaran === 'DP'): ?>
  <div class="alert alert-warning mt-4">
    <strong>⚠️ Perhatian:</strong> Anda telah memilih metode pembayaran DP.
    Silakan unggah bukti sisa pembayaran agar pesanan diproses lebih lanjut.
  </div>

  <?php if (!$pesanan->bukti_sisa_dp): ?>
    <a href="<?= site_url('user/upload_sisa_dp/' . $pesanan->id_pesanan) ?>" class="btn btn-primary mt-2">
      <i class="fas fa-upload"></i> Upload Bukti Pelunasan Sisa DP
    </a>
  <?php else: ?>
    <p class="mt-2">✅ Bukti pelunasan sudah diunggah. Menunggu konfirmasi admin.</p>
  <?php endif; ?>
<?php endif; ?>


</div>
