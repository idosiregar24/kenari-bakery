<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrasi | Kenari Cake & Bakery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, #fff3e0, #ffe0b2);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .register-wrapper {
      max-width: 960px;
      width: 100%;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.1);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
      margin: 40px 15px;
    }

    .register-img {
      flex: 1 1 45%;
      background: url('<?= base_url("assets/img/BG_Chef_Roti.jpg") ?>') no-repeat center;
      background-size: cover;
      background-position: center;
      min-height: 500px;
    }

    .register-form {
      flex: 1 1 55%;
      padding: 40px 30px;
      background-color: #ffffff;
    }

    .register-form h2 {
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
      margin-bottom: 20px;
    }

    .form-control {
      background-color: #fdfdfd;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 10px 12px;
      font-size: 14px;
    }

    label {
      font-weight: 500;
      margin-bottom: 5px;
      display: block;
    }

    textarea.form-control {
      resize: none;
    }

    .btn-success {
      background-color: #43a047;
      border-color: #43a047;
      font-weight: bold;
      font-size: 16px;
      padding: 10px;
      border-radius: 8px;
    }

    .btn-success:hover {
      background-color: #388e3c;
    }

    .text-center a {
      text-decoration: none;
      color: #ff9800;
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .register-wrapper {
        flex-direction: column;
      }
      .register-img {
        order: 1;
        min-height: 220px;
      }
      .register-form {
        order: 2;
      }
    }
  </style>
</head>
<body>

<div class="register-wrapper">
  <!-- Gambar orang membuat roti -->
  <div class="register-img"></div>

  <!-- Form Registrasi -->
  <div class="register-form">
    <div class="branding">Kenari Cake & Bakery</div>
    <h2>Registrasi Pengguna</h2>

    <form action="<?= site_url('auth/proses_register') ?>" method="post">
      <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>No Telepon</label>
        <input type="text" name="no_telepon" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Provinsi</label>
        <input type="text" name="provinsi" class="form-control" value="Riau" readonly>
      </div>
      <div class="mb-3">
        <label>Kabupaten/Kota</label>
        <input type="text" name="kabupaten" class="form-control" value="Kota Pekanbaru" readonly>
      </div>
      <div class="mb-3">
        <label>Kecamatan</label>
        <input type="text" name="kecamatan" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Desa/Kelurahan</label>
        <input type="text" name="desa" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>RT/RW</label>
        <input type="text" name="rt_rw" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Alamat Lengkap</label>
        <textarea name="alamat_lengkap" class="form-control" rows="2" required></textarea>
      </div>
      <button type="submit" class="btn btn-success w-100">Daftar</button>
      <p class="mt-3 text-center">Sudah punya akun? <a href="<?= site_url('auth/login') ?>">Login di sini</a></p>
    </form>
  </div>
</div>

</body>
</html>
