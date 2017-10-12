<?php
class Banner_model extends CI_Model{
    function create_banner($data){
        $this->load->database();
        $this->db->insert('tbl_banner',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_banner($where,$order_by){
        $this->load->database();
        $this->db->select("*");
        if($where!="")
        $this->db->where($where);
        if($order_by!="")
        $this->db->order_by($order_by);
        $this->db->from("tbl_banner");
        $query=$this->db->get();
        return $query;
    }
    function read_single_banner($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_banner");
        $query=$this->db->get();
        return $query;
    }
    function update_banner($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_banner',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_banner($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_banner');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>