<title>Notifikasi</title>
<div class="container allnotifications">
	<h2>Notifikasi Anda</h2>
	<br />
	<?php 
	foreach($notification as $rowan)
	{
		foreach($acara as $rowac)
		{
			if($rowac->id_acara == $rowan->id_acara && $rowac->trash == "N")
			{
				$nama_user = "";
				foreach($user as $rouser)
				{
					if($rowan->sender == $rouser->id_user && $rowan->sender != $_SESSION["id_user"])
						$nama_user = $rouser->nama_lengkap;
					
					if($rowan->type == "event_follow_end_date")
						$nama_user = "";
				}
				$link = site_url("event/notification_direct/".$rowan->id_acara.'/'.$rowan->type.'/'.$rowan->sender.'/'.$rowan->receiver);
				echo'
				<div class="row row-allnotif">
					<a href="'.$link.'">
						<div class="col-xs-4 col-sm-2 col_img_allnotif">
							<img src="'.base_url("uploads/".$rowac->image).'" class="img-allnotif" />
						</div>
						<div class="col-xs-6 col-sm-6">
							<h3>'.$rowac->nama_acara.'</h3>
						</div>';
						if($rowan->status == "seen")
						{
						echo '
						<div class="col-xs-2">
							<i class="fa fa-check status-item"></i>
						</div>';
						}
						echo'
						<div class="col-xs-8 col-sm-6">
							<p>'.$nama_user.' '.$rowan->note.'</p>
						</div>
						
					</a>
				</div>
				';
			}
		}
	}
	?>
</div>