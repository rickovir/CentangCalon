<title>Akses User Vote</title>
<div class="container allnotifications">
	<h2>Akses User Vote</h2>
	<div class="row">
		<div class="col-lg-12">
			<div id="alert_loading" style="display:none" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="fa fa-refresh fa-spin fa-2x pull-left"></i> &nbsp Loading...
			 </div>
			<div id="alert_success_allow" style="display:none" class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="icon fa fa-check"></i> &nbsp Berhasil Memberi Izin
			 </div>
		 </div>
		<div class="col-lg-6 kiri-akses">
				<h3>User Meminta Request</h3>
			<?php
				foreach($userfollowacara as $rufa)
				{
					$ada = 0;
					foreach($uservotekandidat as $ruvk)
					{
						if($rufa->id_user == $ruvk->id_user)
							$ada++;
					}
					if($ada == 0)
					{
						$nama_lengkap = "";
						$avatar = "";
						foreach($user as $rus)
						{
							if($rufa->id_user == $rus->id_user)
							{
								$nama_lengkap = $rus->nama_lengkap;
								$avatar = $rus->avatar;
							}
						}
						echo '
								<div class="row row-akses akses-'.$rufa->id.'">
								<div class="col-xs-4 col-sm-2">
									<img src="'.base_url("uploads/user/".$avatar).'" class="img-square toimg-akses" />
								</div>
								<div class="col-xs-8 col-sm-10 name-akses">
									<button class="btn btn-sm btn-info pull-right btn-izin-vote" id_ufa="'.$rufa->id.'" data_avatar="'.base_url("uploads/user/".$avatar).'" data_nama_lengkap="'.$nama_lengkap.'" value="'.site_url("event/allow_vote/".$rufa->id_acara."/".$rufa->id_user).'" >Beri Izin</button>
									<h4>'.$nama_lengkap.'</h4>
								</div>
								</div>';
					}
				}
			?>
		</div>
		<div class="col-lg-6 kanan-akses">
				<h3>User Diizinkan</h3>
			<?php
				foreach($userfollowacara as $rufa)
				{
					foreach($uservotekandidat as $ruvk)
					{
						if($rufa->id_user == $ruvk->id_user)
						{
							$nama_lengkap = "";
							$avatar = "";
							foreach($user as $rus)
							{
								if($ruvk->id_user == $rus->id_user)
								{
									$nama_lengkap = $rus->nama_lengkap;
									$avatar = $rus->avatar;
								}
							}
							echo '
								<div class="row row-akses">
								<div class="col-xs-4 col-sm-2">
									<img src="'.base_url("uploads/user/".$avatar).'" class="img-rounded toimg-akses" />
								</div>
								<div class="col-xs-8 col-sm-10 name-akses">
									<h4>'.$nama_lengkap.'</h4>
								</div>
								</div>
								';
						}
					}
				}
			?>
		</div>
	</div>
</div>