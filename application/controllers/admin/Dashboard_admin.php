<?php 
class Dashboard_admin extends CI_Controller{
    public function index(){
         // Ambil data dari model
        $data['produk'] = $this->model_produk->tampil_data()->result();

        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar'); // pastikan ini juga benar
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates_admin/footer');       
    }
}
?>
