<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_produk');
        $this->load->library('cart');
    }

    public function index(){
            $data['produk'] = $this->model_produk->tampil_data()->result();
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('user/produk', $data);
            $this->load->view('templates/footer');
        }
        public function tambah_ke_keranjang()
    {
        $harga = $this->input->post('harga');
        $qty   = $this->input->post('qty');

        $data = array(
            'id'      => $this->input->post('id'),
            'qty'     => $qty,
            'price'   => preg_replace('/[^\d]/', '', $harga), // hilangkan karakter non-digit
            'name'    => $this->input->post('nama'),
            'options' => array('gambar' => $this->input->post('gambar'))
        );

        $this->cart->insert($data); // Tambah ke keranjang
        redirect('user/produk/keranjang'); // Redirect ke halaman keranjang
    }

    public function keranjang()
{
    $this->load->library('cart'); // WAJIB!
    $this->load->view('templates/header');
    $this->load->view('user/keranjang');
    $this->load->view('templates/footer');
}

    public function hapus_item($rowid)
{
    $this->cart->remove($rowid);
    redirect('user/produk/keranjang');
}


public function hapus_keranjang()
{
    $this->cart->destroy();
    redirect('user/produk/keranjang');
}

public function checkout()
{
    // Proses simpan ke DB bisa dilakukan di sini
    // atau arahkan ke view form pembayaran
    $this->load->view('templates/header');
    $this->load->view('checkout');
    $this->load->view('templates/footer');
}
public function proses_pesanan()
{
    $id_user = $this->session->userdata('id_user'); // Ambil ID user dari sesi

$user = $this->db->get_where('user', ['id_user' => $id_user])->row_array();

$data_pesanan = [
  'id_user'             => $id_user, // simpan relasi ke user
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

$this->db->insert('pesanan', $data_pesanan);
$id_pesanan = $this->db->insert_id();

// simpan produk pesanan seperti sebelumnya

}
public function pesan()
{
    $this->load->library('cart'); // jika belum otomatis
    $data['keranjang'] = $this->cart->contents();    // kirim isi keranjang ke view
    $this->load->view('templates/header');
    $this->load->view('user/form_pesanan', $data);
    $this->load->view('templates/footer');
}



}
