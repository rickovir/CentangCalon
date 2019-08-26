<title>Semua Acara</title>
	<!-- acara container -->
	<div class="container acara">
		<div class="row">
			<div class="col-lg-12 acara-title">
				<h3>Semua Acara Terkini<h3>
			</div>
			<!-- acara panel -->
			<!-- acara panel img 2 -->
			<?php  
			$nama = NULL;
			foreach($r_acara as $row) 
			{
				foreach($r_user as $urow)
				{
					if($urow->id_user == $row->id_user){
						$nama = $urow->nama_lengkap;
						$avatar = $urow->avatar;
					}
				}
				$count_votes = 0;
				foreach($r_follow as $frow)
				{
					if($frow->id_acara == $row->id_acara)
						$count_votes++;
				}
			?>
			<div class="col-sm-3">
				<div class="panel panel-solid">
					<div class="panel-heading">
						<span class="acara_nama"><?php echo $row->nama_acara; ?></span>
					</div>
					<div class="panel-body acara-panel-body">
						<div class="row img-2">
							<div class="col-xs-12 tocenter">
								<img src="<?php echo base_url("assets/img/".$row->image); ?>"/>
							</div>
						</div>
					</div>
					<div class="panel-footer acara-panel-footer">
						<div class="row">
							<div class="col-xs-2">
								<?php if($avatar == NULL) ?>
								<img src="<?php echo base_url("assets/img/default-user.png"); ?>" class="img-circle" />
							</div>
							<div class="col-xs-10">
								<span><?php echo $nama; ?></span>
							</div>
						</div>
						<div class="acara-joint">
							<span><?php echo $count_votes; ?> Vote</span><a class="pull-right btn btn-primary btn-sm" href="#">join</a>
						</div>
					</div>
				</div>
			</div>
			<?php } 
			?>
			<!-- end acara panel img 2 -->
		</div>
	</div>