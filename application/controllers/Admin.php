<?php
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_produk');
        $this->load->model('model_pesanan');
        $this->load->library('session');

        // PERBAIKAN PENTING DI SINI:
        // Cek apakah 'admin_logged_in' ada dan bernilai TRUE
        // DAN apakah 'admin_role' adalah 'admin'
        if (!$this->session->userdata('admin_logged_in') || $this->session->userdata('admin_role') !== 'admin') {
            $this->session->set_flashdata('error', 'Anda harus login sebagai Admin untuk mengakses halaman ini.');
            redirect('auth/login'); // Arahkan kembali ke halaman login jika tidak valid
        }
    }

    public function dashboard()
{
    $this->load->model('model_produk');
    $this->load->model('model_pesanan');

    $tahun = date('Y');


    $penjualan_bulanan = $this->model_pesanan->penjualan_per_bulan($tahun); // array bulan => total
    $data['penjualan_bulan'] = array_keys($penjualan_bulanan);
    $data['penjualan_total'] = array_values($penjualan_bulanan);
    $data['total_produk'] = $this->model_produk->count_produk();
    $data['total_penjualan'] = $this->model_pesanan->sum_total_penjualan();
    $data['pesanan_hari_ini'] = $this->model_pesanan->count_pesanan_hari_ini();
    $data['pesanan_dibatalkan'] = $this->model_pesanan->count_dibatalkan();
    $data['pesanan_selesai'] = $this->model_pesanan->count_selesai();
    $data['produk'] = $this->model_produk->get_all();
    $data['bulan'] = $this->model_pesanan->get_label_bulan();
    $data['jumlah_penjualan'] = $this->model_pesanan->get_data_penjualan();
    $data['produk_terlaris_nama'] = $this->model_produk->get_produk_terlaris_nama();
    $data['produk_terlaris_jumlah'] = $this->model_produk->get_produk_terlaris_jumlah();

    // ✅ Tambahkan ini:
    $this->db->order_by('tanggal_pesanan', 'DESC');
    $this->db->limit(5); // ambil 5 notifikasi terbaru
    $data['notifikasi'] = $this->db->get('pesanan')->result();

    // ✅ Tambahkan pendapatan hari ini:
    $data['pendapatan_hari_ini'] = $this->model_pesanan->sum_total_hari_ini();

    // ✅ Tambahkan pendapatan bulan ini:
    $data['pendapatan_bulan_ini'] = $this->model_pesanan->sum_total_bulan_ini();

    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar'); // jika ada sidebar
    $this->load->view('Admin/dashboard', $data);
    $this->load->view('templates_admin/footer');
}


    public function data_barang()
    {

        $data['produk'] = $this->model_produk->tampil_data(); // harus return array objek
        $data['kategori'] = $this->model_produk->get_all_kategori(); // untuk dropdown kategori

        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar'); // jika ada sidebar
        $this->load->view('admin/data_barang', $data);
        $this->load->view('templates_admin/footer');
    }

    public function data_pesanan()
{
    $data['pesanan'] = $this->db->get('pesanan')->result();

    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/data_pesanan', $data);
    $this->load->view('templates_admin/footer');
}


    public function tambah_aksi() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('gambar')) {
            $upload_data = $this->upload->data();
            $gambar = $upload_data['file_name'];

            $data = [
                'nama_produk'   => $this->input->post('nama_produk'),
                'detail_produk' => $this->input->post('detail_produk'),
                'kategori_id'   => $this->input->post('kategori_id'),
                'harga'         => $this->input->post('harga'),
                'gambar'        => $gambar
            ];

            $this->model_produk->insert_produk($data);
            redirect('admin/data_barang');
        } else {
            echo "Gagal upload gambar";
        }
    }
    public function edit($id)
{
    $data['produk'] = $this->model_produk->get_by_id($id); // return ->row()
    $data['kategori'] = $this->model_produk->get_all_kategori();

    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/edit_barang', $data);
    $this->load->view('templates_admin/footer');
}



    public function update()
{
    $id_produk     = $this->input->post('id_produk');
    $nama_produk   = $this->input->post('nama_produk');
    $detail_produk = $this->input->post('detail_produk');
    $kategori_id   = $this->input->post('kategori_id');
    $harga         = $this->input->post('harga');

    $data_update = [
        'nama_produk'   => $nama_produk,
        'detail_produk' => $detail_produk,
        'kategori_id'   => $kategori_id,
        'harga'         => $harga
    ];

    // Jika gambar baru diunggah
    if (!empty($_FILES['gambar']['name'])) {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('gambar')) {
            $upload_data = $this->upload->data();
            $gambar_baru = $upload_data['file_name'];

            // Simpan nama gambar baru ke database
            $data_update['gambar'] = $gambar_baru;

            // Optional: hapus gambar lama (jika ingin)
            $produk = $this->model_produk->get_by_id($id_produk);
            if ($produk->gambar && file_exists('./uploads/' . $produk->gambar)) {
                unlink('./uploads/' . $produk->gambar);
            }
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('admin/data_barang/edit/' . $id_produk);
        }
    }

    $this->model_produk->update_produk($id_produk, $data_update);
    $this->session->set_flashdata('success', 'Produk berhasil diperbarui!');
    redirect('admin/dashboard');
}

        public function hapus($id_produk)
{

    $produk = $this->model_produk->get_by_id($id_produk);
    if ($produk) {
        if ($produk->gambar && file_exists('./uploads/' . $produk->gambar)) {
            unlink('./uploads/' . $produk->gambar);
        }

        $this->model_produk->hapus_produk($id_produk);
        $this->session->set_flashdata('success', 'Produk berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Produk tidak ditemukan.');
    }
    redirect('admin/dashboard');
}

