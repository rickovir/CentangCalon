<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {	
	public $model = NULL;
	public function __construct(){
		parent::__construct();
		$this->model = $this->models_cencal;
	}
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
	
	public function index()
	{
		$q_acara = $this->models_cencal->select_order("acara","trash","N","id_acara","DESC");
		$q_user = $this->models_cencal->select("user");
		$q_follow = $this->models_cencal->select("userfollowacara");
		$data['r_user'] = $q_user->result();
		$data['r_acara'] = $q_acara->result();
		$data['r_follow'] = $q_follow->result();
		$this->link_to("home", $data);
	}
	
	public function add_event()
	{
		$this->link_to("add_event");
	}
	
	private function link_seo($text)
	{
		$text = strtolower($text);
		$text = explode(" ", $text);
		$res = implode("_",$text);
		return $res;
	}
	
	public function register($req = "")
	{	
		$data['req'] = $req;
		$this->link_to("register",$data);
	}
	
	public function login($req="")
	{
		$data["gagal"] =  false;
		$data["req"] = $req;
		$this->link_to("login",$data);
	}
	
	public function event($id)
	{
		$data['id_user'] = $id;
		$this->load->view('event',$data);
	}
	public function testck(){
		if($this->input->post("status-p") == "z")
			echo "ada";
	}
}
