<div class="container mt-5">
  <h3 class="mb-4 text-primary">
    🔍 Menampilkan hasil pencarian untuk: <em><?= htmlspecialchars($keyword) ?></em>
  </h3>

  <!-- ====================== Hasil Pesanan ====================== -->
  <?php if ($hasil_pesanan): ?>
    <div class="card border-info mb-4 shadow-sm">
      <div class="card-header bg-info text-white">
        <i class="fas fa-box-open"></i> Data Pesanan
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-striped mb-0">
            <thead class="thead-light text-center">
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Metode</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($hasil_pesanan as $p): ?>
                <tr class="text-center">
                  <td><?= $p->id_pesanan ?></td>
                  <td><?= $p->nama_pemesan ?></td>
                  <td><?= $p->no_telepon ?></td>
                  <td><?= date('d M Y', strtotime($p->tanggal_pesanan)) ?></td>
                  <td>
                    <span class="badge badge-pill badge-<?= $p->status_pesanan == 'Pesanan Selesai' ? 'success' : 'warning' ?>">
                      <?= $p->status_pesanan ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge badge-<?= $p->status_pembayaran == 'diterima' ? 'success' : 'secondary' ?>">
                      <?= ucfirst($p->status_pembayaran) ?>
                    </span>
                  </td>
                  <td><?= $p->metode_pembayaran ?></td>
                  <td>
                    <a href="<?= site_url('admin/detail_pesanan/' . $p->id_pesanan) ?>"
   class="btn btn-sm btn-outline-primary">
  <i class="fas fa-eye"></i> Detail
</a>


                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- ====================== Produk Dipesan ====================== -->
  <?php if ($hasil_produk): ?>
    <div class="card border-warning mb-4 shadow-sm">
      <div class="card-header bg-warning text-dark">
        <i class="fas fa-cookie-bite"></i> Produk yang Dipesan
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-striped mb-0">
            <thead class="thead-light text-center">
              <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($hasil_produk as $prod): ?>
                <tr class="text-center">
                  <td><?= $prod->nama_produk ?></td>
                  <td><?= $prod->jumlah ?></td>
                  <td>Rp <?= number_format($prod->harga, 0, ',', '.') ?></td>
                  <td>Rp <?= number_format($prod->subtotal, 0, ',', '.') ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- ====================== Barang Toko ====================== -->
  <?php if ($hasil_barang): ?>
    <div class="card border-success mb-4 shadow-sm">
      <div class="card-header bg-success text-white">
        <i class="fas fa-store-alt"></i> Barang Toko
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead class="thead-light text-center">
              <tr>
                <th>Barang</th>
                <th>Deskripsi</th>
                <th>Stok</th>
                <th>Harga</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($hasil_barang as $b): ?>
                <tr class="text-center">
                  <td><?= $b->nama_barang ?></td>
                  <td><?= $b->keterangan ?></td>
                  <td><?= $b->stok ?></td>
                  <td>Rp <?= number_format($b->harga, 0, ',', '.') ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- ====================== Tidak Ada Hasil ====================== -->
  <?php if (empty($hasil_pesanan) && empty($hasil_produk) && empty($hasil_barang)): ?>
    <div class="alert alert-danger text-center mt-5 p-4">
      <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
      Tidak ada hasil ditemukan untuk kata kunci:
      <strong><?= htmlspecialchars($keyword) ?></strong>
    </div>
  <?php endif; ?>
</div>
