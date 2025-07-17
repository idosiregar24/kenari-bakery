<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid mt-4">
  <button class="btn btn-warning mb-3" data-toggle="modal" data-target="#tambah_produk">
    <i class="fas fa-plus"></i> Tambah Produk
  </button>

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>NO</th>
          <th>NAMA PRODUK</th>
          <th>DETAIL PRODUK</th>
          <th>KATEGORI</th>
          <th>HARGA</th>
          <th>GAMBAR</th>
          <th colspan="3">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($produk as $prd): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $prd->nama_produk ?></td>
          <td><?= $prd->detail_produk ?></td>
          <td><?= $prd->nama_kategori ?></td>
          <td>Rp <?= number_format($prd->harga, 0, ',', '.') ?></td>
          <td><?= $prd->gambar ?></td>
          <td><div class="btn btn-warning btn-sm"><i class="fas fa-search-plus"></i></div></td>
          <td><?= anchor('admin/edit/' . $prd->id_produk, '<div class="btn btn-success btn-sm"><i class="fas fa-edit"></i></div>') ?></td>
          <td><?= anchor('admin/hapus/' . $prd->id_produk, '<div class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></div>') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambah_produk" tabindex="-1" role="dialog" aria-labelledby="tambahProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('admin/tambah_aksi') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahProdukLabel">Form Tambah Produk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Detail Produk</label>
            <input type="text" name="detail_produk" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control" required>
              <option value="">-- Pilih Kategori --</option>
              <?php foreach ($kategori as $kat): ?>
              <option value="<?= $kat->kategori_id ?>"><?= $kat->nama_kategori ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Upload Gambar Produk</label>
            <input type="file" name="gambar" class="form-control-file" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery (wajib untuk Bootstrap 4) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Popper.js (dibutuhkan oleh Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                