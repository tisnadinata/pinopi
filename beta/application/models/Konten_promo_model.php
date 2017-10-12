<?php
class Konten_promo_model extends CI_Model{
    function create_konten_promo($data){
        $this->load->database();
        $this->db->insert('tbl_konten_promo',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_konten_promo($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_konten_promo");
        $query=$this->db->get();
        return $query;
    }
    function read_single_konten_promo($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_konten_promo");
        $query=$this->db->get();
        return $query;
    }
    function update_konten_promo($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_konten_promo',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_konten_promo($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_konten_promo');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>