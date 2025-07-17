<?php
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model'); // pastikan model ini dipakai
        $this->load->library('session');
    }

    public function register()
    {
        $this->load->view('auth/register');
    }

    public function proses_register()
    {
        $data = [
            'nama_lengkap'     => $this->input->post('nama_lengkap'),
            'username'         => $this->input->post('username'),
            'password'         => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'no_telepon'       => $this->input->post('no_telepon'),
            'provinsi'         => $this->input->post('provinsi'),
            'kabupaten'        => $this->input->post('kabupaten'),
            'kecamatan'        => $this->input->post('kecamatan'),
            'desa'             => $this->input->post('desa'),
            'rt_rw'            => $this->input->post('rt_rw'),
            'alamat_lengkap'   => $this->input->post('alamat_lengkap'),
            'role'             => 'user'
]; 

        $this->Auth_model->register($data);
        $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
        redirect('auth/login');
    }

    public function login()
    {

        $this->load->view('auth/login');
 
    }

    public function proses_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
            
        $user = $this->db->get_where('pengguna', ['username' => $username])->row_array();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['role'] === 'admin') {
                $this->session->set_userdata([
                    'admin_logged_in' => true,
                    'admin_id'        => $user['id_user'],
                    'admin_username'  => $user['username'],
                    'admin_role'      => $user['role'],
                    'admin_nama_lengkap' => $user['nama_lengkap'] // Tambahkan ini untuk admin jika diperlukan di header admin
                ]);
                redirect('admin/dashboard');
            } else { // Asumsi role selain 'admin' adalah 'user'
                $this->session->set_userdata([
                    'user_logged_in' => true,
                    'user_id'        => $user['id_user'],
                    'user_username'  => $user['username'],
                    'user_role'      => $user['role'],
                    'user_nama_lengkap' => $user['nama_lengkap'] // <<< TAMBAHKAN BARIS INI
                ]);
                redirect('user/dashboard');
            }
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth/login');     
        }
    }
    public function logout()
    {
        // Fungsi logout ini akan menghancurkan SEMUA sesi.
        // Jika Anda ingin logout spesifik (misal hanya admin atau hanya user),
        // Anda bisa membuat fungsi logout_admin() dan logout_user() seperti saran sebelumnya,
        // yang hanya unset variabel sesi terkait.
        $this->session->sess_destroy(); 
        $this->session->set_flashdata('success', 'Anda telah logout.');
        redirect('auth/login');
    }

    
}
