<title>Centang Calon</title>
<!-- intro container -->
	<div class="container intro">
		<div class="row">
			<div class="col-lg-12 intro-col">
				<h1>Adakan Pemilihan Segera</h1>
				<h3>Membantu Anda Dalam Pemungutan Suara</h3>
				<a href="<?php echo site_url("main/add_event");?>">
					<button class="btn btn-orange btn-lg">Buat Pemilihan</button>
				</a>
			</div>
		</div>
	</div>
	<!-- end intro container -->
	<!-- acara container -->
	<div class="container acara">
		<div class="row">
			<div class="col-lg-12 acara-title tocenter">
				<h2>Pemilihan Terpopuler<h2>
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
			<div class="col-lg-12 tocenter">
				<button class="btn btn-orange view-all-acara">Lihat Selengkapnya</button>
			</div>
		</div>
	</div>
	<!-- end acara -->
	<!-- kegunaan -->
	<div class="container guna">
		<div class="row">
			<div class="col-lg-12 guna-title tocenter">
				<h2>Apa Kegunaan Centangcalon.com ?<h2>
			</div>
			<div class="col-lg-4 tocenter">
				<h3>Lorem Ipsum Dolor</h3>
				<i class="fa fa-users guna-logo"></i></br>
				<span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna. Nunc viverra imperdiet enim.
Fusce est. Vivamus a tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede.</span>
			</div>
			<div class="col-lg-4 tocenter">
				<h3>Lorem Ipsum Dolor</h3>
				<i class="fa fa-thumbs-o-up guna-logo"></i></br>
				<span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna. Nunc viverra imperdiet enim.
Fusce est. Vivamus a tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede.</span>
			</div>
			<div class="col-lg-4 tocenter">
				<h3>Lorem Ipsum Dolor</h3>
				<i class="fa fa-support guna-logo"></i></br>
				<span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna. Nunc viverra imperdiet enim.
Fusce est. Vivamus a tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede.</span>
			</div>
		</div>
	</div>
	<!-- end kegunaan -->