public function ubah_status_pesanan($id_pesanan)
{
    $this->db->where('id_pesanan', $id_pesanan);
    $this->db->update('pesanan', ['status_pesanan' => 'Pesanan Selesai']);

    $this->session->set_flashdata('success', 'Status pesanan berhasil diubah menjadi "selesai".');
    redirect('admin/data_pesanan');
}

public function ubah_status_pesanan_produksi($id_pesanan)
{
    $this->db->where('id_pesanan', $id_pesanan);
    $this->db->update('pesanan', ['status_pesanan' => 'Pesanan Selesai']);

    $this->session->set_flashdata('success', 'Status pesanan berhasil diubah menjadi "selesai".');
    redirect('admin/produksi');
}

public function konfirmasi_pembayaran($id_pesanan)
{
    // Ambil data pesanan dulu
    $pesanan = $this->db->get_where('pesanan', ['id_pesanan' => $id_pesanan])->row();

    if (!$pesanan) {
        $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
        redirect('admin/data_pesanan');
    }

    // Cek metode pembayaran untuk tentukan status pelunasan
    $status_pelunasan = ($pesanan->metode_pembayaran == 'DP') ? 'belum lunas' : 'lunas';

    // Update status pembayaran + pelunasan + status pesanan
    $this->db->where('id_pesanan', $id_pesanan);
    $this->db->update('pesanan', [
        'status_pembayaran' => 'diterima'
    ]);

    $this->session->set_flashdata('success', 'Pembayaran berhasil dikonfirmasi.');
    redirect('admin/data_pesanan');
}


public function pesanan_diterima()
{
    $data['pesanan'] = $this->model_pesanan->get_pesanan_diterima();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/pesanan_diterima', $data);
    $this->load->view('templates_admin/footer');
}

public function get_pesanan_diterima()
{
    return $this->db
        ->where('status_pembayaran', 'diterima')
        ->where('status_pesanan !=', 'Pesanan Selesai')
        ->where('metode_pembayaran', 'fullpayment')
        ->get('pesanan')
        ->result();
}

public function pesanan_selesai()
{
    $this->load->model('model_pesanan');
    $data['pesanan'] = $this->model_pesanan->get_pesanan_selesai();
    $this->load->view('user/pesanan_selesai', $data);
}



public function tolak_pembayaran($id_pesanan)
{
    // Misal: update status pembayaran di database
    $this->db->where('id_pesanan', $id_pesanan);
    $this->db->update('pesanan', [
        'status_pembayaran' => 'ditolak'
    ]);

    $this->session->set_flashdata('success', 'Pembayaran berhasil ditolak.');
    redirect('admin/data_pesanan');
}


public function detail_pesanan($id_pesanan)
{
    // Ambil data pesanan
    $this->db->select('pesanan.*, pengguna.alamat_lengkap, pengguna.rt_rw, pengguna.desa, pengguna.kecamatan, pengguna.kabupaten, pengguna.provinsi');
    $this->db->from('pesanan');
    $this->db->join('pengguna', 'pengguna.id_user = pesanan.id_user');
    $this->db->where('id_pesanan', $id_pesanan);
    $data['pesanan'] = $this->db->get()->row();



    // Ambil detail produk dari pesanan
     $data['detail'] = $this->db->get_where('detail_pesanan', ['id_pesanan' => $id_pesanan])->result();

    // Load view detail
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/detail_pesanan', $data);
    $this->load->view('templates_admin/footer');   
}

