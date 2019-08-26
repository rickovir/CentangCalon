<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();	
		$this->load->library('image_lib');
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
		if(!$_SESSION["logged_in"])
			redirect("main/login", 'refresh');
		$q_ses_user = $this->models_cencal->select("user", "id_user", $_SESSION['id_user']);
		$data_ses_acara = array(
			"id_user" 	=> $_SESSION["id_user"],
			"trash" 	=> "N"
		);
		$q_ses_acara = $this->models_cencal->select_arr("acara", $data_ses_acara);
		$q_acara = $this->models_cencal->select_order("acara","trash","N","id_acara","DESC");
		$q_follow = $this->models_cencal->select("userfollowacara","id_user",$_SESSION["id_user"]);
		$q_follow2 = $this->models_cencal->select("userfollowacara");
		$q_user = $this->models_cencal->select("user");
		
		$data = array(
			"r_user" 		=> $q_user->result(),
			"ses_user" 		=> $q_ses_user->row(),
			"num_ses_acara"	=> $q_ses_acara->num_rows(),
			"r_acara"		=> $q_acara->result(),
			"r_follow2"		=> $q_follow2->result(),
			"follow_acara"	=> $q_follow->num_rows(),
			"r_follow"		=> $q_follow->result()
		);
		$this->link_to("user_page",$data);
	}
	
	public function add_event()
	{
		$this->link_to("add_event");
	}
	
	private function make_session($sess_data = array())
	{
		$nm_pecah = explode(" ",$sess_data["nama_lengkap"]);
		
		$_SESSION = array(
			"id_user" => $sess_data["id_user"],
			"nama_lengkap" => $sess_data["nama_lengkap"],
			"nama_depan" => $nm_pecah[0],
			"avatar" => $sess_data["avatar"],
			"logged_in" => true
		);
	}
	
	private function make_acara_nl($id_user)
	{
		$data = array(
			'nama_acara' => ucwords($this->session->userdata('nama_acara')),
			'institusi' => $this->session->userdata('institusi'),
			'waktu_mulai' => $this->session->userdata('waktu_mulai'),
			'waktu_berakhir' => $this->session->userdata('waktu_berakhir'),
			'deskripsi' => $this->session->userdata('deskripsi'),
			'status' => $this->session->userdata('status'),
			'id_user' => $id_user
			);
		$sesi = array("nama_acara", "institusi", "waktu_mulai", "waktu_berakhir","deskripsi", "status");
		$this->session->unset_userdata($sesi);
		$this->models_cencal->insert('acara',$data);
	}
	
	public function do_login($req = "")
	{	
		if(empty($req))
			$req = "";
		$email = $this->input->post("email");
		$password = md5($this->input->post("password"));
		$q_log = $this->models_cencal->select("user","email",$email);
		if($q_log->num_rows() > 0)
		{
			$arr_row = $q_log->row_array();
			$row = $q_log->row();
			if(password_verify($password,$row->password))
			{
				$this->event_date_check($arr_row['id_user']);
				if($req == "acara")
				{
					$this->make_acara_nl($arr_row['id_user']);
					$this->make_session($arr_row);	
					redirect("event/my_event", 'refresh');
				}
				else if($req == "")
				{
					$this->make_session($arr_row);
					redirect("user", 'refresh');
				}
				else
				{
					$req = str_replace("-","/",$req);
					$this->make_session($arr_row);
					redirect($req, 'refresh');	
				}
			}
			else
			{
				$data["req"] = $req;
				$data['gagal'] = true;
				$this->link_to("login",$data);				
			}
		}
		else
		{
			$data["req"] = $req;
			$data['gagal'] = true;
			$this->link_to("login",$data);
		}
	}
	
	public function do_fb_login($provider, $req = "")
	{
		log_message('debug', "controllers.HAuth.login($provider) called");

		try
		{
			log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');;
			$this->load->library('HybridAuthLib');

			if ($this->hybridauthlib->providerEnabled($provider))
			{
				log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->hybridauthlib->authenticate($provider);

				if ($service->isUserConnected())
				{
					log_message('debug', 'controller.HAuth.login: user authenticated.');

					$user_profile = $service->getUserProfile();

					log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));
					// get fb user from database
					$this->get_fb_user($user_profile->identifier,$user_profile->displayName,$req);
				}
				else // Cannot authenticate user
				{
					show_error('Cannot authenticate user');
				}
			}
			else // This service is not enabled.
			{
				log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				show_404($_SERVER['REQUEST_URI']);
			}
		}
		catch(Exception $e)
		{
			$error = 'Unexpected error';
			switch($e->getCode())
			{
				case 0 : $error = 'Unspecified error.'; break;
				case 1 : $error = 'Hybriauth configuration error.'; break;
				case 2 : $error = 'Provider not properly configured.'; break;
				case 3 : $error = 'Unknown or disabled provider.'; break;
				case 4 : $error = 'Missing provider application credentials.'; break;
				case 5 : log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
				         //redirect();
				         if (isset($service))
				         {
				         	log_message('debug', 'controllers.HAuth.login: logging out from service.');
				         	$service->logout();
				         }
				         show_error('User has cancelled the authentication or the provider refused the connection.');
				         break;
				case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
				         break;
				case 7 : $error = 'User not connected to the provider.';
				         break;
			}

			if (isset($service))
			{
				$service->logout();
			}

			log_message('error', 'controllers.HAuth.login: '.$error);
			show_error('Error authenticating user.');
		}
	}
	
	public function get_fb_user($id, $name, $req = "")
	{
		$fb_result = $this->models_cencal->select("user","fb_id",$id);
		if($fb_result->num_rows()>0)
		{
			$arr_row = $fb_result->row_array();
			$this->event_date_check($arr_row['id_user']);
			if($req == "acara")
			{
				$this->make_acara_nl($arr_row['id_user']);
				$this->make_session($arr_row);
				redirect("event/my_event", 'refresh');
			}
			else if($req == "")
			{
				$this->make_session($arr_row);
				redirect("user", 'refresh');
			}
			else
			{
				$req = str_replace("-","/",$req);
				$this->make_session($arr_row);
				redirect($req, 'refresh');	
			}
		}
		else
		{
			$data = array(
				"nama_lengkap" => $name,
				"fb_user" => 'Y',
				"fb_id" => $id
				);
			$this->models_cencal->insert("user",$data);
			$this->get_fb_user($id,$name);
		}
	}
	
	public function endpoint()
	{

		log_message('debug', 'controllers.HAuth.endpoint called.');
		log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}

		log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH.'/third_party/hybridauth/index.php';

	}
	
	public function do_register($req = "")
	{
		$password = md5($this->input->post("password"));
		$data = array(
						"nama_lengkap" => ucwords($this->input->post("nama_lengkap")),
						"email" => $this->input->post("email"),
						"password" => password_hash($password,PASSWORD_DEFAULT),
						"fb_user" => 'N'
					);
		$this->models_cencal->insert("user",$data);
		
		$q_signup = $this->models_cencal->select("user","email",$this->input->post("email"));
		$arr_row = $q_signup->row_array();
		if($req == "acara")
		{
			$this->make_acara_nl($arr_row['id_user']);
			$this->make_session($arr_row);
			redirect("event/my_event", 'refresh');
		}
		else if($req == "")
		{
			$this->make_session($arr_row);
			redirect("user", 'refresh');
		}
		else
		{
			$req = str_replace("-","/",$req);
			$this->make_session($arr_row);
			redirect($req, 'refresh');	
		}
	}

	public function do_add_event()
	{
		$data = array(
				'nama_acara' => $this->input->post('nama_acara'),
				//'nama_link' => $this->link_seo($this->input->post('nama_	')),
				'institusi' => $this->input->post('institusi'),
				'waktu_mulai' => $this->input->post('waktu_mulai'),
				'waktu_berakhir' => $this->input->post('waktu_berakhir'),
				'deskripsi' => $this->input->post('deskripsi'),
				'status' => 'public'
			 );
		if($this->session->userdata('logged_in'))
		{
			$data['id_user'] = $_SESSION['id_user'];
			$this->models_cencal->insert('acara',$data);
			redirect("event/my_event", 'refresh');
		}
		else
		{
			$this->session->set_userdata($data);
			redirect("main/register/acara", 'refresh');
		}
	}
	
	private function event_date_check($id_user)
	{	
		$now = date("Y-m-d");
		$ea_data = array(
			"id_user"	=> $id_user,
			"trash"		=> "N"
		);
		$q_acara = $this->models_cencal->select_arr("acara", $ea_data);
		foreach($q_acara->result() as $arow)
		{
			if(strtotime($arow->waktu_berakhir) <= strtotime($now))
			{
				$data_notif = array(
					"id_acara"	=> $arow->id_acara,
					"type"		=> "event_end_date",
					"receiver"	=> $id_user,
					"sender"	=> $id_user,
					"note"		=> "Acara Telah Berakhir"
				);
				$n = $this->models_cencal->select_arr("notification",$data_notif)->num_rows();
				if($n == 0)
				{
					$this->models_cencal->insert("notification", $data_notif);
					$up_data["expired"] = "Y";
					$this->models_cencal->update("acara","id_acara",$arow->id_acara,$up_data);
					$q_usfol = $this->models_cencal->select("userfollowacara", "id_acara", $arow->id_acara);
					foreach($q_usfol->result() as $rusfol)
					{
						$data_notif = array(
							"id_acara"	=> $arow->id_acara,
							"type"		=> "event_follow_end_date",
							"receiver"	=> $rusfol->id_user,
							"sender"	=> $id_user,
							"note"		=> "Acara Yang Diikuti Telah Berakhir"
						);
						$n_u = $this->models_cencal->select_arr("notification",$data_notif)->num_rows();
						if($n_u == 0)
						{
							$this->models_cencal->insert("notification", $data_notif);
						}
					}
				}
			}
		}
	}
	
	public function notification_check($type,$ck)
	{
		$data_notif = array();
		if($type == "wc")
		{
			$data_notif = array(
				"receiver"	=> $_SESSION["id_user"],
				"status"	=> "unseen"
			);
		}
		else
		{
			$data_notif = array(
				"receiver"	=> $_SESSION["id_user"],
				"status"	=> "unseen",
				"new"	=> "Y"
			);
		}
		$q_notif = $this->models_cencal->select_arr("notification",$data_notif,"id_notification","DESC",0,5);
		$data = array();
		foreach($q_notif->result() as $n_row)
		{
			$whacara_data = array(
				"id_acara"	=> $n_row->id_acara,
				"trash"		=> "N"
			);
			$q_acara = $this->models_cencal->select_arr("acara",$whacara_data);
			if($q_acara->num_rows() !=0)
			{
				$r_acara = $q_acara->row();
				$user	 = $this->models_cencal->select("user", "id_user", $n_row->sender)->row();
				$data["id_acara"][]		= $r_acara->id_acara;
				$data["nama_acara"][]		= $r_acara->nama_acara;
				$data["nama_link"][]		= $r_acara->nama_link;
				$data["image"][]			= $r_acara->image;
				$data["sender"][]			= $user->id_user;
				$data["receiver"][]			= $n_row->receiver;
				$data["sender_name"][]	= "";
				if($_SESSION["id_user"] != $user->id_user)
					$data["sender_name"][]	= $user->nama_lengkap;
				
				if($n_row->type == "event_follow_end_date")
					$data["sender_name"][]	= "";
				
				$data["id_notification"][]= $n_row->id_notification;
				$data["type"][]			= $n_row->type;
				$data["note"][]			= $n_row->note;
				$data["status"][]		= $n_row->status;
				
				if($ck == "Y")
				{
					$data_update = array(
						"new" => "N",
					);
					$where_update = array(
						"receiver"	=> $_SESSION["id_user"],
						"status"	=> "unseen",
						"id_acara"	=> $n_row->id_acara
					);
					$this->models_cencal->update_arr("notification",$data_update, $where_update);
				}
			}
		}
		$data["num"] = $q_notif->num_rows();
		echo json_encode($data);
	}
	
	public function edit_profile()
	{
		$q_user = $this->models_cencal->select("user", "id_user", $_SESSION["id_user"]);
		$data["user"] = $q_user->row();
		$this->link_to("edit_profile.php", $data);
	}
	
	public function do_edit_profile($tmpavatar)
	{
		// semua data di jadikan array
		$data = array(
			"nama_lengkap"	=> $this->input->post("nama_lengkap"),
			"email" 		=> $this->input->post("email"),
			"moto"			=> $this->input->post("moto"),
		);
		
		$password = $this->input->post("password");
		$re_password = $this->input->post("re_password");
		if($password != "")
		{
			$data["password"] = password_hash(md5($password),PASSWORD_DEFAULT);
		}
		 // jika file tidak kosong maka
		if($_FILES['avatar']['name'] != "")
		{
			// menset konfigurasi dari upload yg akan dilakukan
			$config	= array(
				'upload_path'		=> './uploads/user/',
				'allowed_types'		=> 'gif|jpg|png',
				'max_size'			=> 0,
				'max_width'			=> 0,
			//  'file_name'  		=> "sss",
				'max_height'     	=> 0
			);
			// memanggil library upload dan konfigurasinya
			$this->load->library('upload', $config);
			// jika upload dilakukan gagal
			if ( !$this->upload->do_upload('avatar'))
			{
				echo "error_upload";
			}
			else // lain jika tidak gagal
			{
				// menset nilai elemet array foto dari nama foto yg diupload
				$data["avatar"] = $this->upload->data('file_name');
				// meresize gambar
				$this->resize_image($data['avatar']);
				
				// operasi update
				$this->models_cencal->update('user',"id_user", $_SESSION["id_user"], $data);
				
				// jika bukan foto default
				if($tmpavatar != "default-user.png")
					unlink("./uploads/user/".$tmpavatar); // hapus foto dari directory
				echo "success";
			}
		}
		else // lain jika fotonya kosong
		{
			// operasi update
			$this->models_cencal->update('user',"id_user", $_SESSION["id_user"], $data);
			echo "success";
		}
	}
	
	public function user_detail($id_user)
	{
		$q_user = $this->models_cencal->select("user", "id_user", $id_user);
		$q_userall = $this->models_cencal->select("user");
		$data["user"] = $q_user->row();
		$q_acara = $this->models_cencal->select("acara", "id_user", $id_user);
		$q_follow = $this->models_cencal->select("userfollowacara");
		$data["num_acara_user"] = $q_acara->num_rows();
		$data["r_follow"] = $q_follow->result();
		$data["r_user"] = $q_follow->result();
		$data["res_acara"] = $q_acara->result();
		$this->link_to("detail_user", $data);
	}
	
	private function resize_image($filename){
		$config['image_library'] = 'gd2';
		$config['source_image'] = './uploads/user/'.$filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width']     = 400;
		$config['height']   = 300;
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize())
			$this->image_lib->display_errors();
		$this->image_lib->clear();
	}
	
	public function notifications()
	{
		$data_notif = array(
			"receiver"	=> $_SESSION["id_user"]
		);
		$q_notif = $this->models_cencal->select_arr("notification",$data_notif,"id_notification","DESC",0,5);
		$q_acara = $this->models_cencal->select("acara");
		$q_user = $this->models_cencal->select("user");
		$data["notification"] = $q_notif->result();
		$data["acara"] = $q_acara->result();
		$data["user"] = $q_user->result();
		$this->link_to("notifications",$data);
	}
	
	public function logout()
	{
		//session_destroy();
		$array_ses = array("id_user", "nama_lengkap", "nama_depan", "avatar", "logged_in");
		$this->session->unset_userdata($array_ses);
		redirect("/", 'refresh');
	}
	/* 
	public function dbase64($imagedata)
	{
		//$path = "./assets/img/avatar.png";
		//$imagedata = file_get_contents($path);
             // alternatively specify an URL, if PHP settings allow
		$base64 = base64_encode($imagedata);
		echo $base64."<br />";
		//echo "<img src='data:image/png;base64,".$base64."' /><br />";
	}
	 */
	
	public function hashpass($kata)
	{
		$hasha = password_hash($kata,PASSWORD_DEFAULT);
		echo $hasha;
		// if(password_verify($kata, $hasha)){
			// echo"bisa";
			// echo"\n".$hasha;
		// }else
			// echo"gagal";
	}
}