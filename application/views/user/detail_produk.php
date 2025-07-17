<div class="container py-5">
  <div class="row">
    <div class="col-md-6">
      <img src="<?= base_url('uploads/' . $produk->gambar) ?>" class="img-fluid rounded shadow-sm" alt="<?= $produk->nama_produk ?>">
    </div>
    <div class="col-md-6">
      <h2><?= $produk->nama_produk ?></h2>
      <h4 class="text-danger mb-3">Rp <?= number_format($produk->harga, 0, ',', '.') ?></h4>
      <p><strong>Deskripsi:</strong><br><?= $produk->detail_produk ?? 'Belum ada deskripsi.' ?></p>

      <form class="form-tambah-keranjang d-flex gap-3 mt-4" action="<?= site_url('user/tambah_ke_keranjang') ?>" method="post">
        <input type="hidden" name="id" value="<?= $produk->id_produk ?>">
        <input type="hidden" name="nama" value="<?= $produk->nama_produk ?>">
        <input type="hidden" name="harga" value="<?= $produk->harga ?>">
        <input type="hidden" name="gambar" value="<?= $produk->gambar ?>">

        <input type="number" name="qty" class="form-control text-center" value="1" min="1" style="width: 80px;">
        <button type="submit" class="btn btn-warning"><i class="fas fa-cart-plus me-1"></i> Tambahkan ke Keranjang</button>
      </form>
    </div>
  </div>
</div>
