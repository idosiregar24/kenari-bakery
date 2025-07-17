<div class="container-fluid">
    <h3><i class="fas fa-edit"></i>EDIT DATA BARANG</h3>

    <form method="post" action="<?= base_url('admin/update') ?>" enctype="multipart/form-data">
        <input type="hidden" name="id_produk" value="<?= $produk->id_produk ?>">

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?= $produk->nama_produk ?>" required>
        </div>

        <div class="form-group">
            <label>Detail Produk</label>
            <input type="text" name="detail_produk" class="form-control" value="<?= $produk->detail_produk ?>" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat->kategori_id ?>" <?= ($kat->kategori_id == $produk->kategori_id) ? 'selected' : '' ?>>
                        <?= $kat->nama_kategori ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $produk->harga ?>" required>
        </div>

        <div class="form-group">
            <label>Upload Gambar Baru (jika ingin mengganti)</label>
            <input type="file" name="gambar">
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini</label><br>
            <img src="<?= base_url('uploads/' . $produk->gambar) ?>" width="120px">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?= base_url('admin/data_barang') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
