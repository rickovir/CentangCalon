<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
	
	private function link_to($link , $data = array())
	{
		if(empty($_SESSION["logged_in"]))
		{
			$data["logged_in"] = FALSE;
		}
		else
		{
			$data["logged_in"] = TRUE;
			$data_notif = array(
				"receiver" => $_SESSION["id_user"],
				"status" => "unseen",
				"new"	=> "Y"
			);
			$notif = $this->models_cencal->select_arr("notification",$data_notif)->num_rows();
			$_SESSION["notif"] = $notif;
		}
		$this->template->load("template",$link,$data);
	}
	
	public function index($find = "front")
	{
		if($find == "front")
		{
			$q_acara = $this->models_cencal->select_order("acara","trash","N","id_acara","DESC");
			$data = array(
				'search' => false
			);
		}
		else if($find = "found")
		{
			$q_acara = $this->models_cencal->select("acara","trash","N","nama_acara",$this->input->post("search"), 0 , 8);
			$data = array(
				'num_acara' => $q_acara->num_rows(),
				'search' => true
			);
		}
		$q_user = $this->models_cencal->select("user");
		$q_follow = $this->models_cencal->select("userfollowacara");
		$data['r_user'] = $q_user->result();
		$data['r_acara'] = $q_acara->result();
		$data['r_follow'] = $q_follow->result();
		
		$this->link_to("search",$data);
	}
}