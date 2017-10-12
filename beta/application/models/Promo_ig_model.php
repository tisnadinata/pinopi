<?php
class Promo_ig_model extends CI_Model{
    function create_promo_ig($data){
        $this->load->database();
        $this->db->insert('tbl_promo_ig',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_promo_ig($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_promo_ig");
        $query=$this->db->get();
        return $query;
    }
    function read_single_promo_ig($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_promo_ig");
        $query=$this->db->get();
        return $query;
    }
    function update_promo_ig($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_promo_ig',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_promo_ig($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_promo_ig');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>