<?php
class Transaksi_pembayaran_model extends CI_Model{
    function create_transaksi_pembayaran($data){
        $this->load->database();
        $this->db->insert('tbl_transaksi_pembayaran',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_transaksi_pembayaran($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_transaksi_pembayaran");
        $query=$this->db->get();
        return $query;
    }
    function read_single_transaksi_pembayaran($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_transaksi_pembayaran");
        $query=$this->db->get();
        return $query;
    }
    function update_transaksi_pembayaran($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_transaksi_pembayaran',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_transaksi_pembayaran($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_transaksi_pembayaran');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>