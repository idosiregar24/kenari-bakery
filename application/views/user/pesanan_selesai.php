<div class="container mt-5">
  <h3 class="mb-4 text-success">📦 Daftar Pesanan Selesai</h3>

  <?php if (empty($pesanan)): ?>
    <div class="alert alert-info">Belum ada pesanan yang selesai.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-success text-center">
          <tr>
            <th>Id Pesanan</th>
            <th>Tanggal</th>
            <th>Metode Pembayaran</th>
            <th>Status</th>
            <th>Jenis Pemesanan</th> 
            <th>Total</th>
            <th>Aksi</th>
            <th>Berikan FeedBack</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($pesanan as $p): ?>
            <tr class="text-center">
              <td><?=  $p->id_pesanan ?></td>
              <td><?= date('d M Y', strtotime($p->tanggal_pesanan)) ?></td>
              <td><?= $p->metode_pembayaran ?></td>
              <td><span class="badge bg-success"><?= $p->status_pesanan ?></span></td>
              <td><span class="badge bg-success"><?= $p->jenis_pemesanan ?></span></td>
              <td>
                <?php 
                  $CI =& get_instance();
                  $CI->db->select_sum('subtotal');
                  $CI->db->where('id_pesanan', $p->id_pesanan);
                  $total = $CI->db->get('detail_pesanan')->row()->subtotal;
                  echo 'Rp ' . number_format($total, 0, ',', '.');
                ?>
              </td>
              <td>
                <a href="<?= site_url('user/detail_pesanan/' . $p->id_pesanan) ?>" class="btn btn-sm btn-outline-primary">
                  <i class="fas fa-eye"></i> Detail
                </a>
              </td>
              <td>
                <a href="<?= site_url('user/feedback/' . $p->id_pesanan) ?>" class="btn btn-sm btn-outline-success">
                <i class="fas fa-star"></i> Feedback
                </a>
                </td>

            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
