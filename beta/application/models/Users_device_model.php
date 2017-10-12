<?php
class Users_device_model extends CI_Model{
    function create_users_device($data){
        $this->load->database();
        $this->db->insert('tbl_users_device',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_users_device($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_users_device");
        $query=$this->db->get();
        return $query;
    }
    function read_single_users_device($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_users_device");
        $query=$this->db->get();
        return $query;
    }
    function update_users_device($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_users_device',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_users_device($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_users_device');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>