<?php
class Users_bank_model extends CI_Model{
    function create_users_bank($data){
        $this->load->database();
        $this->db->insert('tbl_users_bank',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_users_bank($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_users_bank");
        $query=$this->db->get();
        return $query;
    }
    function read_single_users_bank($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_users_bank");
        $query=$this->db->get();
        return $query;
    }
    function update_users_bank($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_users_bank',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_users_bank($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_users_bank');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>