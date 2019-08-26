<?php
class Models_cencal extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	function select_arr($table,$where_data = array(),$order_col="", $type="", $limit_start = "", $limit_end = "")
	{
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where($where_data);
		$this->db->order_by($order_col, $type);
		if($limit_start !="" AND $limit_end !="")
			$this->db->limit($limit_start,$limit_end);
		return $this->db->get();
	}
	
	function insert($table,$data)
	{
		$this->db->insert($table,$data);
	}
	function select($table,$column = "",$where = "", $where_like = "", $like = "",$limit_start = "",$limit_end = "")
	{
		$this->db->select("*");
		$this->db->from($table);
		if($column != "")
			$this->db->where($column,$where);
		
		if($limit_start !="" AND $limit_end !="")
			$this->db->limit($limit_start,$limit_end);
		
		if($where_like !="")
			$this->db->like($where_like,$like);
		return $this->db->get();
	}
	function select_order($table,$column = "",$where="",$order_col="", $type="")
	{
		$this->db->select("*");
		$this->db->from($table);
		if($column != "")
			$this->db->where($column,$where);
		$this->db->order_by($order_col, $type);
		return $this->db->get();
	}
	
	function delete_arr($table,$data = array())
	{
		return $this->db->delete($table, $data);
	}
	
	function update_arr($table,$data = array(), $where_data = array())
	{
		return $this->db->update($table, $data, $where_data);
	}
	
	function delete($table,$column,$id)
	{
		$this->db->where($column,$id);
		$this->db->delete($table);
	}
	function update($table,$column,$id,$data)
	{
		$this->db->where($column,$id);
		$this->db->update($table,$data);
	}
}