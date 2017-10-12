<?php
class Kategori_model extends CI_Model{
    function create_kategori($data){
        $this->load->database();
        $this->db->insert('tbl_kategori',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_kategori($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_kategori");
        $query=$this->db->get();
        return $query;
    }
    function read_single_kategori($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_kategori");
        $query=$this->db->get();
        return $query;
    }
    function update_kategori($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_kategori',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_kategori($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_kategori');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>