<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<?php 
	// template header
	echo $header;
	// end of header
	?>
	
</head>
<body>

	<!-- Static navbar -->
	<nav class="navbar navbar-default navbar-static-top navigasi">
	  <div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<i class="fa fa-bars"></i>
			</button>
			<a class="navbar-brand" href="<?php echo site_url("/");?>"><img src="<?php echo base_url("uploads/favicon2.png");?>"/> <span>Centang Calon</span></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
		  <ul class="nav navbar-nav navbar-right navigasi-list">
			<?php if($logged_in) {?>
			<!-- dropdown notifications -->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle dropdown-notif" data-toggle="dropdown" notif_link="<?php echo site_url("user/notification_check/"); ?>">
				  <i class="fa fa-bell"></i>
				  <span style="display:none" class="label label-primary label_num_notif"><?php echo $_SESSION["notif"]; ?></span>
				  <input type="hidden" id="num-notification" value="<?php echo $_SESSION["notif"]; ?>" />
				  <input type="hidden" id="op-notification" value="0" />
				  <input type="hidden" id="ur-notification" value="0" />
				</a>
				<ul class="dropdown-menu notifikasi-dropdown">
					<li class="header-menu">Anda Mendapatkan <?php echo $_SESSION["notif"]; ?> Pemberitahuan</li>
					<li>
						<div style="display:none" class="tocenter notif-loading">
							<i id="notif-loading" class="fa fa-refresh fa-spin fa-2x"></i>
						</div>
					</li>
					<div class="notifikasi-row" link = "<?php echo site_url("event/notification_direct"); ?>" image-link = "<?php echo base_url("uploads"); ?>">
					</div>
					<li class="footer-menu"><a class="to-center" href="<?php echo site_url("user/notifications"); ?>">Lihat Selengkapnya</a></li>
				</ul>
			</li>
			<!-- this is end of dropdown notifications -->
			<li>
				<a href="<?php echo site_url("search"); ?>">
					<i class="fa fa-search"></i> Cari Pemilihan
				</a>
			</li>
			<li><a href="<?php echo site_url("event/my_event"); ?>"><i class="fa fa-calendar-o"></i> Acaraku</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION["nama_depan"]; ?> <span class="caret"></span></a>
				<ul class="dropdown-menu navigasi-dropdown">
					<li><a href="<?php echo site_url("user"); ?>"><i class="fa fa-home"></i> Beranda</a></li>
					<li><a href="<?php echo site_url("user/edit_profile"); ?>"><i class="fa fa-user"></i> Edit Profile</a></li>
					<li><a href="<?php echo site_url("user/add_event"); ?>"><i class="fa fa-plus"></i> Add Acara</a></li>
					<li><a href="<?php echo site_url("user/logout"); ?>"><i class="fa fa-sign-out"></i> Keluar</a></li>
				</ul>
            </li>
			
			<?php }else{ ?>
			<li><a href="<?php echo site_url("search"); ?>"><i class="fa fa-search"></i> Cari Pemilihan</a></li>
			<li><a href="<?php echo site_url("about"); ?>"><i class="fa fa-info"></i> Tentang Kami</a></li>
			<li><a href="<?php echo site_url("main/login");?>"><i class="fa fa-sign-in"></i> Masuk</a></li>
			
			<?php }?>
			
		  </ul>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	
	<?php 
	// template content
	echo $contents;
	// end of content
	?>
	
	<!-- footer -->
    <footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<p>Made with <i class="fa fa-heart"></i> & <i class="fa fa-coffee"></i>  by Fasilkom Learning Center</p>
					<a href="#">Kebijakan</a>
					&nbsp&nbsp
					<a href="#">Bantuan</a>
				</div>
				<div class="col-lg-6">
					<p class="pull-right">falcer esaunggul university</p>
				</div>
			</div>
		</div>
    </footer>
	<!--end footer-->
	
</body>
</html>