<?php
class Berita_model extends CI_Model{
    function create_berita($data){
        $this->load->database();
        $this->db->insert('tbl_berita',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_berita($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_berita");
        $query=$this->db->get();
        return $query;
    }
    function read_single_berita($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_berita");
        $query=$this->db->get();
        return $query;
    }
    function update_berita($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_berita',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_berita($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_berita');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>