public function kirim_notifikasi($id_pesanan)
{
    // Ambil data pesanan
    $pesanan = $this->db->get_where('pesanan', ['id_pesanan' => $id_pesanan])->row();

    if (!$pesanan) {
        $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
        redirect('admin/data_pesanan');
    }

    // Format nomor WhatsApp
    $no_wa = preg_replace('/[^0-9]/', '', $pesanan->no_telepon);
    if (substr($no_wa, 0, 1) === '0') {
        $no_wa = '62' . substr($no_wa, 1);
    }

    // Ambil detail pesanan
    $detail = $this->db->get_where('detail_pesanan', ['id_pesanan' => $id_pesanan])->result();

    // Hitung total pembayaran jika belum tersedia
    $total_pembayaran = $pesanan->total_pembayaran;
    if (!$total_pembayaran || $total_pembayaran == 0) {
        $total_pembayaran = 0;
        foreach ($detail as $d) {
            $total_pembayaran += $d->harga * $d->jumlah;
        }
    }

    // Buat isi pesan
    $pesan = "*Halo {$pesanan->nama_pemesan},*\n\n";
    $pesan .= "Pesanan Anda dengan ID *#{$pesanan->id_pesanan}* telah *SELESAI* dan siap untuk diambil atau dikirim.\n\n";
    $pesan .= "*Rincian Pesanan:*\n";

    foreach ($detail as $d) {
        $pesan .= "- {$d->nama_produk} x{$d->jumlah}\n";
    }

    $pesan .= "\n*Total Pembayaran:* Rp " . number_format($total_pembayaran, 0, ',', '.');
    $pesan .= "\n\n*Waktu Pengambilan:* Setiap hari pukul 08.00 - 17.00";
    $pesan .= "\n*Alamat Toko:* Jl. Mawar No.123, Pekanbaru";
    $pesan .= "\n*Kontak Admin:* 0812-3456-7890";
    $pesan .= "\n\nTerima kasih telah memesan di *Kenari Cake & Bakery*.\nKami menantikan kunjungan Anda.";

    // Encode dan redirect ke WhatsApp
    $pesan_encoded = rawurlencode($pesan);
    $wa_link = "https://wa.me/{$no_wa}?text={$pesan_encoded}";
    redirect($wa_link);
}

public function invoices()
{
    $start = $this->input->get('start');
    $end   = $this->input->get('end');

    $this->db->select('*');
    $this->db->from('pesanan');
    $this->db->where('status_pesanan', 'Pesanan Selesai');

    // Cek apakah input tanggal terisi
    if (!empty($start) && !empty($end)) {
        $this->db->where('tanggal_pesanan >=', $start);
        $this->db->where('tanggal_pesanan <=', $end);
    }

    // Urutkan berdasarkan tanggal terbaru
    $this->db->order_by('tanggal_pesanan', 'DESC');

    $query = $this->db->get();
    $data['invoices'] = $query->result();

    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/invoices', $data);
    $this->load->view('templates_admin/footer');
}




public function cetak_laporan()
{
    // Load library Dompdf (dari autoload atau library buatan sendiri)
    $this->load->library('pdf');

    // Ambil data dari form GET
    $start = $this->input->get('start');
    $end   = $this->input->get('end');

    // Validasi tanggal
    if (!$start || !$end) {
        show_error("Tanggal awal dan akhir wajib diisi untuk mencetak laporan.");
    }

    // Ambil data pesanan yang dibayar dan belum selesai
    $this->db->select('p.*, u.nama_lengkap as nama_pemesan');
    $this->db->from('pesanan p');
    $this->db->join('pengguna u', 'p.id_user = u.id_user');
    $this->db->where('p.status_pembayaran', 'diterima');
    $this->db->where('p.status_pesanan !=', 'Pesanan Selesai');
    $this->db->where('p.tanggal_pesanan >=', $start);
    $this->db->where('p.tanggal_pesanan <=', $end);

    $pesanan = $this->db->get()->result();

    // Ambil semua detail pesanan sekaligus untuk efisiensi
    $id_pesanan_list = array_column($pesanan, 'id_pesanan');

    $detail_map = [];
    if (!empty($id_pesanan_list)) {
        $this->db->where_in('id_pesanan', $id_pesanan_list);
        $details = $this->db->get('detail_pesanan')->result();

        // Kelompokkan detail berdasarkan id_pesanan
        foreach ($details as $d) {
            $detail_map[$d->id_pesanan][] = $d;
        }
    }

    // Gabungkan detail ke masing-masing pesanan
    foreach ($pesanan as &$p) {
        $p->detail_produk = $detail_map[$p->id_pesanan] ?? [];
    }

    // Siapkan data untuk view
    $data['pesanan'] = $pesanan; 
    $data['start'] = $start;
    $data['end'] = $end;

    // Ambil HTML view
    $html = $this->load->view('admin/cetak_laporan', $data, true);

    // Load PDF
    $this->pdf->loadHtml($html);
    $this->pdf->setPaper('A4', 'portrait');
    $this->pdf->render();

    // Stream ke browser tanpa force download
    $this->pdf->stream("laporan_produksi_" . date('Ymd_His') . ".pdf", array("Attachment" => false));
}



