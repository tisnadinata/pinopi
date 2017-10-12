<?php
class Auto_log_model extends CI_Model{
    function create_auto_log($data){
        $this->load->database();
        $this->db->insert('tbl_auto_log',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_auto_log($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_auto_log");
        $query=$this->db->get();
        return $query;
    }
    function read_single_auto_log($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_auto_log");
        $query=$this->db->get();
        return $query;
    }
    function update_auto_log($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_auto_log',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_auto_log($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_auto_log');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>