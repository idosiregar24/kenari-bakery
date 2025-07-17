<div class="container my-5">
  <h3 class="mb-4 text-danger"><i class="fas fa-ban"></i> Pesanan Dibatalkan</h3>

  <?php if (!empty($pesanan)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark text-center">
          <tr>
            <th>ID Pesanan</th>
            <th>Tanggal Pesan</th>
            <th>Tanggal Batal</th>
            <th>Total</th>
            <th>Alasan</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php foreach ($pesanan as $p): ?>
            <tr>
              <td><?= $p->id_pesanan ?></td>
              <td><?= date('d-m-Y', strtotime($p->tanggal_pesanan)) ?></td>
              <td><?= date('d-m-Y H:i', strtotime($p->tanggal_batal)) ?></td>
              <td>Rp <?= number_format($p->total_pembayaran, 0, ',', '.') ?></td>
              <td class="text-start"><?= $p->alasan ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">
      <i class="fas fa-info-circle"></i> Anda belum pernah membatalkan pesanan.
    </div>
  <?php endif; ?>
</div>