public function tandai_selesai($id_pesanan)
{
    // Pastikan model dimuat (jika belum di autoload)
    $this->load->model('model_pesanan');

    // Validasi ID
    if (!$id_pesanan) {
        show_404();
        return;
    }

    // Cek apakah data pesanan ada
    $pesanan = $this->model_pesanan->get_pesanan_by_id($id_pesanan);
    if (!$pesanan) {
        $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
        redirect('admin/data_pesanan');
        return;
    }

    // Update status pesanan
    $this->db->where('id_pesanan', $id_pesanan);
    $this->db->update('pesanan', ['status_pelunasan' => 'lunas']);

    if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('success', 'Pesanan berhasil ditandai sebagai selesai.');
    } else {
        $this->session->set_flashdata('warning', 'Status tidak berubah atau pesanan sudah selesai.');
    }

    redirect('admin/pesanan_diterima');
}



public function search()
{
    $keyword = $this->input->get('keyword');

    // Cari di tabel pesanan
    $this->db->like('nama_pemesan', $keyword);
    $this->db->or_like('no_telepon', $keyword);
    $this->db->or_like('status_pesanan', $keyword);
    $data['hasil_pesanan'] = $this->db->get('pesanan')->result();

    // Cari di tabel detail_pesanan
    $this->db->like('nama_produk', $keyword);
    $data['hasil_produk'] = $this->db->get('detail_pesanan')->result();

    // Cari di tabel barang
    $this->db->like('nama_produk', $keyword);
    $data['hasil_barang'] = $this->db->get('produk')->result();

    $data['keyword'] = $keyword;
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/hasil_pencaharian', $data);
    $this->load->view('templates_admin/footer');
}

public function cari()
{
    $keyword = $this->input->get('keyword');
    
    if (!$keyword) {
        redirect('admin/dashboard_admin');
    }

    // Cari di pesanan
    $this->db->like('nama_pemesan', $keyword);
    $this->db->or_like('id_pesanan', $keyword);
    $pesanan = $this->db->get('pesanan')->result();

    // Cari di detail_pesanan
    $this->db->like('nama_produk', $keyword);
    $produk = $this->db->get('detail_pesanan')->result();

    // Cari di data_barang
    $this->db->like('nama_barang', $keyword);
    $barang = $this->db->get('data_barang')->result();

    $data['hasil_pesanan'] = $pesanan;
    $data['hasil_produk'] = $produk;
    $data['hasil_barang'] = $barang;
    $data['keyword'] = $keyword;

    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/hasil_pencarian', $data);
    $this->load->view('templates_admin/footer');
}

public function konfirmasi_sisa_dp()
{
    $id_pesanan = $this->input->post('id_pesanan');
    $aksi = $this->input->post('aksi');

    if ($aksi === 'terima') {
        $this->db->where('id_pesanan', $id_pesanan)
                 ->update('pesanan', ['status_pembayaran' => 'diterima'])
                 ->update('pesanan', ['status_pelunasan' => 'lunas']);
        $this->session->set_flashdata('success', 'Sisa pembayaran telah dikonfirmasi.');
    } elseif ($aksi === 'tolak') {
        $this->db->where('id_pesanan', $id_pesanan)
                 ->update('pesanan', ['status_pembayaran' => 'ditolak'])
                 ->update('pesanan', ['status_pelunasan' => 'belum lunas']);
        $this->session->set_flashdata('warning', 'Sisa pembayaran ditolak.');
    }
    redirect('admin/detail_pesanan/'.$id_pesanan);
}

