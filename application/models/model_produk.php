<?php
    class Model_produk extends CI_Model{
    public function tampil_data() {
    $this->db->select('produk.*, kategori.nama_kategori');
    $this->db->from('produk');
    $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
    return $this->db->get()->result();
}

// --- FUNGSI UNTUK PAGINATION ---
    public function count_all_produk($search = null)
{
    $this->db->select('produk.id_produk');
    $this->db->from('produk');
    $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('produk.nama_produk', $search);
        $this->db->or_like('kategori.nama_kategori', $search); // Opsional
        $this->db->group_end();
    }

    return $this->db->count_all_results();
}


    public function get_produk_paginated($limit, $start, $search = null)
{
    $this->db->select('produk.*, kategori.nama_kategori');
    $this->db->from('produk');
    $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('produk.nama_produk', $search);
        $this->db->or_like('kategori.nama_kategori', $search); // Opsional
        $this->db->group_end();
    }

    $this->db->limit($limit, $start);
    return $this->db->get()->result();
}

    // --- AKHIR FUNGSI UNTUK PAGINATION ---

        public function tambah_produk($data, $table){
            $this->db->insert($table, $data);
        }
        
        public function edit_barang($where, $table){
            return $this->db->get_where($table, $where);
        }
        public function update_data($where, $data , $table){
            $this->db->where($where);
            $this->db->update($table, $data);
        }
        public function update_produk($id_produk, $data)
        {
            $this->db->where('id_produk', $id_produk);
            return $this->db->update('produk', $data);
    }

        public function hapus_data($where, $table)
        {
            $this->db->where($where);
            $this->db->delete($table);
        }
        public function find($id){
            $result = $this->db->where('id_produk', $id)
                            ->limit(1)
                            ->get('produk');
            if($result->num_rows()>0){
                return $result->row();
            }else{
                return array();
            }
        }
        public function get_all_kategori() {
        return $this->db->get('kategori')->result();
        }

        public function insert_produk($data) {
        return $this->db->insert('produk', $data);
    }

    public function hapus_produk($id)
{
    $this->db->where('id_produk', $id);
    $this->db->delete('produk');
}
    public function get_by_id($id)
{
    return $this->db->get_where('produk', ['id_produk' => $id])->row(); // return objek
}

public function count_produk()
{
    return $this->db->count_all('produk');
}


public function get_produk_terlaris_nama()
{
    $this->db->select('produk.nama_produk');
    $this->db->from('produk');
    $this->db->join('detail_pesanan', 'produk.id_produk = detail_pesanan.id_produk');
    $this->db->group_by('produk.nama_produk');
    $this->db->order_by('SUM(detail_pesanan.jumlah)', 'DESC');
    $this->db->limit(5);
    $query = $this->db->get();
    
    $result = $query->result();
    return array_column($result, 'nama_produk');
}

public function get_produk_terlaris_jumlah()
{
    $this->db->select('SUM(detail_pesanan.jumlah) as total');
    $this->db->from('produk');
    $this->db->join('detail_pesanan', 'produk.id_produk = detail_pesanan.id_produk');
    $this->db->group_by('produk.nama_produk');
    $this->db->order_by('total', 'DESC');
    $this->db->limit(5);
    $query = $this->db->get();

    $result = $query->result();
    return array_column($result, 'total');
}

public function get_all()
{
    return $this->db->get('produk')->result();
}

public function get_produk_by_id($id)
{
    return $this->db->get_where('produk', ['id_produk' => $id])->row();
}



    }
?>