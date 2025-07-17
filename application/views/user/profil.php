<div class="container my-5">
  <h2 class="mb-4">Profil Pengguna</h2>

  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title mb-3">Informasi Akun</h5>

      <div class="row mb-2">
        <div class="col-md-4 fw-bold">Nama Lengkap</div>
        <div class="col-md-8"><?= $user_data['nama_lengkap'] ?></div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-bold">Username</div>
        <div class="col-md-8"><?= $user_data['username'] ?></div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-bold">No Telepon</div>
        <div class="col-md-8"><?= $user_data['no_telepon'] ?? '-' ?></div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-bold">Alamat</div>
        <div class="col-md-8">
          <?= $user_data['alamat_lengkap'] ?><br>
          RT/RW: <?= $user_data['rt_rw'] ?><br>
          Desa/Kelurahan: <?= $user_data['desa'] ?><br>
          Kecamatan: <?= $user_data['kecamatan'] ?><br>
          Kabupaten/Kota: <?= $user_data['kabupaten'] ?><br>
          Provinsi: <?= $user_data['provinsi'] ?>
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-bold">Role</div>
        <div class="col-md-8"><?= $user_data['role'] ?></div>
      </div>

      <div class="mt-4 d-flex justify-content-between">
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger">Logout</a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit Profil</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('user/update_profil') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_user" value="<?= $user_data['id_user'] ?>">

          <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="<?= $user_data['nama_lengkap'] ?>" required>
          </div>

          <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" class="form-control" name="no_telepon" value="<?= $user_data['no_telepon'] ?>">
          </div>

          <div class="mb-3">
            <label>Provinsi</label>
            <input type="text" class="form-control" name="provinsi" value="<?= $user_data['provinsi'] ?>">
          </div>

          <div class="mb-3">
            <label>Kabupaten/Kota</label>
            <input type="text" class="form-control" name="kabupaten" value="<?= $user_data['kabupaten'] ?>">
          </div>

          <div class="mb-3">
            <label>Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" value="<?= $user_data['kecamatan'] ?>">
          </div>

          <div class="mb-3">
            <label>Desa/Kelurahan</label>
            <input type="text" class="form-control" name="desa" value="<?= $user_data['desa'] ?>">
          </div>

          <div class="mb-3">
            <label>RT/RW</label>
            <input type="text" class="form-control" name="rt_rw" value="<?= $user_data['rt_rw'] ?>">
          </div>

          <div class="mb-3">
            <label>Alamat Lengkap (Jalan, No Rumah, dll)</label>
            <textarea class="form-control" name="alamat_lengkap" rows="2"><?= $user_data['alamat_lengkap'] ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>
