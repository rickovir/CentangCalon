<title>Ubah Acara</title>
<!-- Acara -->
<div class="container">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<form class="form-add-acara" id="form-update-acara" method="post" action="<?php echo site_url("event/do_update/".$event->id_acara."/".$event->image); ?>" enctype="multipart/form-data">
				<div class="form-group">
					<h1>Update Acara</h1>
					<p>Lengkapi Acara anda atau ubah sesuai keperluan</p>
					<br />
				</div>
				<div class="form-group">
					<label>Nama Acara</label>
					<input type="text" class="form-control input-lg" name="nama_acara" placeholder="Nama Acara Anda" value="<?php echo $event->nama_acara; ?>" />
				</div>
				<div class="form-group">
					<label>Institusi atau Lembaga</label>
					<input type="text" class="form-control input-lg" name="institusi" placeholder="Untuk siapa pemilihan diadakan" value="<?php echo $event->institusi; ?>" />
				</div>
				<div class="form-group">
					<label>Waktu Mulai</label>
					<div class="input-group">
						<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="text" class="form-control input-lg" name="waktu_mulai" id="datepicker" placeholder="Kapan Acara dimulai" value="<?php echo $event->waktu_mulai; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label>Waktu Berakhir</label>
					<div class="input-group">
						<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="text" class="form-control input-lg" name="waktu_berakhir" id="datepicker2" placeholder="Kapan Berakhirnya" value="<?php echo $event->waktu_berakhir; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label>Gambar Acara</label>
					<div class="img-update">
						<img id="img-preview-acara" src="<?php echo base_url("uploads/".$event->image); ?>" />
						<button type="button" id="gambar-ganti" class="btn btn-default">Ganti Gambar</button>
					</div>
					<br />
					<input type="file" id="gambar-baru" name="image" />
				</div>
				<div class="form-group">
					<label>Deskripsi</label>
					<textarea class="form-control input-lg acara-deskripsi" name="deskripsi" placeholder="Deskripsikan Acara anda agar orang mudah mengenalinya"><?php echo $event->deskripsi; ?></textarea>
				</div>
				<div class="form-group">
				<?php
				$check = "";
					if($event->status == "public")
						$check = "checked";
				?>
					<label>Status Event</label><br />
					<input type="checkbox" class="form-control" name="status-p" value="public" <?php echo $check; ?> />
				</div>
				<div class="form-group">
					<label>Kandidat</label>
					<div id="alert_fail" style="display:none" class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-warning"></i> &nbsp Gagal! Gambar terlalu besar. Maksimal 2 MB
					 </div>
					<div id="alert_success_add" style="display:none" class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i> &nbsp Kandidat Berhasil Ditambahkan
					 </div>
					<div id="alert_success_update" style="display:none" class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i> &nbsp Kandidat Berhasil Diubah
					 </div>
					<div id="alert_success_del" style="display:none" class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i> &nbsp Kandidat Berhasil Dihapus
					 </div>
					<div id="alert_loading_del" style="display:none" class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="fa fa-refresh fa-spin fa-2x pull-left"></i> &nbsp Loading...
					 </div>
					<div class="tampil-kandidat">
					<input id="kandidat-link" type="hidden" add_link="<?php echo site_url("event/add_kandidat/".$event->id_acara); ?>" update_link="<?php echo site_url("event/update_kandidat/".$event->id_acara); ?>" delete_link="<?php echo site_url("event/delete_kandidat/".$event->id_acara);?>" />
					<?php
					foreach($result_kandidat as $row_kandidat)
					{
						echo'
						<div id="row-kandidat" class="row op_no_urut-'.$row_kandidat->no_urut.'">
							<div class="col-lg-8">
								<div id="no_urut">'.$row_kandidat->no_urut.'</div>
								<h4>'.$row_kandidat->nama_kandidat.'</h4><br />
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-kandidat" data-whatever="'.$row_kandidat->no_urut.'"><i class="fa fa-pencil"></i> Ubah</button>
								<button type="button" class="btn btn-warning del_kandidat" value="'.$row_kandidat->no_urut.'"><i class="fa fa-trash"></i> Hapus</button>
							</div>
							<div class="col-lg-4 tocenter">
								<img src="'.base_url("uploads/".$row_kandidat->foto).'" class="img-circle">
							</div>
							<input type="hidden" id="kandidat-data-'.$row_kandidat->no_urut.'" nama_kandidat="'.$row_kandidat->nama_kandidat.'" tempat_lahir="'.$row_kandidat->tempat_lahir.'" tanggal_lahir="'.$row_kandidat->tanggal_lahir.'" visi="'.$row_kandidat->visi.'" misi="'.$row_kandidat->misi.'" foto="'.$row_kandidat->foto.'" />
						</div>	
						';
					}
					?>
					</div>
					<button type="button" class="btn btn-default form-control" data-toggle="modal" data-target="#modal-kandidat" data-whatever="0"><i class="fa fa-plus"></i></button>
				</div>
				<div class="form-group">
					<button type="button" style="margin-left:10px" class="btn btn-primary btn-lg pull-right" onclick="self.history.back()">Batal</button>
					<button type="submit" class="btn btn-orange btn-lg pull-right">Submit</button>
				</div>
			</form>
			<!-- Modal -->
			<div class="modal fade" id="modal-kandidat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					<form id="form-kandidat" action="" method="POST" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title tocenter" id="myModalLabel">Form Kandidat</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Nama Kandidat</label>
								<input type="text" name="nama_kandidat" class="form-control" placeholder="Nama Kandidat" />
							</div>
							<div class="form-group">
								<label>Tempat Lahir</label>
								<input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" />
							</div>
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input type="text" name="tanggal_lahir" id="datepicker3" class="form-control" placeholder="Tanggal Lahir" />
							</div>
							<div class="form-group">
								<label>Visi</label>
								<textarea name="visi" class="form-control" placeholder="Visi Kandidat"></textarea>
							</div>
							<div class="form-group">
								<label>Misi</label>
								<textarea name="misi" class="form-control" placeholder="Misi Kandidat"></textarea>
							</div>
							<div class="form-group">
								<label>Foto</label>
								<div class="img-kandidat">
									<img id="img-preview-kandidat" src="<?php echo base_url("uploads/default-user.png"); ?>" img-address="<?php echo base_url("uploads"); ?>"/>
									<button type="button" id="gambar-kandidat-ganti" class="btn btn-default">Ganti Gambar</button>
								</div>
								<br />
								<input type="file" id="gambar-kandidat-baru" name="foto" />
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" id="no_urut_update" value="" />
							<i id="kandidat-loading" style="display:none" class="fa fa-refresh fa-spin fa-2x pull-left"></i> &nbsp 
							<input type="reset" id="kandidat-reset">
							<button type="button" class="btn btn-default" data-dismiss="modal" id="kandidat-close">Batal</button>
							<button type="submit" class="btn btn-primary">Simpan</button>
							
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3"></div>
	</div>
</div>