<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <h2 class="mb-4">Keranjang Belanja Anda</h2>

  <?php if ($this->cart->total_items() > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Sub-Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($this->cart->contents() as $item): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $item['name'] ?></td>

              <!-- FORM UPDATE QTY PER ITEM -->
              <td>
                <form action="<?= site_url('user/update_item') ?>" method="post" class="d-flex">
                  <input type="hidden" name="rowid" value="<?= $item['rowid'] ?>">
                  <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1" class="form-control form-control-sm me-2" style="width: 80px;">
                  <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </form>
              </td>

              <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
              <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
              <td>
               <a href="<?= site_url('user/hapus_item/' . $item['rowid']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus item ini?')">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
            
    <div class="d-flex justify-content-between align-items-center mt-4">
      <h5>Total: <strong>Rp <?= number_format($this->cart->total(), 0, ',', '.') ?></strong></h5>
      <div>
        <a href="<?= site_url('user/hapus_keranjang') ?>" class="btn btn-outline-danger" onclick="return confirm('Kosongkan keranjang?')">Kosongkan</a>
        <a href="<?= site_url('user/form_pesanan') ?>" class="btn btn-success">Lanjut Pesanan</a>
      </div>
    </div>

  <?php else: ?>
    <div class="alert alert-info">Keranjang belanja kosong. Silakan pilih produk terlebih dahulu.</div>
  <?php endif; ?>
</div>
</body>
</html>
