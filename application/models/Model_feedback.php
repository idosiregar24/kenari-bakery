<?php
class Model_feedback extends CI_Model {

    public function get_all_feedback()
    {
        $this->db->select('feedback.*, pengguna.nama_lengkap, pesanan.tanggal_pesanan');
        $this->db->from('feedback');
        $this->db->join('pesanan', 'feedback.id_pesanan = pesanan.id_pesanan');
        $this->db->join('pengguna', 'pesanan.id_user = pengguna.id_user');
        $this->db->order_by('feedback.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_feedback_detail($id_feedback)
    {
        $this->db->select('feedback.*, pengguna.nama_lengkap, pesanan.tanggal_pesanan');
        $this->db->from('feedback');
        $this->db->join('pesanan', 'feedback.id_pesanan = pesanan.id_pesanan');
        $this->db->join('pengguna', 'pesanan.id_user = pengguna.id_user');
        $this->db->where('feedback.id_feedback', $id_feedback);
        return $this->db->get()->row();
    }
}
?>
