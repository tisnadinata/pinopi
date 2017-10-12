<?php
class Produk_model extends CI_Model{
    function create_produk($data){
        $this->load->database();
        $this->db->insert('tbl_produk',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function read_produk($select,$join,$where, $order_by, $limit){
        $this->load->database();
      $sql="";
      if($select=="")
        $sql.="select *";
      else 
        $sql.="select ".$select;
        $sql.=" from tbl_produk as p ";
        if($join!="")
         $sql.=" join ".$join;
              if($where!="")
        $sql.=" where ".$where;
        if($order_by!="")
        $sql.=" order by ".$order_by;
        if($limit!="")
        $sql.="limit ".$limit;
        $query=$this->db->query($sql);
        return $query;
    }
    function read_single_produk($id){
        $this->load->database();
        $this->db->select("*");
        $this->db->where('id', $id);
        $this->db->from("tbl_produk");
        $query=$this->db->get();
        return $query;
    }
    function update_produk($data){
        $this->load->database();
        $this->db->where('id',$data['id']);
        $this->db->update('tbl_produk',$data);
        $flag=$this->db->affected_rows();
        return $flag;
    }
    function delete_produk($id){
        $this->load->database();
        $this->db->where('id',$id);
        $this->db->delete('tbl_produk');
        $flag=$this->db->affected_rows();
        return $flag;
    }
}
?>