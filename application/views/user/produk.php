<style>
  .product-card {
    transition: transform 0.2s ease-in-out;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #eee;
    background: #fff;
  }

  .product-card:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .product-image {
    height: 220px;
    width: 100%;
    object-fit: cover;
    background-color:rgb(255, 255, 255);
  }

  .product-title {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    height: 48px;
    overflow: hidden;
  }

  .product-price {
    font-size: 1.1rem;
    font-weight: bold;
    color: #d32f2f;
  }

  .btn-buy {
    background-color:rgb(255, 111, 0);
    color: white;
  }

  .btn-buy:hover {
    background-color: #e64a19;
  }

  .badge-promo {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #f44336;
    color: white;
    padding: 4px 8px;
    font-size: 0.75rem;
    border-radius: 4px;
    z-index: 2;
  }
</style>
<div class="container-fluid py-5">
  <!-- Judul Katalog -->
  <div class="text-center mb-4">
    <h1 class="hero-heading">Katalog Produk Roti Premium</h1>
    <p class="hero-subheading">
      Temukan berbagai pilihan roti berkualitas tinggi, dibuat dengan resep rahasia dan bahan terbaik.
    </p>
  </div>

  <!-- Form Pencarian -->
  <div class="row justify-content-center mb-4">
    <div class="col-md-6">
      <form action="<?= site_url('user/produk') ?>" method="get" class="input-group">
        <input type="text" class="form-control" name="search" id="search" placeholder="Cari produk..." value="<?= $this->input->get('search') ?>">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
  </div>

  <!-- Daftar Produk -->
   <!-- Produk Grid -->
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php if (!empty($produk)): ?>
        <?php foreach ($produk as $prd): ?>
          <div class="col">
            <div class="product-card position-relative">

              <!-- Badge Promo (opsional) -->
              <!-- <div class="badge-promo">Diskon 10%</div> -->

              <!-- Gambar klik ke detail -->
<a href="<?= site_url('user/detail_produk/' . $prd->id_produk) ?>">
  <img src="<?= base_url('uploads/' . $prd->gambar) ?>" alt="<?= $prd->nama_produk ?>" class="product-image">
</a>

<div class="p-3">
  <!-- Judul klik ke detail -->
  <a href="<?= site_url('user/detail_produk/' . $prd->id_produk) ?>" class="text-decoration-none text-dark">
    <div class="product-title"><?= $prd->nama_produk ?></div>
  </a>

                <div class="product-price mt-1 mb-3">Rp <?= number_format($prd->harga, 0, ',', '.') ?></div>

                <form class="form-tambah-keranjang d-flex gap-2 align-items-center" data-action="<?= site_url('user/tambah_ke_keranjang') ?>">
                  <input type="hidden" name="id" value="<?= $prd->id_produk ?>">
                  <input type="hidden" name="nama" value="<?= $prd->nama_produk ?>">
                  <input type="hidden" name="harga" value="<?= $prd->harga ?>">
                  <input type="hidden" name="gambar" value="<?= $prd->gambar ?>">

                  <input type="number" name="qty" class="form-control form-control-sm text-center" value="1" min="1" max="99" style="width: 60px;">
                  <button type="submit" class="btn btn-sm btn-buy w-100"><i class="fas fa-cart-plus me-1"></i> Tambahkan Ke Keranjang   </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-warning text-center">
            <i class="fas fa-info-circle me-2"></i> Produk belum tersedia.
          </div>
        </div>
      <?php endif; ?>
    </div>

  <!-- Navigasi Pagination -->
  <div class="d-flex justify-content-center mt-5">
    <?= $pagination_links; ?>
  </div>
</div>

<!-- Script AJAX Tambah ke Keranjang -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  $('.form-tambah-keranjang').on('submit', function (e) {
    e.preventDefault();
    let form = $(this);
    let formData = form.serialize();
    let actionUrl = form.data('action');

    $.post(actionUrl, formData, function (response) {
      alert("Produk berhasil ditambahkan ke keranjang!");
    }).fail(function () {
      alert("Gagal menambahkan ke keranjang.");
    });
  });
});
</script>

<!-- Script Filter Range Harga (Jika digunakan) -->
<script>
function updateRangeLabel() {
  const range = document.getElementById('rangeHarga');
  const label = document.getElementById('rangeValue');
  const val = parseInt(range.value);
  label.textContent = 'Rp ' + val.toLocaleString('id-ID');
}

function resetFilter() {
  document.getElementById('rangeHarga').value = 210000;
  updateRangeLabel();
}

document.addEventListener('DOMContentLoaded', updateRangeLabel);
</script>
