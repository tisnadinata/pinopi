<?php
class Pengaturan_model extends CI_Model{
    function create_pengaturan($data){
        $this->load->database();
        $this->db->insert('tbl_pengaturan',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_pengaturan($where){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        $this->db->from("tbl_pengaturan");
        $query=$this->db->get();
        return $query;
    }
    function read_single_pengaturan($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_pengaturan");
        $query=$this->db->get();
        return $query;
    }
    function update_pengaturan($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_pengaturan',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_pengaturan($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_pengaturan');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>