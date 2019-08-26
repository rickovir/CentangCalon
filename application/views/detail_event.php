<title><?php echo $event->nama_acara; ?></title>
	<?php
	$tgl = explode("-",$event->waktu_berakhir);
	$d = $tgl[2];
	$m = bulan($tgl[1]);
	$y = $tgl[0];
	?>
	<!-- acara container -->
	<div class="container detail">
		<div class="row">
			<div class="col-lg-4 img-detail">
				<img src="<?php echo base_url("uploads/".$event->image);?>" />
			</div>
			<div class="col-lg-8">
				<h2><b><?php echo $event->nama_acara; ?></b></h2>
				<div class="row">
					<div class="col-lg-8 detail-event-h-usr">
						<a href="<?php echo site_url("user/user_detail/".$user->id_user); ?>">
							<img src="<?php echo base_url("uploads/user/".$user->avatar); ?>" class="img-circle" />
							<span><?php echo $user->nama_lengkap; ?>, <b><?php echo $event->institusi; ?></b></span>
						</a>
						<p><b><?php echo $follower; ?> Follow</b></p>
						<p><i class="fa fa-calendar-check-o"></i> &nbsp Berakhir pada <?php echo $d." ".$m." ".$y; ?> </p>
					</div>
					<div class="col-lg-4">
					<?php
					$follow = false;
					if($_SESSION["id_user"] != $user->id_user)
					{
						foreach($userfollowacara as $usfol)
						{
							if($usfol->id_user == $_SESSION["id_user"])
							{
								$follow = true;
								break;
							}
						}
							if($follow)
								echo'<a href="'.site_url("event/follow/unfollow/".$event->id_acara."/".$event->id_user."/".$event->status."/".$event->nama_link).'"><button class="btn btn-danger"><b><i class="fa fa-remove"></i> &nbsp Unfollow</button></b></a>';
							else
								echo'<a href="'.site_url("event/follow/follow/".$event->id_acara."/".$event->id_user."/".$event->status."/".$event->nama_link).'"><button class="btn btn-primary"><b>Follow</button></b></a>';
					}
					?>
					</div>
				</div>
				<div class="panel panel-default detail-deskripsi">
					<div class="panel-heading">
						<button class="btn btn-sm btn-default" id="detail-sh">Show Deskripsi</button>
					</div>
					<div class="panel-body" id="sh-deskripsi">
						<p><?php echo $event->deskripsi; ?></p>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<i style="display:none" id="vote-loading" class="fa fa-refresh fa-spin fa-2x pull-left"></i><br />
				<div id="alert_success_vote" style="display:none" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i> &nbsp Vote yang anda lakukan telah disimpan
				</div>
				<?php if($num_vote == 0 && $follow == true) {?>
				<div id="alert_private_event" class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-info"></i> &nbsp Acara ini <b>private</b>, membutuhkan persetujuan pemilik acara</b>
				</div>
				<?php }
				$n = 0;
				$vote = "disabled";
				if($user->id_user != $_SESSION["id_user"] && $follow == true)
				{					
					if($num_vote !=0 && $uservotekandidat->id_kandidat == "")
					{
						$vote = "";
					}
					else if($num_vote !=0 && $uservotekandidat->id_kandidat != "")
					{
						echo'
						<div id="alert_success_vote" style="" class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="icon fa fa-check"></i> &nbsp Anda Telah Melakukan Vote
						</div>
					';
					}
				}
				?>
				<h3><b>Kandidat</b> </h3>
				<div class="row kandidat" banyak-kandidat="<?php echo $num_kandidat; ?>">
				
				<?php
				foreach($res_kandidat as $row_kandidat)
				{	
					$tgl = explode("-",$row_kandidat->tanggal_lahir);
					$d = $tgl[2];
					$m = bulan($tgl[1]);
					$y = $tgl[0];
					echo '
					<div class="col-md-6">
						<span id="detail-norut">'.$row_kandidat->no_urut.'</span> <span id="detail-nakand">'.$row_kandidat->nama_kandidat.'</span>
						<div class="row detail-prokand">
							<div class="col-xs-4">
								<img src="'.base_url("uploads/".$row_kandidat->foto).'" class="img-circle" />
							</div>
							<div class="col-xs-8">
								<p id="polingkandidat'.$row_kandidat->id_kandidat.'"><b><i class="fa fa-check-square-o"></i> '.$row_kandidat->hasil_voting.' Votes</b></p>
								<button value="'.site_url("event/vote/".$event->id_acara.'/'.$row_kandidat->id_kandidat.'/'.$row_kandidat->hasil_voting).'" class="btn btn-orange vote-me" '.$vote.'>Vote Me</button>
							</div>
						</div>
						
						<div class="panel panel-default detail-kandidat">
							<div class="panel-heading">
								<button class="btn btn-sm btn-default kandidat-sh" value="'.$n.'">Show Profile</button>
							</div>
							<div class="panel-body" id="kandidat-profile'.$n.'">
								<p><b>Nama Lengkap</b></p><p>'.$row_kandidat->nama_kandidat.'</p>
								
								<p><b>Tempat, Tanggal Lahir</b></p><p>'.$row_kandidat->tempat_lahir.', '.$d.'-'.$m.'-'.$y.'</p>
								
								<p><b>Visi</b></p>
								<p>
								'.$row_kandidat->visi.'
								</p>
								
								<p><b>Misi</b></p>
								<p>
								'.$row_kandidat->misi.'
								</p>
								
							</div>
						</div>
						
					</div>';
					$n++;
				}
				?>
				</div>
			</div>
		</div>
	</div>	
