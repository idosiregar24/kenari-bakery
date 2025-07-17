<?php

    class Dashboard extends CI_Controller{

        public function index(){
            $data['produk'] = $this->model_produk->tampil_data()->result();
            $this->load->view('templates/header');
            $this->load->view('user/dashboard', $data);
            $this->load->view('templates/footer');
        }
       
    }

?> 