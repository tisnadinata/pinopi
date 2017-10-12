<?php
class Diskon_model extends CI_Model{
    function create_diskon($data){
        $this->load->database();
        $this->db->insert('tbl_diskon',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_diskon($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_diskon");
        $query=$this->db->get();
        return $query;
    }
    function read_single_diskon($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_diskon");
        $query=$this->db->get();
        return $query;
    }
    function update_diskon($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_diskon',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_diskon($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_diskon');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>