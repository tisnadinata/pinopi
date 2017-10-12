<?php
class Promo_tw_model extends CI_Model{
    function create_promo_tw($data){
        $this->load->database();
        $this->db->insert('tbl_promo_tw',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_promo_tw($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_promo_tw");
        $query=$this->db->get();
        return $query;
    }
    function read_single_promo_tw($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_promo_tw");
        $query=$this->db->get();
        return $query;
    }
    function update_promo_tw($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_promo_tw',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_promo_tw($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_promo_tw');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>