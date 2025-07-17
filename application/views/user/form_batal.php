<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-danger text-white text-center py-4 rounded-top">
            <h3 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Batalkan Pesanan #<?= $pesanan->id_pesanan ?></h3>
            <p class="mb-0 mt-2">Mohon berikan alasan yang jelas untuk pembatalan ini.</p>
        </div>
        <div class="card-body p-4">
            <form action="<?= base_url('user/proses_batal') ?>" method="post">
                <input type="hidden" name="id_pesanan" value="<?= $pesanan->id_pesanan ?>">

                <div class="mb-4">
                    <label for="alasan" class="form-label fw-bold text-danger">Alasan Pembatalan <span class="text-muted">(Wajib)</span></label>
                    <textarea name="alasan" id="alasan" rows="5" class="form-control form-control-lg border-danger" placeholder="Misalnya: Barang tidak sesuai, berubah pikiran, atau alasan lainnya..." required></textarea>
                    <div class="form-text text-muted mt-2">
                        Alasan pembatalan Anda akan membantu kami meningkatkan layanan.
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= base_url('user/pesanan_saya') ?>" class="btn btn-secondary btn-lg order-md-2">
                        <i class="fas fa-times-circle me-2"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-danger btn-lg order-md-1">
                        <i class="fas fa-trash-alt me-2"></i> Konfirmasi Pembatalan
                    </button>
                </div>
            </form>
        </div>
        <div class="card-footer bg-light text-muted text-center py-3 rounded-bottom">
            Pastikan Anda yakin sebelum melanjutkan. Pembatalan bersifat final.
        </div>
    </div>
</div>