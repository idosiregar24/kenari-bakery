<div class="container py-5">
  <!-- HEADER -->
  <div class="text-center mb-5">
    <h2 class="fw-bold text-primary">Form Pemesanan Kenari Bakery</h2>
    <p class="text-muted">Silakan lengkapi data berikut untuk melanjutkan pemesanan Anda.</p>
  </div>

  <?php if ($this->session->flashdata('error')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('error'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

  <!-- FORM -->
  <form action="<?= site_url('user/proses_pesanan') ?>" method="post" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
    
    <!-- TANGGAL -->
    <div class="row mb-4">
      <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Pemesanan</label>
        <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Pengambilan / Pengantaran</label>
        <input type="date" class="form-control" name="tanggal_pengambilan" id="tanggal_pengambilan" required onchange="cekTanggalPengambilan()">
        <small id="peringatan_tanggal" class="text-danger mt-1 d-block"></small>

      </div>
    </div>

    <!-- JENIS PEMESANAN -->
    <div class="mb-4">
      <label class="form-label fw-semibold">Jenis Pemesanan</label>
      <div class="form-check form-check-inline ms-2">
        <input class="form-check-input" type="radio" name="jenis_pemesanan" value="Ambil di Toko" required>
        <label class="form-check-label">Ambil di Toko</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="jenis_pemesanan" value="Diantar" required>
        <label class="form-check-label">Diantar ke Alamat</label>
      </div>
    </div>

    <!-- PRODUK YANG DIPESAN -->
    <div class="card border-0 shadow mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">🧾 Ringkasan Pesanan</h5>
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
              <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $total_produk = 0;
              foreach ($this->cart->contents() as $item): 
                $total_produk += $item['qty'];
              ?>
              <tr>
                <td><?= $item['name'] ?></td>
                <td class="text-center"><?= $item['qty'] ?></td>
                <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot class="fw-semibold">
              <tr class="table-secondary">
                <td colspan="3" class="text-end">Total Produk</td>
                <td><?= $total_produk ?> item</td>
              </tr>
              <tr class="table-warning">
                <td colspan="3" class="text-end">Total Pembayaran</td>
                <td>Rp <?= number_format($this->cart->total(), 0, ',', '.') ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <!-- METODE PEMBAYARAN -->
    <div class="mb-4">
      <label class="form-label fw-semibold">Metode Pembayaran</label>
      <select class="form-select" name="metode_pembayaran" id="metode_pembayaran" required onchange="tampilkanInfoPembayaran()">
        <option selected disabled>- Pilih Metode Pembayaran -</option>
        <option value="fullpayment">Full Payment (Lunas)</option>
        <option value="DP">DP (Uang Muka)</option>

      </select>
    </div>

    <!-- INFO PEMBAYARAN -->
<div id="info_pembayaran" style="display:none;">
  <div class="alert alert-info">
    <p class="mb-2">Silakan transfer ke salah satu rekening berikut:</p>
    <ul>
      <li><strong>BCA</strong> - 1234567890 a.n. Kenari Cake</li>
      <li><strong>Mandiri</strong> - 9876543210 a.n. Kenari Cake</li>
    </ul>

    <!-- TAMPIL DP -->
    <div id="info_dp" class="alert alert-warning mt-3" style="display: none;">
      <strong>Total DP yang harus dibayar:</strong>
      <span id="nilai_dp" class="ms-2 text-dark fw-bold">Rp 0</span>
    </div>

    <!-- Upload Bukti -->
    <div class="mb-3 mt-3">
      <label class="form-label">Upload Bukti Pembayaran</label>
      <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*">
    </div>
  </div>
</div>


    <!-- CATATAN -->
    <div class="mb-4">
      <label class="form-label fw-semibold">Catatan Tambahan</label>
      <textarea class="form-control" name="catatan" rows="3" placeholder="Contoh: Tanpa kacang, diantar jam 9 pagi"></textarea>
    </div>

    <!-- SUBMIT -->
    <button type="submit" class="btn btn-success btn-lg w-100 shadow">🛒 Kirim Pemesanan</button>
  </form>
</div>

<script>
function tampilkanInfoPembayaran() {
  const metode = document.getElementById('metode_pembayaran').value;
  const infoPembayaran = document.getElementById('info_pembayaran');
  const infoDP = document.getElementById('info_dp');
  const nilaiDP = document.getElementById('nilai_dp');

  const total = <?= $this->cart->total(); ?>;
  const dp = total * 0.5;

  // Tampilkan box transfer jika fullpayment atau DP
  if (metode === 'fullpayment' || metode === 'DP') {
    infoPembayaran.style.display = 'block';
  } else {
    infoPembayaran.style.display = 'none';
  }

  // Jika metode DP, tampilkan nominal 50%
  if (metode === 'DP') {
    infoDP.style.display = 'block';
    nilaiDP.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(dp);
  } else {
    infoDP.style.display = 'none';
  }
}
function cekTanggalPengambilan() {
  const inputTanggal = document.getElementById('tanggal_pengambilan');
  const peringatan = document.getElementById('peringatan_tanggal');
  const today = new Date();
  const jamSekarang = today.getHours();

  const tanggalDiisi = new Date(inputTanggal.value);
  
  // Buat tanggal hari ini tanpa jam
  const todayOnly = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  const tanggalPengambilan = new Date(tanggalDiisi.getFullYear(), tanggalDiisi.getMonth(), tanggalDiisi.getDate());

  if (tanggalPengambilan <= todayOnly) {
    peringatan.innerText = "❗Penting! Pesanan tidak bisa diambil/diantar di hari yang sama.";
  } else if (tanggalPengambilan - todayOnly === 86400000 && jamSekarang >= 16) {
    // 86400000 = 1 hari dalam milidetik
    peringatan.innerText = "❗Penting! Anda tidak bisa order H-1 setelah pukul 16.00.";
  } else {
    peringatan.innerText = ""; // Kosongkan jika valid
  }
}
</script>

