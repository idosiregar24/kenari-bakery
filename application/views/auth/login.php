<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Kenari Cake & Bakery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #fff3e0, #ffe0b2);
      font-family: 'Segoe UI', sans-serif;
      position: relative;
    }

    /* Emoji roti animasi */
    .bread {
      position: absolute;
      font-size: 24px;
      animation: fall linear infinite;
      opacity: 0.8;
      z-index: 0;
    }

    @keyframes fall {
      0% {
        transform: translateY(-60px) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }

    .login-wrapper {
      z-index: 1;
      max-width: 960px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.2);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
      transition: all 0.3s ease;
    }

    .login-img {
      flex: 1 1 50%;
      background: url('https://cdn-icons-png.flaticon.com/512/6615/6615151.png') no-repeat center;
      background-size: contain;
      background-color: #fff8ee;
      min-height: 420px;
    }

    .login-form {
      flex: 1 1 50%;
      padding: 40px;
      background-color: #ffffff;
    }

    .login-form h2 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
      color: #6d4c41;
    }

    .branding {
      text-align: center;
      font-family: 'Pacifico', cursive;
      font-size: 32px;
      color: #d2691e;
      margin-bottom: 10px;
    }

    .btn-warning {
      background-color: #ff9800;
      border-color: #ff9800;
    }

    .btn-warning:hover {
      background-color: #fb8c00;
    }

    @media (max-width: 768px) {
      .login-wrapper {
        flex-direction: column;
      }
      .login-img {
        order: 1;
        min-height: 200px;
      }
      .login-form {
        order: 2;
      }
    }
  </style>
</head>
<body>

<!-- Animasi roti -->
<script>
  for (let i = 0; i < 30; i++) {
    const bread = document.createElement("div");
    bread.classList.add("bread");
    bread.innerText = ["🥖", "🍞", "🥐"][Math.floor(Math.random() * 3)];
    bread.style.left = Math.random() * 100 + "vw";
    bread.style.animationDuration = (Math.random() * 10 + 6) + "s";
    bread.style.fontSize = (Math.random() * 20 + 20) + "px";
    document.body.appendChild(bread);
  }
</script>

<!-- Login Box -->
<div class="login-wrapper">
  <!-- Gambar orang membuat roti -->
  <div class="login-img d-flex align-items-center justify-content-center">
  <img src="<?= base_url('assets/img/BG_Chef_Roti.jpg') ?>" alt="Orang Membuat Roti" class="img-fluid rounded shadow">
</div>


  <!-- Form Login -->
  <div class="login-form">
    <div class="branding">Kenari Cake & Bakery</div>
    <h2>Login Pengguna</h2>
    <?= $this->session->flashdata('error'); ?>
    <form action="<?= site_url('auth/proses_login') ?>" method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" id="username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" required>
      </div>
      <button type="submit" class="btn btn-warning w-100">Login</button>
      <p class="mt-3 text-center">Belum punya akun? <a href="<?= site_url('auth/register') ?>">Daftar</a></p>
    </form>
  </div>
</div>

</body>
</html>
