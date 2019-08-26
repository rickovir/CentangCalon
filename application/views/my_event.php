<title>Acaraku</title>
	<!-- acara container -->
	<div class="container acara">
		<div class="row">
			<div class="col-lg-12 acara-title">
				<h3><i class="fa fa-calendar-o"></i> Daftar Semua Acaraku<h3>				
			</div>
			<div class="col-lg-12">
			<?php
			if($operasi == "add-event-success")
			{
				echo'
				<div id="alert_success_add" style="" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i> &nbsp Acara Berhasil Ditambahkan
				 </div>';
			}
			else if($operasi == "update-event-success")
			{
				echo'
				<div id="alert_success_update" style="" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i> &nbsp Acara Berhasil Diubah
				</div>';
			}
			else if($operasi == "delete-event-success")
			{
				echo'
				<div id="alert_success_del" style="" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i> &nbsp Acara Berhasil Dihapus
				</div>
				 ';
			}
			?>
			
				<div id="alert_success_del" style="display:none" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i> &nbsp Acara Berhasil Dihapus
				 </div>
			</div>
			<!-- acara panel -->
			<!-- acara panel img 2 -->
			<?php  
			$nama = NULL;
			$avatar = "";
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
					<div class="panel-body">
						<div class="row img-2">
							<div class="col-xs-12 tocenter">
								<img src="<?php echo base_url("uploads/".$row->image); ?>"/>
							</div>
						</div>
					</div>
					<div class="panel-footer acara-panel-footer">
						<div class="row">
							<div class="col-xs-2">
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
							<span><?php echo $count_votes; ?> Follow</span>
							
							<div class="dropdown pull-right">
								<button class="btn btn-default dropdown-toggle" type="button" id="my_acara_act" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<i class="fa fa-gear"></i>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="my_acara_act">
									<li><a href="<?php echo site_url("event/update/".$row->id_acara."/".$row->nama_link); ?>"><i class="fa fa-pencil"></i> &nbsp Ubah</a></li>
									<li><a href="<?php echo site_url("event/do_delete/".$row->id_acara."/".$row->nama_link); ?>"><i class="fa fa-trash"></i> &nbsp Hapus</a></li>
									<li><a href="<?php echo site_url("event/detail/".$row->id_acara."/".$row->nama_link); ?>"><i class="fa fa-eye"></i> &nbsp Lihat</a></li>
									<?php if($row->status == "private") { ?>
									<li><a href="<?php echo site_url("event/access_vote/".$row->id_acara); ?>"><i class="fa fa-user-plus"></i> &nbsp Izin User Vote</a></li>
									<?php }?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } 
			?>
			<!-- end acara panel img 2 -->
		</div>
	</div>