public function daftar_feedback()
{
    $this->load->model('Model_feedback');
    $data['feedback'] = $this->Model_feedback->get_all_feedback();
    
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/daftar_feedback', $data);
    $this->load->view('templates_admin/footer');
}

public function pesanan_by_metode()
{
    $metode = $this->input->get('metode');
    $status_pesanan = $this->input->get('status_pesanan');

    if ($metode) {
        $this->db->where('metode_pembayaran', $metode);
        $this->db->where('status_pesanan !=', 'pesanan selesai');
        $query = $this->db->get('pesanan');
        $data['pesanan'] = $query->result();
    }
    else {
        $data['pesanan'] = [];
    }
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/pesanan_diterima', $data);
    $this->load->view('templates_admin/footer');
}

public function pesanan_dibatalkan()
{
    $this->load->model('model_pesanan');
    $data['pesanan'] = $this->model_pesanan->get_pesanan_dibatalkan();

    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/pesanan_dibatalkan', $data);
    $this->load->view('templates_admin/footer');
}

public function produksi()
{
    $start = $this->input->get('start');
    $end = $this->input->get('end');

    $this->db->select('p.*, u.nama_lengkap as nama_pemesan');
    $this->db->from('pesanan p');
    $this->db->join('pengguna u', 'p.id_user = u.id_user');
    $this->db->where('p.status_pembayaran', 'diterima');
    $this->db->where('p.status_pesanan !=', 'Pesanan Selesai');

    if (!empty($start) && !empty($end)) {
        $this->db->where('p.tanggal_pesanan >=', $start);
        $this->db->where('p.tanggal_pesanan <=', $end);
    }

    $pesanan = $this->db->get()->result();

    // Tambahkan detail produk
    foreach ($pesanan as &$p) {
        $p->detail_produk = $this->db->get_where('detail_pesanan', ['id_pesanan' => $p->id_pesanan])->result();
    }

    $data['pesanan'] = $pesanan;

    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/produksi', $data);
    $this->load->view('templates_admin/footer');
}


public function cetak_pdf_produksi()
{
    $this->load->library('pdf');

    $start = $this->input->get('start');
    $end = $this->input->get('end');

    $this->db->select('p.*, u.nama_lengkap as nama_pemesan');
    $this->db->from('pesanan p');
    $this->db->join('pengguna u', 'p.id_user = u.id_user');
    $this->db->where('p.status_pembayaran', 'diterima');
    $this->db->where('p.status_pesanan !=', 'Pesanan Selesai');

    if (!empty($start) && !empty($end)) {
        $this->db->where('p.tanggal_pesanan >=', $start);
        $this->db->where('p.tanggal_pesanan <=', $end);
    }

    $pesanan = $this->db->get()->result();

    foreach ($pesanan as &$p) {
        $p->detail_produk = $this->db->get_where('detail_pesanan', ['id_pesanan' => $p->id_pesanan])->result();
    }

    $data['pesanan'] = $pesanan;

    $html = $this->load->view('admin/produksi_pdf', $data, true);

    $this->pdf->loadHtml($html);
    $this->pdf->setPaper('A4', 'portrait');
    $this->pdf->render();
    $this->pdf->stream("laporan_produksi_" . date('Ymd') . ".pdf", array("Attachment" => false));
}

public function get_penjualan_bulanan()
{
    $this->db->select("MONTH(tanggal_pesanan) AS bulan, SUM(total_pembayaran) AS total");
    $this->db->from("pesanan");
    $this->db->where("status", "selesai");
    $this->db->group_by("bulan");
    $this->db->order_by("bulan", "ASC");

    $result = $this->db->get()->result();

    $labels = [];
    $data = [];

    foreach ($result as $row) {
        $labels[] = date('M', mktime(0, 0, 0, $row->bulan, 1));
        $data[] = (int) $row->total;
    }

    return ['labels' => $labels, 'data' => $data];
}

public function get_data_penjualan_bulanan()
{
    $this->load->model('model_pesanan'); // Jika belum autoload
    $tahun = date('Y');
    $data_penjualan = $this->model_pesanan->penjualan_per_bulan($tahun); // ✅ PERBAIKAN DI SINI

    $labels = [
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];

    $data = array_values($data_penjualan);

    header('Content-Type: application/json');
    echo json_encode([
        'labels' => $labels,
        'data' => $data
    ]);
}




}
?>
