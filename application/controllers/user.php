<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_pesanan');
        $this->load->model('Model_produk'); // Pastikan Model_produk diload di __construct jika sering dipakai
        $this->load->library('pagination'); // Load library pagination
        $this->load->library('cart');
        // PERBAIKAN PENTING DI SINI:
        // Cek apakah 'user_logged_in' ada dan bernilai TRUE
        // DAN apakah 'user_role' adalah 'user'
        if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') !== 'user') {
            $this->session->set_flashdata('error', 'Anda harus login sebagai User untuk mengakses halaman ini.');
            redirect('auth/login'); // Arahkan kembali ke halaman login jika tidak valid
        }
    }

    public function dashboard()
    {
        $this->load->model('Model_produk');
        $data['produk'] = $this->Model_produk->tampil_data();

        $this->load->view('templates/header');
        $this->load->view('user/dashboard', $data);
        $this->load->view('templates/footer');
    }

    
public function tentang_kami() // Nama method untuk halaman "Tentang Kami"
    {
        $data['cart_items'] = $this->cart->total_items(); // Jika Anda menggunakan cart
        $data['user_logged_in'] = $this->session->userdata('user_logged_in');
        $data['user_nama_lengkap'] = $this->session->userdata('user_nama_lengkap');

        $this->load->view('templates/header', $data);
        $this->load->view('user/tentang_kami'); // Memuat view tentang.php
        $this->load->view('templates/footer');
    }

public function produk()
    {
        $search = $this->input->get('search');

        // Konfigurasi Pagination
        $config['base_url'] = base_url('user/produk'); // URL dasar untuk pagination
        $config['total_rows'] = $this->Model_produk->count_all_produk($search);
        $config['per_page'] = 16; // Jumlah produk per halaman
        $config['uri_segment'] = 3; // Segmen URI tempat nomor halaman berada (e.g., yoursite.com/user/produk/3)

        // Styling Pagination Bootstrap 5
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center mt-5">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;'; // Simbol panah untuk next
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;'; // Simbol panah untuk previous
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link'); // Tambahkan kelas Bootstrap ke tautan

        // Inisialisasi Pagination
        $this->pagination->initialize($config);

        // Ambil Offset (nomor halaman) dari URI
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // Ambil data produk dengan LIMIT dan OFFSET dari Model_produk
        $data['produk'] = $this->Model_produk->get_produk_paginated($config['per_page'], $page, $search);
        $data['pagination_links'] = $this->pagination->create_links(); // Buat tautan pagination

        $data['search'] = $search;

        $this->load->view('templates/header');
        $this->load->view('user/produk', $data); // Pastikan nama view ini benar (user/produk.php)
        $this->load->view('templates/footer');
    }
    


    public function kontak()
    {
        $this->load->view('templates/header');
        $this->load->view('user/kontak'); // <-- Buat file kontak.php
        $this->load->view('templates/footer');
    }

    public function tentang()
    {
        $this->load->view('templates/header');
        $this->load->view('user/tentang'); // <-- Buat file tentang.php
        $this->load->view('templates/footer');
    }

    public function profil()
    {   
    $this->load->library('session');
    // Pastikan user sudah login
    if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') !== 'user') {
        redirect('auth/login');
    }

    $user_id = $this->session->userdata('user_id');
    $this->load->model('Auth_model'); // Pastikan Auth_model sudah di-load
    $data['user_data'] = $this->Auth_model->get_user_by_id($user_id); // Anda perlu menambahkan fungsi ini di Auth_model

    $this->load->view('templates/header');
    $this->load->view('user/profil', $data); // Asumsi nama view Anda profil.php
    $this->load->view('templates/footer');
    }

    

    public function form_pesanan()
    {   
        $this->load->view('templates/header');
        $this->load->view('user/form_pesanan'); // <-- Buat file profil.php
        $this->load->view('templates/footer');
    }

    public function keranjang()
{
    $this->load->library('cart');
    $data['keranjang'] = $this->cart->contents();

    $this->load->view('templates/header');
    $this->load->view('user/keranjang', $data);
    $this->load->view('templates/footer');
}

    public function tambah_ke_keranjang()
{
    $harga = $this->input->post('harga');
    $qty   = $this->input->post('qty');

    $data = array(
        'id'      => $this->input->post('id'),
        'qty'     => $qty,
        'price'   => preg_replace('/[^\d]/', '', $harga),
        'name'    => $this->input->post('nama'),
        'options' => array('gambar' => $this->input->post('gambar'))
    );

    $this->cart->insert($data);

    // Jika request AJAX, kirim response JSON
    if ($this->input->is_ajax_request()) {
        echo json_encode(['status' => 'success']);
        return;
    }

    // Jika bukan AJAX (fallback)
    redirect('user/keranjang');
}


