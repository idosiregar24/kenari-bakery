<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between py-3">
            <h3 class="mb-0 fs-4">
                <i class="fas fa-comments me-2"></i> Daftar Feedback Pelanggan
            </h3>
            </div>
        <div class="card-body p-4">
            <?php if (empty($feedback)): ?>
                <div class="alert alert-info text-center py-4 mb-0" role="alert">
                    <i class="fas fa-info-circle me-2"></i> Belum ada feedback dari pelanggan saat ini.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped custom-feedback-table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col" class="text-center">Tanggal Pesanan</th>
                                <th scope="col">Komentar</th>
                                <th scope="col" class="text-center">Tanggal Feedback</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($feedback as $f): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($f->nama_lengkap) ?></strong>
                                    </td>
                                    <td class="text-center"><?= date('d M Y', strtotime($f->tanggal_pesanan)) ?></td>
                                    <td>
                                        <p class="mb-0 text-muted small-text"><?= nl2br(htmlspecialchars($f->komentar)) ?></p>
                                    </td>
                                    <td class="text-center"><?= date('d M Y', strtotime($f->tanggal)) ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('admin/detail_pesanan/' . $f->id_pesanan) ?>" class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Pesanan">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>