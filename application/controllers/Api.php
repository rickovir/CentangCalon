<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller{
	public $model = NULL;
	public function __construct(){
		parent::__construct();
		$this->model = $this->models_cencal;
	}

	public function getAcara($detail="all")
	{
		if($detail == "all")
			$r_acara = $this->db->query("select * from acara order by id_acara DESC")->result();
		else
			$r_acara = $this->db->query("select * from acara where id_acara='".$detail."'")->result();

		echo json_encode($r_acara);
	}

	public function deleteAcara()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$test =$this->input->post('id_acara');
		$return="";
		if($this->db->simple_query("update acara set trash = 'Y' where id_acara ='".$test."'"))
			$return = "success";
		else
			$return = "gagal";

		echo json_encode(array("hasil"=>$return));
	}

	public function restoreAcara()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$test =$this->input->post('id_acara');
		$return="";
		if($this->db->simple_query("update acara set trash = 'N' where id_acara ='".$test."'"))
			$return = "success";
		else
			$return = "gagal";

		echo json_encode(array("hasil"=>$return));
	}

	public function jmkpSearch()
	{
		header("Access-Control-Allow-Origin: *");
		$query =$_GET['query'];
		$row = $this->db->query("select * from jmkp_skema where nama like '%".$query."%'")->result();

		echo json_encode($row);
	}
}