public function proses_pesanan()
{
    // PERBAIKAN PENTING: Ambil id user dari sesi menggunakan kunci 'user_id'
    $id_user = $this->session->userdata('user_id');

    // Pastikan user data diambil dengan benar, jika $id_user valid
    $user = $this->db->get_where('pengguna', ['id_user' => $id_user])->row_array();

    // Pastikan user ditemukan, jika tidak, handle error (misal: redirect ke halaman error atau login)
    if (!$user) {
        $this->session->set_flashdata('error', 'Data pengguna tidak ditemukan. Silakan login ulang.');
        redirect('auth/login'); // Atau halaman lain yang sesuai
        return; // Hentikan eksekusi lebih lanjut
    }

    // Proses upload file BUKTI
    $config['upload_path']   = './uploads/bukti/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size']      = 2048; // dalam KB (2 MB)

    // PERBAIKAN: Hapus salah satu baris duplikat ini
    $this->load->library('upload', $config); // Cukup satu kali

    if ($this->upload->do_upload('bukti_pembayaran')) {
        $upload_data = $this->upload->data();
        $bukti = 'bukti/' . $upload_data['file_name'];
    } else {
    $bukti = '';
    $error_upload = $this->upload->display_errors();
    $this->session->set_flashdata('error', 'Gagal upload bukti pembayaran: ' . strip_tags($error_upload));
    redirect('user/form_pesanan');
    return;
}


    // Simpan pesanan
    $data_pesanan = [
        'id_user'             => $id_user,
        'nama_pemesan'        => $user['nama_lengkap'],
        'no_telepon'          => $user['no_telepon'],
        'alamat'              => $user['alamat'],
        'tanggal_pesanan'     => date('Y-m-d'),
        'tanggal_pengambilan' => $this->input->post('tanggal_pengambilan'),
        'jenis_pemesanan'     => $this->input->post('jenis_pemesanan'),
        'metode_pembayaran'   => $this->input->post('metode_pembayaran'),   
        'catatan'             => $this->input->post('catatan'),  
        'bukti_pembayaran'    => $bukti
    ];

    // Lanjutan dari kode Anda (pastikan ini ada di file Anda)
    $this->db->insert('pesanan', $data_pesanan);
    $id_pesanan = $this->db->insert_id();

    foreach ($this->cart->contents() as $item) {
        $detail = [
            'id_pesanan'  => $id_pesanan,
            'id_produk'   => $item['id'],
            'nama_produk' => $item['name'],
            'jumlah'      => $item['qty'],
            'harga'       => $item['price'],
            'subtotal'    => $item['subtotal']
        ];
        $this->db->insert('detail_pesanan', $detail);
    }

    // Hancurkan keranjang setelah pesanan berhasil
    $this->cart->destroy();
    $this->session->set_flashdata('success', 'Pesanan Anda berhasil dibuat!');
    redirect('user/pesanan_saya'); // Redirect ke halaman pesanan saya setelah sukses
}

public function pesan()
{
    $this->load->library('cart');
    $data['keranjang'] = $this->cart->contents(); // Ini yang penting!

    $this->load->view('templates/header');
    $this->load->view('user/form_pesanan', $data); // Kirim variabel $keranjang
    $this->load->view('templates/footer');
}

public function hapus_keranjang()
{
    $this->cart->destroy();
    redirect('user/produk/');
}

    public function hapus_item($rowid)
{
    $this->cart->remove($rowid);
    redirect('user/keranjang');
}

public function pesanan_saya()
{
    $id_user = $this->session->userdata('user_id');
    $data['pesanan'] = $this->model_pesanan->get_pesanan_aktif_by_user($id_user);
    
    $this->load->view('templates/header');
    $this->load->view('user/pesanan_saya', $data);
    $this->load->view('templates/footer');
}

    public function pesanan_selesai()
{
    $id_user = $this->session->userdata('user_id');
    $data['pesanan'] = $this->model_pesanan->get_pesanan_selesai_by_user($id_user);

    $this->load->view('templates/header');
    $this->load->view('user/pesanan_selesai', $data);
    $this->load->view('templates/footer');
}

public function upload_sisa_dp($id_pesanan)
{
    $data['pesanan'] = $this->model_pesanan->get_pesanan_by_id($id_pesanan);

    $this->load->view('templates/header');
    $this->load->view('user/upload_sisa_dp', $data);
    $this->load->view('templates/footer');
}

public function proses_upload_sisa_dp()
{
    $id = $this->input->post('id_pesanan');
    $config['upload_path'] = './uploads/buktiPelunasan/';
    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    $config['file_name'] = 'bukti_sisa_dp_' . time();
    $this->load->library('upload', $config);

    if ($this->upload->do_upload('bukti_sisa_dp')) {
        $file = $this->upload->data('file_name');

        $this->db->where('id_pesanan', $id);
        $this->db->update('pesanan', [
            'bukti_sisa_dp' => $file
        ]);

        $this->session->set_flashdata('success', 'Bukti pelunasan berhasil diupload.');
    } else {
        $this->session->set_flashdata('error', 'Upload gagal: ' . $this->upload->display_errors());
    }

    redirect('user/detail_pesanan/' . $id);
}



