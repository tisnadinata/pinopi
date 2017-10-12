<?php
class Users_model extends CI_Model{
    function create_users($data){
        $this->load->database();
        $this->db->insert('tbl_users',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_users($where,$order_by){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_users");
        if($order_by!="")
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
    function read_single_users($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_users");
        $query=$this->db->get();
        return $query;
    }
    function update_users($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_users',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_users($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_users');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>