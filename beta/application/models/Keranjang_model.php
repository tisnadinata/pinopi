<?php
class Keranjang_model extends CI_Model{
    function create_keranjang($data){
        $this->load->database();
        $this->db->insert('tbl_keranjang',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_keranjang($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_keranjang");
        $query=$this->db->get();
        return $query;
    }
    function read_single_keranjang($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_keranjang");
        $query=$this->db->get();
        return $query;
    }
    function update_keranjang($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_keranjang',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_keranjang($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_keranjang');
        $flag=$this->db->affected_rows();
        return $flag;
    }
  function custom_sql($sql){
    $this->load->database();
    return $this->db->query($sql);
  }
}
?>