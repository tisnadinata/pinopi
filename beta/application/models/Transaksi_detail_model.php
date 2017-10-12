<?php
class Transaksi_detail_model extends CI_Model{
    function create_transaksi_detail($data){
        $this->load->database();
        $this->db->insert('tbl_transaksi_detail',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_transaksi_detail($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_transaksi_detail");
        $query=$this->db->get();
        return $query;
    }
    function read_single_transaksi_detail($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_transaksi_detail");
        $query=$this->db->get();
        return $query;
    }
    function update_transaksi_detail($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_transaksi_detail',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_transaksi_detail($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_transaksi_detail');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>