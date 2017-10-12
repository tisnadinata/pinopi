<?php
class Bank_model extends CI_Model{
    function create_bank($data){
        $this->load->database();
        $this->db->insert('tbl_bank',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_bank($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_bank");
        $query=$this->db->get();
        return $query;
    }
    function read_single_bank($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_bank");
        $query=$this->db->get();
        return $query;
    }
    function update_bank($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_bank',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_bank($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_bank');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>