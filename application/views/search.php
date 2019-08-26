<title>Pencarian</title>
<!-- search container -->
	<div class="container search">
		<div class="row">
			<div class="col-lg-2">
			</div>
			<div class="col-lg-8">
				<form action="<?php echo site_url("search/index/found"); ?>" method="POST">
					<div class="form-group tocenter">
						<h1>Pencarian</h1>
					</div>
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control input-lg" name="search" placeholder="Cari Acara.." />
							<span class="input-group-btn input-group-lg">
								<button class="btn btn-default btn-flat btn-lg" type="button"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</div>
				</form>
			</div>
			<div class="col-lg-2">
			</div>
		</div>
	</div>
	<!-- acara container -->
	<div class="container acara">
		<div class="row">
			<div class="col-lg-12 acara-title">
				<div class="line-horizontal"></div>
				<?php if($search){
					echo'
					<h3>Hasil Pencarian<h3>
					';
					if($num_acara == 0)
						echo'<h3> Tidak Ada</h3>';
				}else{
					echo'
					<h3>Pemilihan Terpopuler Saat Ini<h3>
					';
				} ?>
			</div>
			<!-- acara panel -->
			<!-- acara panel img 2 -->
			<?php  
			$nama = "";
			$own = false;
			$now = date("Y-m-d");
			foreach($r_acara as $row) 
			{
				$now = date("Y-m-d");
				if(strtotime($row->waktu_mulai) <= strtotime($now))
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
					foreach($r_follow as $frow)
					{
						if($frow->id_acara == $row->id_acara)
							$count_votes++;
						
						if(!empty($_SESSION["logged_in"]))
						{
							if($frow->id_user == $_SESSION['id_user'] && $frow->id_acara == $row->id_acara)
							{
								$own = true;
							}
						}
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
			<?php } 
			}
			?>
			<!-- end acara panel img 2 -->
		</div>
	</div>