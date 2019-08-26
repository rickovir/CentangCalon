<title>Ubah Profile</title>
<!-- Login -->
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form class="form-profile" id="form-profile" method="POST" action="<?php echo site_url("user/do_edit_profile/".$user->avatar);?>" enctype="multipart/form-data">
				<div class="form-group">
					<h1>Ubah Profile</h1>
				</div>
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" class="form-control input-lg" name="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $user->nama_lengkap; ?>" />
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control input-lg" name="email" placeholder="Alamat Email Anda" value="<?php echo $user->email; ?>" />
				</div>
				<div class="form-group">
					<label>Password (Isi jika ingin diubah)</label>
					<input type="password" class="form-control input-lg" name="password" placeholder="Password Anda" />
				</div>
				<div class="form-group">
					<label>Ulangi Password</label>
					<input type="password" class="form-control input-lg" name="re_password" placeholder="Password Anda" />
				</div>
				<div class="form-group">
					<label>Foto</label>
					<div class="img-update">
						<img id="img-preview-acara" src="<?php echo base_url("uploads/user/".$user->avatar); ?>" />
						<button type="button" id="gambar-ganti" class="btn btn-default">Ganti Gambar</button>
					</div>
					<br />
					<input type="file" id="gambar-baru" name="avatar" />					
				</div>
				<div class="form-group">
					<label>Moto</label>
					<textarea name="moto" class="form-control input-lg" placeholder="Moto Anda"><?php echo $user->moto; ?></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-orange btn-lg">Submit</button> &nbsp
					<i id="profile-loading" style="display:none" class="fa fa-refresh fa-spin fa-2x"></i>
				</div>
				<div class="form-group">
					<div class="alert alert-success alert-dismissible" style="display:none" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Profile anda berhasil disimpan
					</div>
					<div class="alert alert-danger alert-dismissible" style="display:none" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Gagal, ukuran gambar maksimal 2mb
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>