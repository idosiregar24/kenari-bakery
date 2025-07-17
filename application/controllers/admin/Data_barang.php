<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_barang extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Pastikan admin sudah login
        if (!$this->session->userdata('is_login') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }

        $this->load->model('Produk_model');
    }

    public function index() {
        $data['produk'] = $this->Produk_model->get_all_produk();
        $data['kategori'] = $this->Produk_model->get_all_kategori();

        $this->load->view('templates_admin/header');
        $this->load->view('admin/data_barang', $data);
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

            $this->Produk_model->insert_produk($data);
            redirect('admin/data_barang');
        } else {
            echo "Gagal upload gambar";
        }
    }
}
