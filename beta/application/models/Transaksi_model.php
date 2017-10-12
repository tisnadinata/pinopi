<?php
class Transaksi_model extends CI_Model{
    function create_transaksi($data){
        $this->load->database();
        $this->db->insert('tbl_transaksi',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_transaksi($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_transaksi");
        $query=$this->db->get();
        return $query;
    }
    function read_single_transaksi($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_transaksi");
        $query=$this->db->get();
        return $query;
    }
    function update_transaksi($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_transaksi',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_transaksi($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_transaksi');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>