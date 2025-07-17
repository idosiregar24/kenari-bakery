<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller {

    public function index() {
        $this->load->view('templates/header'); // jika kamu punya template header
        $this->load->view('user/kontak');           // view kontak
        $this->load->view('templates/footer'); // jika kamu punya template footer
    }
}
