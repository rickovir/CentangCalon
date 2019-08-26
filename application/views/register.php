<title>Daftar Centang Calon</title>
<!-- Login -->
<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form class="form-register" id="form-register" method="post" action="<?php echo site_url("user/do_register/".$req);?>">
				<?php if($req == "acara") { ?>
				<div class="form-group">
					<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Mohon daftar untuk melanjutkan pembuatan acara
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<h1>Daftar</h1>
					<p>Registrasi anda untuk masuk akun kami</a></p>
					<a href="<?php echo site_url("user/do_fb_login/Facebook/".$req); ?>" class="btn btn-block btn-lg btn-social btn-facebook">
						<i class="fa fa-facebook"></i> Daftar Melalui Facebook
					</a>
					<div class="text-bar">
						<h5>Atau</h5>
					</div>
				</div>
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" class="form-control input-lg" name="nama_lengkap" placeholder="Nama Lengkap" />
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control input-lg" name="email" placeholder="Alamat Email Anda" />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control input-lg" name="password" placeholder="Password Anda" />
				</div>
				<div class="form-group">
					<p>Dengan menekan tombol dibawah ini berarti anda telah setuju dengan <a href="">Syarat dan Ketentuan</a> kami buat.</p>
					<button type="submit" class="btn btn-orange btn-lg btn-block">Daftar</button>
				</div>
				<div class="form-group">
					<p>Apa anda sudah memiliki akun? <a href="<?php echo site_url("main/login/".$req);?>">Masuk</a></p>
				</div>	
			</form>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>