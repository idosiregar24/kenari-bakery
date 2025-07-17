<?php
class Model_pesanan extends CI_Model {

    public function get_all_pesanan()
    {
         $this->db->order_by('tanggal_pesanan', 'DESC'); // Tambahkan ini
        return $this->db->get('pesanan')->result();
    }

    public function get_pesanan_by_id($id_pesanan)
    {
        return $this->db->get_where('pesanan', ['id_pesanan' => $id_pesanan])->row();
    }

    public function get_detail_by_id($id_pesanan)
    {
        return $this->db->get_where('detail_pesanan', ['id_pesanan' => $id_pesanan])->result();
    }

    // Model_pesanan.php
    public function get_pesanan_diterima()
{
    return $this->db->get_where('pesanan', ['status_pembayaran' => 'diterima'])->result();
}

public function get_pesanan_selesai_by_user($id_user)
{

    return $this->db
        ->select('pesanan.*, SUM(detail_pesanan.subtotal) AS total_pembayaran')
        ->from('pesanan')
        ->join('detail_pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan', 'left')
        ->where('pesanan.id_user', $id_user)
        ->where('pesanan.status_pesanan', 'Pesanan Selesai')
        ->where('pesanan.status_pembayaran', 'diterima')
        ->where('pesanan.status_pelunasan', 'lunas')
        ->group_by('pesanan.id_pesanan')
        ->order_by('pesanan.tanggal_pesanan', 'DESC')
        ->get()
        ->result();
}


public function get_pesanan_by_user($id_user)
{
        return $this->db->select('pesanan.*, SUM(detail_pesanan.subtotal) AS total_pembayaran')
        ->from('pesanan')
        ->join('detail_pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan', 'left')
        ->where('pesanan.id_user', $id_user)
        ->group_by('pesanan.id_pesanan')
        ->order_by('pesanan.tanggal_pesanan', 'DESC')
        ->get()
        ->result();
}

public function get_pesanan_aktif_by_user($id_user)
{
    return $this->db->select('pesanan.*, SUM(detail_pesanan.subtotal) AS total_pembayaran')
        ->from('pesanan')
        ->join('detail_pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan', 'left')
        ->where('pesanan.id_user', $id_user)
        ->group_start()
            ->where('pesanan.status_pelunasan !=', 'lunas')
        ->group_end()
        ->group_by('pesanan.id_pesanan')
        ->order_by('pesanan.tanggal_pesanan', 'DESC')
        ->get()
        ->result();
}

public function get_feedback_by_pesanan($id_pesanan)
{
    return $this->db->get_where('feedback', ['id_pesanan' => $id_pesanan])->row();
}

public function get_pesanan_by_id_and_user($id_pesanan, $id_user)
{
    return $this->db
        ->where('id_pesanan', $id_pesanan)
        ->where('id_user', $id_user)
        ->get('pesanan')
        ->row();
}

public function get_pesanan_by_metode($metode)
{
    return $this->db->get_where('pesanan', [
        'metode_pembayaran' => $metode
    ])->result();
}

public function get_pesanan_dibatalkan()
{
    $this->db->select('pesanan.*, pembatalan_pesanan.alasan, pembatalan_pesanan.tanggal_batal');
    $this->db->from('pesanan');
    $this->db->join('pembatalan_pesanan', 'pembatalan_pesanan.id_pesanan = pesanan.id_pesanan');
    $this->db->where('pesanan.status_pesanan', 'Dibatalkan');
    $this->db->order_by('pembatalan_pesanan.tanggal_batal', 'DESC');

    return $this->db->get()->result();
}

public function get_pesanan_dibatalkan_user($id_user)
{
    $this->db->select('pesanan.*, pembatalan_pesanan.alasan, pembatalan_pesanan.tanggal_batal');
    $this->db->from('pesanan');
    $this->db->join('pembatalan_pesanan', 'pembatalan_pesanan.id_pesanan = pesanan.id_pesanan');
    $this->db->where('pesanan.status_pesanan', 'Dibatalkan');
    $this->db->where('pesanan.id_user', $id_user);
    return $this->db->get()->result();
}

public function total_penjualan()
{
    $this->db->select('SUM(detail_pesanan.harga * detail_pesanan.jumlah) AS total');
    $this->db->from('detail_pesanan');
    $this->db->join('pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan');
    $this->db->where('pesanan.status_pembayaran', 'diterima');
    $query = $this->db->get();
    return $query->row()->total ?? 0;
}


public function pesanan_hari_ini()
{
    $this->db->where('DATE(tanggal_pesanan)', date('Y-m-d'));
    return $this->db->get('pesanan')->num_rows();
}

public function penjualan_per_bulan($tahun = null)
{
    if (!$tahun) {
        $tahun = date('Y');
    }

    $this->db->select('MONTH(pesanan.tanggal_pesanan) AS bulan, SUM(detail_pesanan.harga * detail_pesanan.jumlah) AS total');
    $this->db->from('detail_pesanan');
    $this->db->join('pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan');
    $this->db->where('status_pembayaran', 'diterima');
    $this->db->where('YEAR(pesanan.tanggal_pesanan)', $tahun);
    $this->db->group_by('MONTH(pesanan.tanggal_pesanan)');
    $this->db->order_by('MONTH(pesanan.tanggal_pesanan)', 'ASC');

    $query = $this->db->get();

    // Siapkan array default untuk 12 bulan
    $data = array_fill(1, 12, 0); // bulan 1-12 = 0

    foreach ($query->result() as $row) {
        $data[(int)$row->bulan] = (float)$row->total;
    }

    return $data;
}


    
public function get_total_pembayaran($id_pesanan)
{
    $this->db->select_sum('subtotal');  
    $this->db->where('id_pesanan', $id_pesanan);
    $query = $this->db->get('detail_pesanan');
    return $query->row()->subtotal;
}

public function sum_total_penjualan()
{
    $this->db->select('SUM(detail_pesanan.subtotal) AS total');
    $this->db->join('pesanan', 'pesanan.id_pesanan = detail_pesanan.id_pesanan');
    $this->db->where('pesanan.status_pesanan', 'Pesanan Selesai');
    $query = $this->db->get('detail_pesanan');
    return $query->row()->total ?? 0;
}

public function count_pesanan_hari_ini()
{
    $today = date('Y-m-d');
    $this->db->where('DATE(tanggal_pesanan)', $today);
    return $this->db->count_all_results('pesanan');
}

public function count_dibatalkan()
{
    $this->db->where('status_pesanan', 'dibatalkan');
    return $this->db->count_all_results('pesanan');
}

public function count_selesai()
{
    $this->db->where('status_pesanan', 'selesai');
    return $this->db->count_all_results('pesanan');
}

public function get_label_bulan()
{
    // ambil 6 bulan terakhir
    $bulan = [];
    for ($i = 5; $i >= 0; $i--) {
        $bulan[] = date('M Y', strtotime("-$i months"));
    }
    return $bulan;
}

public function get_data_penjualan()
{
     $data = [];

    for ($i = 5; $i >= 0; $i--) {
        $bulan = date('m', strtotime("-$i months"));
        $tahun = date('Y', strtotime("-$i months"));

        $this->db->select_sum('detail_pesanan.subtotal', 'total');
        $this->db->join('pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan');
        $this->db->where('MONTH(pesanan.tanggal_pesanan)', $bulan);
        $this->db->where('YEAR(pesanan.tanggal_pesanan)', $tahun);
        $this->db->where('pesanan.status_pembayaran', 'diterima');
        $query = $this->db->get('detail_pesanan');

        $total = $query->row()->total ?? 0;
        $data[] = (int)$total;
    }

    return $data;
}


public function sum_total_hari_ini()
{
    $today = date('Y-m-d');
    $this->db->select('SUM(detail_pesanan.subtotal) AS total');
    $this->db->from('detail_pesanan');
    $this->db->join('pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan');
    $this->db->where('DATE(pesanan.tanggal_pesanan)', $today);
    $this->db->where('pesanan.status_pembayaran', 'diterima');
    return $this->db->get()->row()->total ?? 0;
}

public function sum_total_bulan_ini()
{
    $this->db->select('SUM(detail_pesanan.subtotal) AS total');
    $this->db->from('detail_pesanan');
    $this->db->join('pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan');
    $this->db->where('MONTH(pesanan.tanggal_pesanan)', date('m'));
    $this->db->where('YEAR(pesanan.tanggal_pesanan)', date('Y'));
    $this->db->where('pesanan.status_pembayaran', 'diterima');
    return $this->db->get()->row()->total ?? 0;
}

public function get_notifikasi_baru()
{
    return $this->db
        ->where('status_pesanan !=', 'Pesanan Selesai')
        ->order_by('tanggal_pesanan', 'DESC')
        ->limit(5)
        ->get('pesanan')
        ->result();
}

public function get_penjualan_bulanan()
{
    $this->db->select("MONTH(tanggal_pesanan) as bulan, SUM(total_pembayaran) as total");
    $this->db->from('pesanan');
    $this->db->where('status', 'selesai');
    $this->db->group_by('bulan');
    $this->db->order_by('bulan');
    $query = $this->db->get();

    $labels = [];
    $data = [];

    foreach ($query->result() as $row) {
        $labels[] = date('M', mktime(0, 0, 0, $row->bulan, 10)); // "Jan", "Feb", ...
        $data[] = (int)$row->total;
    }

    return ['labels' => $labels, 'data' => $data];
}

}

?>