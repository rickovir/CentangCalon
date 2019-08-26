<title>Tambah Acara</title>
<!-- Acara -->
<div class="container">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<form class="form-add-acara" id="form-add-acara" method="post" action="<?php echo site_url("user/do_add_event"); ?>">
				<div class="form-group">
					<h1>Buat Acara</h1>
					<p>Mulai Acara pemilihan anda, tentukan acara apa yang anda inginkan</p>
					<br />
				</div>
				<div class="form-group">
					<label>Nama Acara</label>
					<input type="text" class="form-control input-lg" name="nama_acara" placeholder="Nama Acara Anda" />
				</div>
				<div class="form-group">
					<label>Institusi atau Lembaga</label>
					<input type="text" class="form-control input-lg" name="institusi" placeholder="Untuk siapa pemilihan diadakan" />
				</div>
				<div class="form-group">
					<label>Waktu Mulai</label>
					<div class="input-group">
						<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="text" class="form-control input-lg" name="waktu_mulai" id="datepicker" placeholder="Kapan Acara dimulai" />
					</div>
				</div>
				<div class="form-group">
					<label>Waktu Berakhir</label>
					<div class="input-group">
						<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="text" class="form-control input-lg" name="waktu_berakhir" id="datepicker2" placeholder="Kapan Berakhirnya" />
					</div>
				</div>
				<div class="form-group">
					<label>Deskripsi</label>
					<textarea class="form-control input-lg acara-deskripsi" name="deskripsi" placeholder="Deskripsikan Acara anda agar orang mudah mengenalinya"></textarea>
				</div>
				<div class="form-group">
					<input type="hidden" name="status" value="aktif" />
					<button type="submit" class="btn btn-orange btn-lg pull-right">Lanjut</button>
				</div>
			</form>
		</div>
		<div class="col-lg-3"></div>
	</div>
</div>