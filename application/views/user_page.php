<title>Beranda <?php echo $ses_user->nama_lengkap; ?></title>
	<!-- user into container
	<div class="layer-userin">
	<div class="container userin">
		<div class="row">
			<div class="col-lg-12 space"></div>
			
		</div>
	</div>
	</div>
	end intro container-->
	
	<!-- acara container -->
	<div class="container acara">
		<div class="row">
			<div class="col-md-3 usr-profile">
				<img src="<?php echo base_url("uploads/user/".$ses_user->avatar); ?>" class="img-rounded" />
				<h3 class="nama_lengkap"><?php echo $ses_user->nama_lengkap; ?></h3>
				<h4><a href="<?php echo site_url("event/my_event"); ?>"><?php echo $num_ses_acara; ?> Acara</a> | <?php echo $follow_acara; ?> Acara diikuti </h4>
				<a href="<?php echo site_url("user/edit_profile"); ?>">Ubah Profile</a>
			</div>
			<div class="col-md-9 acara-title">
				<h2>Acara yang diikuti<h2>
			</div>
			<!-- acara panel -->
			<!-- acara panel img 2 -->
			<div class="col-md-9">
				<div class="row">
		<?php  
			$nama = "";
			$own = false;
			foreach($r_follow as $frow1)
			{
				foreach($r_acara as $row) 
				{
					$now = date("Y-m-d");
					if(strtotime($row->waktu_mulai) <= strtotime($now))
					{
						if($frow1->id_user == $_SESSION['id_user'] && $frow1->id_acara == $row->id_acara)
						{
							foreach($r_user as $urow)
							{
								if($urow->id_user == $row->id_user){
									$nama = $urow->nama_lengkap;
									$avatar = $urow->avatar;
									if(!empty($_SESSION["logged_in"]))
									{
										if($urow->id_user == $_SESSION["id_user"])
											$own = true;
										else
											$own = false;
									}
								}
							}
							$count_votes = 0;
							foreach($r_follow2 as $frow2)
							{
								if($frow2->id_acara == $row->id_acara)
									$count_votes++;
								
								if(!empty($_SESSION["logged_in"]))
								{
									if($frow2->id_user == $_SESSION['id_user'] && $frow2->id_acara == $row->id_acara)
									{
										$own = true;
									}
								}
							}
				?>
				<div class="col-sm-4">
					<div class="panel panel-solid">
						<div class="panel-heading">
							<span class="acara_nama"><?php echo $row->nama_acara; ?></span>
						</div>
						<div class="panel-body acara-panel-body">
							<div class="row img-2">
								<div class="col-xs-12 tocenter">
									<img src="<?php echo base_url("uploads/".$row->image); ?>"/>
								</div>
							</div>
						</div>
						<div class="panel-footer acara-panel-footer">
							<div class="row">
								<div class="col-xs-2">
									<?php if($avatar == NULL) ?>
									<img src="<?php echo base_url("uploads/user/".$avatar); ?>" class="img-circle" />
								</div>
								<div class="col-xs-10">
									<span><?php echo $nama; ?></span>
									<?php if($row->status == "private"){
									echo '<span class="pull-right status-label">private</span>';
									} ?>
								</div>
							</div>
							<div class="acara-joint">
								<span><?php echo $count_votes; ?> Vote</span>
								<?php
								if($own == false)
								{
									echo'
									<a class="pull-right btn btn-primary btn-sm" href="'.site_url("event/detail/".$row->id_acara."/".$row->nama_link).'">Follow</a>
									';
								}
								else
								{
									echo'
									<a class="pull-right btn btn-success btn-sm" href="'.site_url("event/detail/".$row->id_acara."/".$row->nama_link).'">View</a>
									';
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<?php 
						}
					}
				}
			}
			?>
			</div>
			</div>
			<!-- end acara panel img 2 -->
			
		</div>
	</div>
	<!-- end acara container -->