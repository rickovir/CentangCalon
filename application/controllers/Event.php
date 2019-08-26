<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('tanggal_indo_helper');
		$this->load->library('image_lib'); 
	}	
	// fungsi untuk link template. link_to mempassing data link =  nama view , data = data array
	private function link_to($link , $data = array())
	{
		// jika sesi login tidak ada
		if(empty($_SESSION["logged_in"]))
		{
			// data login di template false
			$data["logged_in"] = FALSE;
		}
		else
		{
			// data login di template true
			$data["logged_in"] = TRUE;
			// where dataarray query yang akan di cari untuk data notifikasi
			$data_notif = array(
				"receiver" => $_SESSION["id_user"],
				"status" => "unseen",
				"new"	=> "Y"
			);
			// menampilkan banyak baris dari query notification
			$notif = $this->models_cencal->select_arr("notification",$data_notif)->num_rows();
			// menaruh banyak notifikasi di sesi
			$_SESSION["notif"] = $notif;
		}
		// load data template dan view
		$this->template->load("template",$link,$data);
	}
	// fungsi saat centancalon.com/event/ dibuka
	public function index()
	{
		// q_acara menampung dari query acara
		$q_acara = $this->models_cencal->select("acara");
		// q_user menampung dari query user
		$q_user = $this->models_cencal->select("user");
		// q_follow menampung dari query userfollowacara
		$q_follow = $this->models_cencal->select("userfollowacara");
		// data yang akan ditampilkan ditampilkan di view
		$data = array(
			'r_user' => $q_user->result(),
			'r_acara' => $q_acara->result(),
			'r_follow' => $q_follow->result()
		);
		// melempar data ke funsi link_to
		$this->link_to("event",$data);
	}
	// fungsi menampilkan halaman my_event
	public function my_event($operasi= "")
	{
		// jika sesi logged_in kosong maka di direct ke halaman register
		if(empty($_SESSION["logged_in"]))
			redirect("main/register", 'refresh');
		// where data yg akan ditampilkan dengan id_user = sesi id_user dan tidak ditrash
		$arr = array(
			"id_user" => $_SESSION["id_user"],
			"trash"   => "N"
		);
		// q_acara menampung query acara dengan where data array urut desc berdasarkan id_acara
		$q_acara = $this->models_cencal->select_arr("acara",$arr,"id_acara","DESC");
		// q_user menampung dari query user
		$q_user = $this->models_cencal->select("user");
		// q_follow menampung dari query userfollowacara
		$q_follow = $this->models_cencal->select("userfollowacara");
		// menampilkan data yang akan di tampilkan di view
		$data = array(
			'r_user' => $q_user->result(),
			'r_acara' => $q_acara->result(),
			'r_follow' => $q_follow->result(),
			'operasi' => $operasi
		);
		// melempar data ke fungsi link_to
		$this->link_to("my_event",$data);
	}
	/*
	halaman detail event, passing data "id"
	*/
	public function detail($id,$nama_seo="")
	{	
		if(empty($_SESSION["logged_in"]))
			redirect("main/register/event-detail-".$id."-".$nama_seo, 'refresh');
		
		// mengambil data userfollowacara dari data passing, where id_acara = "id"
		$q_follow = $this->models_cencal->select("userfollowacara", "id_acara", $id);
		
		// mengambil data userfollowkandidat dari data passing, where id_acara = "id"
		$vk_data = array(
			"id_acara"	=> $id,
			"id_user"	=> $_SESSION["id_user"]
		);
		$q_votekand = $this->models_cencal->select("uservotekandidat",$vk_data);
		
		// mengambil data acara dari data passing, where id_acara = "id"
		$q_acara = $this->models_cencal->select("acara", "id_acara", $id);
		
		// mengambil data user dari dari sesi, where id_user = "session[id_user]"
		$q_user = $this->models_cencal->select("user", "id_user", $q_acara->row()->id_user);
		
		// mengambil data kandidat dari passing where id_acara = "id"
		$q_kandidat = $this->models_cencal->select("kandidat", "id_acara",$id);
		
		// menset var data sebagai variabel array 
		$data = array(
			// semua data dari query di jadikan array object di halaman view
			"event" 			=> $q_acara->row(),
			"follower" 			=> $q_follow->num_rows(),
			"userfollowacara"	=> $q_follow->result(),
			"uservotekandidat"	=> $q_votekand->row(),
			"num_vote"			=> $q_votekand->num_rows(),
			"user" 				=> $q_user->row(),
			"res_kandidat" 		=> $q_kandidat->result(),
			"num_kandidat" 		=> $q_kandidat->num_rows()
		);
		if($q_acara->row()->expired == "Y")
		{
			$this->link_to("expired_event", $data);
		}
		else
		{
			// panggil modul link_to
			$this->link_to("detail_event", $data);
		}
	}
	/*
	halaman update event, passing data "id"
	*/
	public function update($id)
	{
		if(empty($_SESSION["logged_in"]))
			redirect("main/register", 'refresh');
		
		// mengambil data acara dari data passing, where id_acara = "id"
		$q_acara = $this->models_cencal->select("acara", "id_acara", $id);
		$q_kandidat = $this->models_cencal->select("kandidat", "id_acara", $id);
		
		// menset var data sebagai variabel array 
		$data = array(
			// semua data dari query di jadikan array object di halaman view
			"event" => $q_acara->row(),
			// semua data dari query di jadikan object
			"result_kandidat" => $q_kandidat->result()
		);
		$this->link_to("update_event", $data);
	}
	
	/*
	proses add kandidat, passing data "id_acara"
	*/
	public function add_kandidat($id)
	{	
		//query kandidat
		$kandidat = $this->models_cencal->select("kandidat", "id_acara", $id)->result();
		$no_urut = 0;
		// mencari nomor urut maksimal
		foreach($kandidat as $row)
		{
			if($row->no_urut > $no_urut)
				$no_urut = $row->no_urut;
		}
		// semua data di jadikan array
		$data = array(
			"nama_kandidat" => $this->input->post("nama_kandidat"),
			"tempat_lahir" => $this->input->post("tempat_lahir"),
			"tanggal_lahir" => $this->input->post("tanggal_lahir"),
			"visi" => $this->input->post("visi"),
			"misi" => $this->input->post("misi"),
			"id_acara" => $id,
			"no_urut" => ($no_urut+1)
		);
		// cek file kosong atau tidak
		if($_FILES['foto']['name'] != "")
		{
			// menset konfigurasi dari upload yg akan dilakukan
			$config	= array(
				'upload_path'		=> './uploads/',
				'allowed_types'		=> 'gif|jpg|png',
				'max_size'			=> 0,
				'max_width'			=> 0,
			//  'file_name'  		=> "sss",
				'max_height'     	=> 0
			);
			// memanggil library upload dan konfigurasinya
			$this->load->library('upload', $config);
			// jika upload dilakukan gagal
			if ( ! $this->upload->do_upload('foto'))
			{
				$data['success'] = 0;// nilai kembali untuk ajax 0 success = false
				echo json_encode($data);
			}
			else // lain jika tidak gagal
			{
				// menset nilai elemet array foto dari nama foto yg diupload
				$data["foto"] = $this->upload->data('file_name');
				
				// meresize gambar
				$this->resize_image($data['foto']);
				
				// operasi insert
				$this->models_cencal->insert('kandidat',$data);
				
				// artinya sukses is true
				$data['success'] = 1;
				
				// dicetak atau dikembalikan dalam bentuk json
				echo json_encode($data);
			}
		} // lain jika
		else
		{
			// jika fotonya kosong maka data foto akan diisi dengan foto default
			$data["foto"] = "default-user.png";
			$this->models_cencal->insert('kandidat',$data);
			$data['success'] = 1;// nilai kembali untuk ajax 1 success = true
			echo json_encode($data);
		}
	}
	
	/*
	proses delete kandidat, passing data id_acara, no_urut, foto
	*/
	public function delete_kandidat($id_acara, $no_urut, $foto)
	{
		// mengumpulkan data patokan(where) menjadi array
		$data = array(
			"id_acara" => $id_acara,
			"no_urut"  => $no_urut
		);
		// jika delete bernilai false maka
		if($this->models_cencal->delete_arr("kandidat",$data) == false)
			echo 0; // nilai kembali untuk ajax
		else
		{
			// jika tidak sama foto sama dengan default foto maka
			if($foto != "default-user.png")
				unlink("./uploads/".$foto); // menghapus foto dari directory
			echo 1;// nilai kembali untuk ajax
		}
	}
	/*
	proses update kandidat, passing data id_acara, no_urut, foto
	*/
	public function update_kandidat($id_acara, $no_urut, $foto)
	{
		// semua data di jadikan array
		$data = array(
			"nama_kandidat" => $this->input->post("nama_kandidat"),
			"tempat_lahir" => $this->input->post("tempat_lahir"),
			"tanggal_lahir" => $this->input->post("tanggal_lahir"),
			"visi" => $this->input->post("visi"),
			"misi" => $this->input->post("misi")
		);
		
		// where data (data patokan untuk di set update)
		$where_data = array(
			"id_acara" => $id_acara,
			"no_urut"  => $no_urut
		);
		
		 // jika file tidak kosong maka
		if($_FILES['foto']['name'] != "")
		{
			// menset konfigurasi dari upload yg akan dilakukan
			$config	= array(
				'upload_path'		=> './uploads/',
				'allowed_types'		=> 'gif|jpg|png',
				'max_size'			=> 0,
				'max_width'			=> 0,
			//  'file_name'  		=> "sss",
				'max_height'     	=> 0
			);
			// memanggil library upload dan konfigurasinya
			$this->load->library('upload', $config);
			// jika upload dilakukan gagal
			if ( ! $this->upload->do_upload('foto'))
			{
				$data['success'] = 0;// nilai kembali untuk ajax 0 success = false
				echo json_encode($data);
			}
			else // lain jika tidak gagal
			{
				// menset nilai elemet array foto dari nama foto yg diupload
				$data["foto"] = $this->upload->data('file_name');
				
				// meresize gambar
				$this->resize_image($data['foto']);
				
				// operasi update
				$this->models_cencal->update_arr('kandidat',$data,$where_data);
				
				// jika bukan foto default
				if($foto != "default-user.png")
					unlink("./uploads/".$foto); // hapus foto dari directory
				
				$data['success'] = 1;// artinya sukses is true
				
				// dicetak atau dikembalikan dalam bentuk json
				echo json_encode($data);
			}
		}
		else // lain jika fotonya kosong
		{	
			// operasi update
			$this->models_cencal->update_arr('kandidat',$data,$where_data);
			
			// mengisi kembali foto yg tidak diupdate
			$data["foto"] = $foto;
			
			$data['success'] = 1;// nilai kembali untuk ajax 1 success = true
			echo json_encode($data);
		}
	}
	// fungsi private resize_image passing data filename
	private function resize_image($filename){
		// konfigurasi untuk library image
		$config['image_library'] = 'gd2';
		$config['source_image'] = './uploads/'.$filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width']     = 400;
		$config['height']   = 300;
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize())
			$this->image_lib->display_errors();
		$this->image_lib->clear();
	}
	
	/*
	proses add event
	*/
	public function do_add()
	{
		$data = array(
				'nama_acara' => $this->input->post('nama_acara'),
				'nama_link' => $this->link_seo($this->input->post('nama_	')),
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
	
	/*
	proses update event
	*/
	public function do_update($id_acara, $image)
	{
		$status = $this->input->post('status-p');
		if($status != "public")
			$status = "private";
		$data = array(
				'nama_acara' => $this->input->post('nama_acara'),
				'nama_link' => $this->link_seo($this->input->post('nama_acara')),
				'institusi' => $this->input->post('institusi'),
				'waktu_mulai' => $this->input->post('waktu_mulai'),
				'waktu_berakhir' => $this->input->post('waktu_berakhir'),
				'deskripsi' => $this->input->post('deskripsi'),
				'status' => $status
		);
		// jika file tidak kosong maka
		if($_FILES['image']['name'] != "")
		{
			// menset konfigurasi dari upload yg akan dilakukan
			$config	= array(
				'upload_path'		=> './uploads/',
				'allowed_types'		=> 'gif|jpg|png',
				'max_size'			=> 0,
				'max_width'			=> 0,
			//  'file_name'  		=> "sss",
				'max_height'     	=> 0
			);
			// memanggil library upload dan konfigurasinya
			$this->load->library('upload', $config);
			// jika upload dilakukan gagal
			if ( ! $this->upload->do_upload('image'))
			{
				$data['success'] = 0;// nilai kembali untuk ajax 0 success = false
				redirect("event/my_event/gagal", 'refresh');
			}
			else // lain jika tidak gagal
			{
				// menset nilai elemet array foto dari nama foto yg diupload
				$data["image"] = $this->upload->data('file_name');
				
				// meresize gambar
				$this->resize_image($data['image']);
				
				// operasi update
				$this->models_cencal->update('acara',"id_acara",$id_acara,$data);
				
				// jika bukan foto default
				if($image != "default-vote.png")
					unlink("./uploads/".$image); // hapus foto dari directory
				redirect("event/my_event/update-event-success", 'refresh');
				
			}
		}
		else // lain jika filenya kosong
		{	
			// operasi update
			$this->models_cencal->update('acara',"id_acara",$id_acara,$data);
			redirect("event/my_event/update-event-success", 'refresh');
		}
	}
	
	/*
	proses move to trash event
	*/
	public function do_delete($id_acara,$nama_link)
	{
		$acara = $this->models_cencal->select("acara","id_acara",$id_acara)->row();
		if($acara->image != "default-vote.png")
			unlink("./uploads/".$acara->image); // hapus foto dari directory
		$data = array(
			"trash" => "Y",
			"image" => "default-vote.png"
		);
		$this->models_cencal->update("acara","id_acara",$id_acara,$data);
		redirect("event/my_event/delete-event-success", 'refresh');
	}
	
	public function follow($act, $id_acara, $id_user, $status, $nama_link)
	{
		$data = array(
			"id_acara" => $id_acara,
			"id_user"  => $_SESSION["id_user"]
		);
		if($act == "follow")
		{
			if($status == "public")
			{
				$this->models_cencal->insert("uservotekandidat",$data);
				$data_notif = array(
					"id_acara"	=> $id_acara,
					"type"		=> "following",
					"receiver"	=> $id_user,
					"sender"	=> $_SESSION["id_user"],
					"note"		=> "Telah follow acara"
				);
				$this->models_cencal->insert("notification", $data_notif);
			}
			else
			{
				$data_notif = array(
					"id_acara"	=> $id_acara,
					"type"		=> "private_access_permission",
					"receiver"	=> $id_user,
					"sender"	=> $_SESSION["id_user"],
					"note"		=> "Meminta izin akses acara"
				);
				$this->models_cencal->insert("notification", $data_notif);
			}
			$data["status"] = $status;
			$this->models_cencal->insert("userfollowacara",$data);
		}
		else
		{
			$uvk = $this->models_cencal->select("uservotekandidat","id_acara",$id_acara)->row();
			$kandidat = $this->models_cencal->select("kandidat","id_kandidat",$uvk->id_kandidat)->row();
			//$this->models_cencal->delete_arr("uservotekandidat",$data); otomatis database
			//$data["status"] = $status;
			$datavt["hasil_voting"] = $kandidat->hasil_voting-1;
			$this->models_cencal->update("kandidat","id_kandidat",$kandidat->id_kandidat,$datavt);
			$this->models_cencal->delete_arr("userfollowacara",$data);
		}
		redirect("event/detail/".$id_acara."/".$nama_link, 'refresh');
	}
	
	public function vote($id_acara, $id_kandidat,$hasil_voting)
	{
		$data["id_kandidat"] = $id_kandidat;
		$wh_vk_data = array(
			"id_acara"	=> $id_acara,
			"id_user"	=> $_SESSION["id_user"]
		);
		
		$this->models_cencal->update_arr("uservotekandidat",$data,$wh_vk_data);
		$data["hasil_voting"] = $hasil_voting+1;
		$this->models_cencal->update("kandidat","id_kandidat",$id_kandidat,$data);
		echo json_encode($data);
	}
	
	public function notification_direct($id_acara,$type="",$sender="",$receiver="")
	{
		$wh_data = array(
			"id_acara"	=> $id_acara,
			"sender"	=> $sender,
			"receiver"	=> $receiver
		);
		$data= array(
			"status"=> "seen",
			"new"	=> "N"
		);
		$this->models_cencal->update_arr("notification",$data,$wh_data);
		if($type == "private_access_permission")
			redirect("event/access_vote/".$id_acara, 'refresh');
		else if($type == "allow_access" || $type == "following" || $type == "event_end_date"  || $type == "event_follow_end_date")
			redirect("event/detail/".$id_acara, 'refresh');
	}
	
	public function access_vote($id_acara)
	{
		$q_ufa = $this->models_cencal->select("userfollowacara", "id_acara", $id_acara);
		$q_user = $this->models_cencal->select("user");
		$q_uvk = $this->models_cencal->select("uservotekandidat", "id_acara", $id_acara);
		$data["id_acara"] = $id_acara;
		$data["userfollowacara"] = $q_ufa->result();
		$data["uservotekandidat"] = $q_uvk->result();
		$data["user"] = $q_user->result();
		$this->link_to("access_vote", $data);
	}
	
	public function allow_vote($id_acara,$id_user)
	{
		$in_data = array(
			"id_acara"	=> $id_acara,
			"id_user"	=> $id_user
		);
		$this->models_cencal->insert("uservotekandidat",$in_data);

		$data_notif = array(
			"id_acara"	=> $id_acara,
			"type"		=> "allow_access",
			"receiver"	=> $id_user,
			"sender"	=> $_SESSION["id_user"],
			"note"		=> "Izinkan anda akses acara"
		);
		$this->models_cencal->insert("notification", $data_notif);		
		echo 1;
	}
	
	private function link_seo($text)
	{
		$text = strtolower($text);
		$text = explode(" ", $text);
		$res = implode("_",$text);
		return $res;
	}
}