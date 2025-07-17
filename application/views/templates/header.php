<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kenari Bakery</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Lora:wght@400;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/produk.css') ?>">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background: linear-gradient(to right, #ffe0b2, #ffcc80);">
  <div class="container">
    <a class="navbar-brand fw-bold text-brown fs-4" href="<?= base_url('user/dashboard') ?>" style="font-family: 'Pacifico', cursive;">
      <i class="fas fa-bread-slice me-1 text-warning"></i> Kenari Bakery
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item mx-1"><a class="nav-link fw-semibold text-dark" href="<?= base_url('user/dashboard') ?>">Beranda</a></li>
        <li class="nav-item mx-1"><a class="nav-link fw-semibold text-dark" href="<?= base_url('user/produk') ?>">Produk</a></li>
        <li class="nav-item mx-1"><a class="nav-link fw-semibold text-dark" href="<?= base_url('user/tentang_kami') ?>">Tentang Kami</a></li>
        <li class="nav-item mx-1"><a class="nav-link fw-semibold text-dark" href="<?= base_url('user/kontak') ?>">Kontak</a></li>

        <!-- Keranjang -->
        <li class="nav-item mx-2">
          <a href="<?= site_url('user/keranjang') ?>" class="btn btn-outline-dark position-relative rounded-pill">
            <i class="fas fa-shopping-bag"></i>
            <?php if ($this->cart->total_items() > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $this->cart->total_items() ?>
              </span>
            <?php endif; ?>
          </a>
        </li>

        <!-- User Login / Dropdown -->
        <?php if ($this->session->userdata('user_logged_in')): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold text-dark" href="#" id="userDropdown" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle me-1"></i> <?= $this->session->userdata('user_nama_lengkap') ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded">
            <li><a class="dropdown-item" href="<?= base_url('user/profil') ?>"><i class="fas fa-user me-2 text-secondary"></i> Profil</a></li>
            <li><a class="dropdown-item" href="<?= base_url('user/pesanan_saya') ?>"><i class="fas fa-clipboard-list me-2 text-secondary"></i> Pesanan Saya</a></li>
            <li><a class="dropdown-item" href="<?= base_url('user/pesanan_selesai') ?>"><i class="fas fa-check-circle me-2 text-secondary"></i> Pesanan Selesai</a></li>
            <li><a class="dropdown-item" href="<?= base_url('user/pesanan_dibatalkan') ?>"><i class="fas fa-times-circle me-2 text-secondary"></i> Pesanan Dibatalkan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
          </ul>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="btn btn-outline-dark rounded-pill" href="<?= base_url('auth/login') ?>">
            <i class="fas fa-sign-in-alt me-1"></i> Login
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>


<!-- Konten halaman lainnya -->

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 1000,
        once: true,
        mirror: false,
    });
</script>

<script>
    const counters = document.querySelectorAll('.fact-number');
    const speed = 200;
    const animateCount = (element) => {
        const target = +element.getAttribute('data-target');
        let current = 0;
        const increment = target / speed;
        const updateCount = () => {
            if (current < target) {
                current += increment;
                element.innerText = Math.ceil(current);
                requestAnimationFrame(updateCount);
            } else {
                element.innerText = target;
            }
        };
        updateCount();
    };

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCount(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, options);

    counters.forEach(counter => {
        observer.observe(counter);
    });
</script>
</body>
</html>

