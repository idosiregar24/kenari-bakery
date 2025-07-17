<div class="container mt-5">
  <h2 class="mb-4 text-primary">🧾 Invoice Pesanan Selesai</h2>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success shadow-sm"><?= $this->session->flashdata('success'); ?></div>
  <?php endif; ?>

<!-- Filter Tanggal -->
<form method="get" action="<?= site_url('admin/invoices') ?>" class="mb-4">
  <div class="row g-2">
    <div class="col-md-3">
      <label>Dari Tanggal:</label>
      <input type="date" name="start" class="form-control" value="<?= $this->input->get('start') ?>">
    </div>
    <div class="col-md-3">
      <label>Sampai Tanggal:</label>
      <input type="date" name="end" class="form-control" value="<?= $this->input->get('end') ?>">
    </div>
    <div class="col-md-6 d-flex align-items-end">
      <button type="submit" class="btn btn-primary me-2"><i class="fas fa-filter"></i> Filter</button>
      <a href="<?= site_url('admin/cetak_laporan?start=' . $this->input->get('start') . '&end=' . $this->input->get('end')) ?>" 
         target="_blank" class="btn btn-success">
        <i class="fas fa-print"></i> Cetak Laporan
      </a>
    </div>
  </div>
</form>


  <div class="table-responsive">
    <table class="table table-bordered table-hover shadow-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>ID Pesanan</th>
          <th>Nama Pemesan</th>
          <th>No. Telepon</th>
          <th>Tanggal</th>
          <th>Pembayaran</th>
          <th>Status</th>
          <th>Status Pesanan</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach ($invoices as $inv): ?>
        <tr>
          <td class="text-center"><?= $inv->id_pesanan ?></td>
          <td><?= $inv->nama_pemesan ?></td>
          <td><?= $inv->no_telepon ?></td>
          <td><?= date('d M Y', strtotime($inv->tanggal_pesanan)) ?></td>
          <td><span class="badge badge-info"><?= $inv->metode_pembayaran ?></span></td>
          <td><span class="badge badge-success"><?= $inv->status_pembayaran ?></span></td>
          <td><span class="badge badge-success"><?= $inv->status_pesanan ?></span></td>
          <td>
            <?php 
              $this->db->select_sum('subtotal');
              $this->db->where('id_pesanan', $inv->id_pesanan);
              $total = $this->db->get('detail_pesanan')->row()->subtotal;
              echo '<strong>Rp ' . number_format($total, 0, ',', '.') . '</strong>';
            ?>
          </td>
          <td>
            <a href="<?= site_url('admin/detail_pesanan/' . $inv->id_pesanan) ?>" class="btn btn-sm btn-outline-primary">
              <i class="fas fa-eye"></i> Detail
            </a>
            <a href="<?= site_url('admin/kirim_notifikasi/' . $inv->id_pesanan) ?>" 
                   class="btn btn-sm btn-warning mb-1"
                   onclick="return confirm('Kirim notifikasi ke pemesan?')">
                  <i class="fas fa-bell"></i> Kirim Notifikasi
            </a>
          </td>
        </tr>

        <!-- Detail Produk Pesanan -->
        <tr>
          <td colspan="9" class="bg-light px-4 pt-3 pb-2">
            <div class="bg-light p-3">
              <h6 class="text-secondary mb-3">📦 Rincian Produk</h6>
              <table class="table table-sm table-bordered mb-0">
                <thead class="table-secondary text-center">
                  <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $this->db->where('id_pesanan', $inv->id_pesanan);
                    $produk = $this->db->get('detail_pesanan')->result();
                    $no = 1;
                    foreach ($produk as $item):
                  ?>
                  <tr class="text-center">
                    <td><?= $no++ ?></td>
                    <td class="text-left"><?= $item->nama_produk ?></td>
                    <td><?= $item->jumlah ?></td>
                    <td>Rp <?= number_format($item->harga, 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($item->subtotal, 0, ',', '.') ?></td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
