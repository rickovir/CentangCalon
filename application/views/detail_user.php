<title><?php echo $user->nama_lengkap; ?></title>

	<!-- acara container -->
	<div class="container acara">
		<div class="row">
			<div class="col-md-3 usr-profile">
				<img src="<?php echo base_url("uploads/user/".$user->avatar); ?>" class="img-rounded" />
				<h3 class="nama_lengkap"><?php echo $user->nama_lengkap; ?></h3>
				<h4><?php echo $num_acara_user; ?> Acara dibuat </h4>
				<p><?php echo $user->email; ?></p>
				<p><?php echo $user->moto; ?></p>
			</div>
			<div class="col-md-9 acara-title">
				<h2>Acara miliknya<h2>
			</div>
			<!-- acara panel -->
			<!-- acara panel img 2 -->
			<div class="col-md-9">
				<div class="row">
		<?php  
			$nama = "";
			foreach($res_acara as $row) 
			{
				$own = false;
				$now = date("Y-m-d");
				if(strtotime($row->waktu_mulai) <= strtotime($now))
				{
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
							else if($row->id_user == $_SESSION["id_user"])
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
								<img src="<?php echo base_url("uploads/user/".$user->avatar); ?>" class="img-circle" />
							</div>
							<div class="col-xs-10">
								<span><?php echo $user->nama_lengkap; ?></span>
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
			?>
			</div>
			</div>
			<!-- end acara panel img 2 -->
			
		</div>
	</div>
	<!-- end acara container -->