public function feedback($id_pesanan)
{
    $data['pesanan'] = $this->model_pesanan->get_pesanan_by_id($id_pesanan);
    $this->load->view('templates/header');
    $this->load->view('user/form_feedback', $data);
    $this->load->view('templates/footer');
}

public function simpan_feedback()
{
    $data = [
        'id_pesanan' => $this->input->post('id_pesanan'),
        'komentar'   => $this->input->post('komentar'),
        'tanggal'    => date('Y-m-d')
    ];

    $this->db->insert('feedback', $data);
    $this->session->set_flashdata('success', 'Terima kasih atas feedback Anda!');
    redirect('user/pesanan_selesai');
}

public function detail_pesanan($id_pesanan)
{
    $id_user = $this->session->userdata('user_id'); // gunakan 'user_id', bukan 'id_user'

    // Ambil data pesanan
    $pesanan = $this->model_pesanan->get_pesanan_by_id($id_pesanan);
    
    // Cek apakah pesanan valid dan milik user
    if (!$pesanan || $pesanan->id_user != $id_user) {
        show_404();
    }

    // Ambil detail produk dalam pesanan
    $detail = $this->model_pesanan->get_detail_by_id($id_pesanan);

    $data['pesanan'] = $pesanan;
    $data['detail'] = $detail;

    $this->load->view('templates/header');
    $this->load->view('user/detail_pesanan', $data);
    $this->load->view('templates/footer');
}


public function update_item()
{
    $rowid = $this->input->post('rowid');
    $qty   = $this->input->post('qty');

    $data = array(
        'rowid' => $rowid,
        'qty'   => $qty
    );

    $this->cart->update($data);
    $this->session->set_flashdata('success', 'Jumlah item berhasil diperbarui.');
    redirect('user/keranjang');
}

public function update_profil()
{
    $this->load->library('session');
    if (!$this->session->userdata('user_logged_in')) {
        redirect('auth/login');
    }

    $id_user = $this->input->post('id_user');
    $data = [
        'nama_lengkap'     => $this->input->post('nama_lengkap'),
        'no_telepon'       => $this->input->post('no_telepon'),
        'provinsi'         => $this->input->post('provinsi'),
        'kabupaten'        => $this->input->post('kabupaten'),
        'kecamatan'        => $this->input->post('kecamatan'),
        'desa'             => $this->input->post('desa'),
        'rt_rw'            => $this->input->post('rt_rw'),
        'alamat_lengkap'   => $this->input->post('alamat_lengkap')
    ];

    $this->db->where('id_user', $id_user);
    $this->db->update('pengguna', $data);

    $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
    redirect('user/profil');
}

public function form_batal($id_pesanan)
{
    $data['pesanan'] = $this->model_pesanan->get_pesanan_by_id($id_pesanan);
    if (!$data['pesanan']) {
        $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
        redirect('user/pesanan');
    }

    $this->load->view('templates/header');
    $this->load->view('user/form_batal', $data);    
    $this->load->view('templates/footer');
}

public function proses_batal()
{
    $id_pesanan = $this->input->post('id_pesanan');
    $alasan     = $this->input->post('alasan');

    // Simpan ke tabel pembatalan_pesanan
    $data = [
        'id_pesanan' => $id_pesanan,
        'alasan'     => $alasan,
        'tanggal_batal' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('pembatalan_pesanan', $data);

    // Ubah status di tabel pesanan
    $this->db->where('id_pesanan', $id_pesanan);
    $this->db->update('pesanan', ['status_pesanan' => 'Dibatalkan']);

    $this->session->set_flashdata('success', 'Pesanan berhasil dibatalkan.');
    redirect('user/produk');
}

public function pesanan_dibatalkan()
{
    $id_user = $this->session->userdata('user_id'); 
    $this->load->model('model_pesanan');
    
    // Ambil data pesanan dibatalkan
    $pesanan = $this->model_pesanan->get_pesanan_dibatalkan_user($id_user);
    
    // Tambahkan total pembayaran ke setiap item pesanan
    foreach ($pesanan as &$p) {
        $p->total_pembayaran = $this->model_pesanan->get_total_pembayaran($p->id_pesanan);
    }

    $data['pesanan'] = $pesanan;

    $this->load->view('templates/header');
    $this->load->view('user/pesanan_dibatalkan', $data);
    $this->load->view('templates/footer');
}

public function detail_produk($id_produk)
{
    $data['produk'] = $this->Model_produk->get_produk_by_id($id_produk);
    if (!$data['produk']) {
        show_404();
    }

    $this->load->view('templates/header');
    $this->load->view('user/detail_produk', $data);
    $this->load->view('templates/footer');
}



}
