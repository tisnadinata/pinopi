<?php
class Promo_fb_model extends CI_Model{
    function create_promo_fb($data){
        $this->load->database();
        $this->db->insert('tbl_promo_fb',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_promo_fb($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_promo_fb");
        $query=$this->db->get();
        return $query;
    }
    function read_single_promo_fb($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_promo_fb");
        $query=$this->db->get();
        return $query;
    }
    function update_promo_fb($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_promo_fb',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_promo_fb($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_promo_fb');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>