<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {
	
	private function link_to($link , $data = array())
	{
		if(empty($_SESSION["logged_in"]))
		{
			$data["logged_in"] = FALSE;
		}
		else
		{
			$data["logged_in"] = TRUE;
		}
		$this->template->load("template",$link,$data);
	}
	
	public function index()
	{
		$this->link_to("about");
	}
}