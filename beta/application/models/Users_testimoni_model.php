<?php
class Users_testimoni_model extends CI_Model{
    function create_users_testimoni($data){
        $this->load->database();
        $this->db->insert('tbl_users_testimoni',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_users_testimoni($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_users_testimoni");
        $this->db->limit(1);
        $query=$this->db->get();
        return $query;
    }
    function read_single_users_testimoni($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_users_testimoni");
        $query=$this->db->get();
        return $query;
    }
    function update_users_testimoni($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_users_testimoni',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_users_testimoni($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_users_testimoni');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>