<title>Masuk Centang Calon</title>
<!-- Login -->
<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form class="form-login" id="form-login" method="post" action="<?php echo site_url("user/do_login/".$req);?>">
				<?php if($req == "acara") { ?>
				<div class="form-group">
					<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Mohon login untuk melanjutkan pembuatan acara
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<h1>Masuk</h1>
					<p>Belum bergabung dengan kami? <a href="<?php echo site_url("main/register/".$req);?>">Daftar</a></p>
					<a href="<?php echo site_url("user/do_fb_login/Facebook/".$req); ?>" class="btn btn-block btn-lg btn-social btn-facebook">
						<i class="fa fa-facebook"></i> Masuk Melalui Facebook
					</a>
					<div class="text-bar">
						<h5>Atau</h5>
					</div>
				</div>
				<?php
				if($gagal)
				{ ?>
				<div class="form-group">
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Email atau password yang anda masukan salah !
					</div>
				</div>
				<?php 
				}
				?>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control input-lg" name="email" placeholder="Alamat Email Anda" />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control input-lg" name="password" placeholder="Password Anda" />
				</div>
				<div class="form-group">
					<label style="font-weight:normal"><input type="checkbox" name="keep" /> Buat saya tetap masuk</label>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-orange btn-lg btn-block pull-right">Masuk</button>
				</div>
			</form>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>