<?php
class Foto_model extends CI_Model{
    function create_foto($data){
        $this->load->database();
        $this->db->insert('tbl_foto',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_foto($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_foto");
        $query=$this->db->get();
        return $query;
    }
    function read_single_foto($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_foto");
        $query=$this->db->get();
        return $query;
    }
    function update_foto($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_foto',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_foto($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_foto');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>