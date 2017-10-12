<?php
class Kupon_model extends CI_Model{
    function create_kupon($data){
        $this->load->database();
        $this->db->insert('tbl_kupon',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_kupon($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_kupon");
        $query=$this->db->get();
        return $query;
    }
    function read_single_kupon($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_kupon");
        $query=$this->db->get();
        return $query;
    }
    function update_kupon($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_kupon',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_kupon($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_kupon');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>