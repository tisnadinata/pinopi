<?php
class Users_bonus_model extends CI_Model{
    function create_users_bonus($data){
        $this->load->database();
        $this->db->insert('tbl_users_bonus',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_users_bonus($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_users_bonus");
        $query=$this->db->get();
        return $query;
    }
    function read_single_users_bonus($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_users_bonus");
        $query=$this->db->get();
        return $query;
    }
    function update_users_bonus($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_users_bonus',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_users_bonus($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_users_bonus');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>