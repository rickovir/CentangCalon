$(document).ready(function(){
	
	// function of notification
	function notification_load(type,ck)
	{
		var notification;
		if(type == "when_click")
			notification_link = $(".dropdown-toggle").attr("notif_link")+"/wc";
		else
			notification_link = $(".dropdown-toggle").attr("notif_link")+"/ac";
		$.ajax({
			type			: "GET",
			dataType		: "json",
			url				: notification_link+"/"+ck,
			data			: "",
			cache			: false,
			contentType		: false,
			processData		: false,
			beforeSend		: function(){
				if(type == "when_click")
					$(".notif-loading").show();
			},
			success			: function(data){
			//	console.log(data);
			//	console.log(data["num"]);
				$(".notif-loading").hide();	
				var num_come = parseInt(data["num"]);	
				var image_link = $(".notifikasi-row").attr("image-link");			
				var link_url = $(".notifikasi-row").attr("link");			
				if(type == "after_click")
				{	
					//$("title").text("Centang Calon");
					if(num_come !=0)
					{
						$(".label_num_notif").show();
						$(".label_num_notif").text(num_come);
						//$("title").text("Centang Calon ("+num_come+")");
						if($("#op-notification").val() != data["id_notification"] && ck =="N" && $("#ur-notification").val() == 1)
						{
							$("#op-notification").val(data["id_notification"]);
							for(i=0; i < num_come; i++)
							{						
							var el = '<li><a href="'+link_url+"/"+data["id_acara"][i]+"/"+data["type"][i]+"/"+data["sender"][i]+"/"+data["receiver"][i]+'">'+
										'<div class="row notifikasi-item">' +
											'<div class="col-xs-2">' +
												'<img class="img-item" src="'+image_link+"/"+data["image"][i]+'" />' +
											'</div>' +
											'<div class="col-xs-10">' +
												'<span class="title-item">'+data['nama_acara'][i]+'</span>' +
											'</div>' +
											'<div class="col-xs-8">' +
											'	<span class="">'+data["sender_name"][i]+" "+data["note"][i]+'</span>' +
											'</div>' +
										'</div>' +
									'</a></li>';
								$(".notifikasi-row").prepend(el);	
							}
						}
					}
				}
				else
				{
					//$(".notifikasi-row li").remove();
					$(".header-menu").text("Anda Mendapatkan "+num_come+" Pemberitahuan");
					for(i=0; i < num_come; i++)
					{
						var el = '<li><a href="'+link_url+"/"+data["id_acara"][i]+"/"+data["type"][i]+"/"+data["sender"][i]+"/"+data["receiver"][i]+'">'+
								'<div class="row notifikasi-item">' +
									'<div class="col-xs-2">' +
										'<img class="img-item" src="'+image_link+"/"+data["image"][i]+'" />' +
									'</div>' +
									'<div class="col-xs-10">' +
										'<span class="title-item">'+data['nama_acara'][i]+'</span>' +
									'</div>' +
									'<div class="col-xs-8">' +
									'	<span class="">'+data["sender_name"][i]+" "+data["note"][i]+'</span>' +
									'</div>' +
								'</div>' +
							'</a></li>';
						$(".notifikasi-row").append(el);
						if(i>=7)
							break;
					}
				}
			}
		});
	}
	// end of notification
	
	// dropdown notification when click
	$(".dropdown-notif").on("click",function(){
		if($("#ur-notification").val() == 0)
		{
			notification_load("when_click","Y");
			$("#ur-notification").val("1");
		}
		else
			notification_load("after_click","Y");
		
		$(".label_num_notif").hide();
		$("#op-notification").val("0");
	});
	// end of dropdown notification 
	
	// interval action when page ready
	if($("#num-notification").length != 0)
	{
		setInterval(function(){
				notification_load("after_click","N");
		},30000);
	}
	// end of interval

	//
	$(".btn-izin-vote").on("click", function(){
		var nama_lengkap = $(this).attr("data_nama_lengkap");
		var avatar = $(this).attr("data_avatar");
		var id = $(this).attr("id_ufa");
		
		$.ajax({
			type			: "GET",
			dataType		: "json",
			url				: $(this).val(),
			data			: "",
			cache			: false,
			contentType		: false,
			processData		: false,
			beforeSend		: function(){
				$("#alert_loading").show();
			},
			success			: function(data){
				if(data == 1)
				{
					$("#alert_loading").hide();
					$("#alert_success_allow").show();
					$(".akses-"+id).remove();
					var el = '<div class="row row-akses">'+
					'<div class="col-xs-4 col-sm-2">'+
							'<img src="'+avatar+'" class="img-circle toimg-akses" />'+
						'</div>'+
						'<div class="col-xs-8 col-sm-8 name-akses">'+
							'<h4>'+nama_lengkap+'</h4>'+
						'</div></div>';
					$(".kanan-akses h3").after(el);
				}
			}
		});
	});
	
	//datepicker
	$('#datepicker').datepicker({
		format: "yyyy-mm-dd"
	}) // and it detected of validator
	.on('changeDate', function(e) {
            // Revalidate the date field
            $('#form-add-acara').bootstrapValidator('revalidateField', 'waktu_mulai');
	});
	
	$('#datepicker2').datepicker({
		format: "yyyy-mm-dd"
	})
	.on('changeDate', function(e) {
            // Revalidate the date field
            $('#form-add-acara').bootstrapValidator('revalidateField', 'waktu_berakhir');
	});
	
	$('#datepicker3').datepicker({
		format: "yyyy-mm-dd"
	})
	.on('changeDate', function(e) {
            // Revalidate the date field
            $('#form-update-event').bootstrapValidator('revalidateField', 'tanggal_lahir');
	});
	// end of datepicker act
	
	$('#form-add-acara').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			nama_acara: {
				validators: {
					notEmpty: {
						message: 'Nama acara tidak boleh kosong'
					}
				}
			},
			institusi: {
				validators: {
					notEmpty: {
						message: 'Institusi tidak boleh kosong'
					}
				}
			},
			waktu_mulai: {
				validators: {
					notEmpty: {
						message: 'Waktu Mulai tidak boleh kosong'
					},
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
				}
			},
			waktu_berakhir: {
				validators: {
					notEmpty: {
						message: 'Waktu Berakhir tidak boleh kosong'
					},
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
				}
			},
			deskripsi: {
				validators: {
					notEmpty: {
						message: 'Deskripsi tidak boleh kosong'
					}
				}
			}
		}
	});
	
	$('#form-update-acara').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			nama_acara: {
				validators: {
					notEmpty: {
						message: 'Nama acara tidak boleh kosong'
					}
				}
			},
			institusi: {
				validators: {
					notEmpty: {
						message: 'Institusi tidak boleh kosong'
					}
				}
			},
			waktu_mulai: {
				validators: {
					notEmpty: {
						message: 'Waktu Mulai tidak boleh kosong'
					},
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
				}
			},
			waktu_berakhir: {
				validators: {
					notEmpty: {
						message: 'Waktu Berakhir tidak boleh kosong'
					},
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
				}
			},
			deskripsi: {
				validators: {
					notEmpty: {
						message: 'Deskripsi tidak boleh kosong'
					}
				}
			}
		}
	});
	
	$('#form-login').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			email: { //name
				validators: {
					notEmpty: {
						message: 'Email tidak boleh kosong'
					},
					emailAddress: {
						message: 'The input is not a valid email address'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: 'Password tidak boleh kosong'
					}
				}
			}
		}
	});
	
	$('#form-register').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			nama_lengkap: { //name
				validators: {
					notEmpty: {
						message: 'Nama Lengkap tidak boleh kosong'
					}
				}
			},
			email: { //name
				validators: {
					notEmpty: {
						message: 'Email tidak boleh kosong'
					},
					emailAddress: {
						message: 'The input is not a valid email address'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: 'Password tidak boleh kosong'
					}
				}
			}
		}
	});
	
	$('#form-profile').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			nama_lengkap: { //name
				validators: {
					notEmpty: {
						message: 'Nama Lengkap tidak boleh kosong'
					}
				}
			},
			email: { //name
				validators: {
					notEmpty: {
						message: 'Email tidak boleh kosong'
					},
					emailAddress: {
						message: 'The input is not a valid email address'
					}
				}
			}
		}
	}).on('success.form.bv', function(e) {
		// Prevent form submission
		e.preventDefault();
		
		var formData = new FormData(e.target);
		$.ajax({
				type			: "POST",
				url				: $(e.target).attr("action"),
				data			: formData,
				cache			: false,
				contentType		: false,
				processData		: false,
				beforeSend		: function(){
					$("#profile-loading").show();
					$(".alert-success").hide();
					$(".alert-danger").hide();
				},
				success			: function(data){
					console.log(data);
					$("#profile-loading").hide();
					if(data == "success")
					{
						$(".alert-success").fadeIn("slow",alert_timeout(".alert-success"));
					}
					else
					{
						$(".alert-danger").fadeIn("slow",alert_timeout(".alert-danger"));
					}
				},
				error			: function(data){
					console.log("error");
					console.log(data);
				}
		});
	});
	
	var num_kandidat = $('.kandidat').attr("banyak-kandidat");
	
	$(".kandidat-sh").click(function(){
		var opk = $(this).val();
		$(this).text("Profile");
		$("#kandidat-profile"+opk).slideDown();
	});
	
	$("#detail-sh").click(function(){
		$("#sh-deskripsi").slideToggle();
	});
	
	$("#gambar-ganti").click(function(){
		$("#gambar-baru").click();
	});
	
	$("#gambar-kandidat-ganti").click(function(){
		$("#gambar-kandidat-baru").click();
	});
	
	$.fn.bootstrapSwitch.defaults.offText = 'Private';
	$.fn.bootstrapSwitch.defaults.onText = 'Public';
	
	$("[name='status-p']").bootstrapSwitch();
	
	function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#"+id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#gambar-baru").change(function () {
        readURL(this,"img-preview-acara");
    });
	
	
    $("#gambar-kandidat-baru").change(function () {
        readURL(this,"img-preview-kandidat");
    });
	
	
	$("#kandidat-close").click(function(){
		$("#kandidat-reset").click();
		var img_address = $("#img-preview-kandidat").attr("img-address");
		$("#img-preview-kandidat").attr("src",img_address+"/default-user.png");
	});
	
	/* $("#kandidat-hapus").click(function(){
		$.ajax({
			type			:"GET",
			
		});
	}); */
	function alert_timeout(id)
	{
		setTimeout(function(){
			$(id).fadeOut("slow");
		}, 5000);
	}
	//dell works
	$(".row").on("click",".del_kandidat",function(){
		var no_urut = $(this).val();
		var del_url = $("#kandidat-link").attr("delete_link")+"/"+no_urut+"/"+$("#kandidat-data-"+no_urut).attr("foto");
		$.ajax({
			type			: "GET",
			dataType		: "json",
			url				: del_url,
			data			: "",
			cache			: false,
			contentType		: false,
			processData		: false,
			beforeSend		: function(){
				$("#alert_loading_del").show();
				$("#alert_success_del").hide();
			},
			success			: function(data){
				console.log("success");
				$("#alert_loading_del").hide();
				if(data == 1)
				{
					$(".op_no_urut-"+no_urut).remove();
					$("#alert_success_del").fadeIn("slow",alert_timeout("#alert_success_del"));
				}
			},
			/* error			: function(data){
				console.log("error");
				console.log(data);
			} */
		});
	});
	
	function view_data_kandidat(no_urut)
	{
		var nama 			= $("#kandidat-data-"+no_urut).attr("nama_kandidat");
		var tempat_lahir 	= $("#kandidat-data-"+no_urut).attr("tempat_lahir");
		var tanggal_lahir 	= $("#kandidat-data-"+no_urut).attr("tanggal_lahir");
		var visi		 	= $("#kandidat-data-"+no_urut).attr("visi");
		var misi 			= $("#kandidat-data-"+no_urut).attr("misi");
		var foto 			= $("#kandidat-data-"+no_urut).attr("foto");
		var img_address = $("#img-preview-kandidat").attr("img-address");
		$("input[name='nama_kandidat']").val(nama);
		$("input[name='tempat_lahir']").val(tempat_lahir);
		$("input[name='tanggal_lahir']").val(tanggal_lahir);
		$("textarea[name='visi']").val(visi);
		$("textarea[name='misi']").val(misi);
		$("#img-preview-kandidat").attr("src",img_address+"/"+foto);
	}
	
	$('#modal-kandidat').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		 var recipient = button.data('whatever') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this);
		  modal.find('#no_urut_update').val(recipient);
		  if(recipient > 0)
				view_data_kandidat(recipient);
	});
	/* 
	$("#row-kandidat").click(function(){
		view_data_kandidat($(this).attr("no_urut"));
	}); */
	
	$("#form-kandidat").on("submit",(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		var no_urut = $("#no_urut_update").val();
		if(no_urut == 0)
		{
			$.ajax({
				type			: "POST",
				dataType		: "json",
				url				: $("#kandidat-link").attr("add_link"),
				data			: formData,
				cache			: false,
				contentType		: false,
				processData		: false,
				beforeSend		: function(){
					$("#kandidat-loading").show();
					$("#alert_fail").hide();
				},
				success			: function(data){
					$("#kandidat-loading").hide();
					if(data["success"] == 1)
					{
						console.log("success");
						var img_address = $("#img-preview-kandidat").attr("img-address");
						var html = '<div class="col-lg-8"> 								<div id="no_urut">'+data['no_urut']+'</div> 								 <h4>'+data['nama_kandidat']+'</h4><br /><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-kandidat" data-whatever="'+data['no_urut']+'"><i class="fa fa-pencil"></i> Ubah</button> 								<button type="button" class="btn btn-warning del_kandidat" value="'+data['no_urut']+'"><i class="fa fa-trash"></i> Hapus</button> 							 </div> 							<div class="col-lg-4 tocenter"> 								<img src="'+img_address+'/'+data['foto']+'" class="img-circle"> 							 </div>';
						var hidedata = '<input type="hidden" id="kandidat-data-'+data['no_urut']+'" nama_kandidat="'+data['nama_kandidat']+'" tempat_lahir="'+data['tempat_lahir']+'" tanggal_lahir="'+data['tanggal_lahir']+'" visi="'+data['visi']+'" misi="'+data['misi']+'" foto="'+data['foto']+'" />	';
						$("#kandidat-loading").hide();
						$("#alert_success_add").fadeIn("slow",alert_timeout("#alert_success_add"));
						$(".tampil-kandidat").append('<div id="row-kandidat" class="row op_no_urut-'+data['no_urut']+'">'+html+hidedata+'</div>');
						$("#kandidat-close").click();
					}	
					else
					{
						console.log("image too large");
						$("#kandidat-close").click();
						$("#alert_fail").fadeIn("slow");
					}					
				},
				error			: function(data){
					console.log("error");
					console.log(data);
				}
			});
		}
		else
		{
			var url_update = $("#kandidat-link").attr("update_link")+"/"+no_urut+"/"+$("#kandidat-data-"+no_urut).attr("foto");
			$.ajax({
				type			: "POST",
				dataType		: "json",
				url				: url_update,
				data			: formData,
				cache			: false,
				contentType		: false,
				processData		: false,
				beforeSend		: function(){
					$("#kandidat-loading").show();
					$("#alert_fail").hide();
				},
				success			: function(data){
					$("#kandidat-loading").hide();
					if(data["success"] == 1)
					{
						console.log("success");
						$(".op_no_urut-"+no_urut+" div").remove();
						$("#kandidat-data-"+no_urut).remove();
						var img_address = $("#img-preview-kandidat").attr("img-address");
						var html = '<div class="col-lg-8"> 								<div id="no_urut">'+no_urut+'</div> 								 <h4>'+data['nama_kandidat']+'</h4><br /><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-kandidat" data-whatever="'+no_urut+'"><i class="fa fa-pencil"></i> Ubah</button> 								<button type="button" class="btn btn-warning del_kandidat" value="'+data['no_urut']+'"><i class="fa fa-trash"></i> Hapus</button> 							 </div> 							<div class="col-lg-4 tocenter"> 								<img src="'+img_address+'/'+data['foto']+'" class="img-circle"> 							 </div>';
						var hidedata = '<input type="hidden" id="kandidat-data-'+no_urut+'" nama_kandidat="'+data['nama_kandidat']+'" tempat_lahir="'+data['tempat_lahir']+'" tanggal_lahir="'+data['tanggal_lahir']+'" visi="'+data['visi']+'" misi="'+data['misi']+'" foto="'+data['foto']+'" />	';
						$("#kandidat-loading").hide();
						$("#alert_success_update").fadeIn("slow",alert_timeout("#alert_success_update"));
						$(".op_no_urut-"+no_urut).append(html+hidedata);
						$("#kandidat-close").click();	
					}
					else
					{
						console.log("image too large");
						$("#kandidat-close").click();
						$("#alert_fail").fadeIn("slow");
					}
				},
				error			: function(data){
					console.log("error");
					console.log(data);
				}
			});
		}
	}));
	
	$(".vote-me").on("click", function(){
		$.ajax({
			type			: "GET",
			url				: $(this).val(),
			dataType		: "json",
			data			: "",
			cache			: false,
			contentType		: false,
			processData		: false,
			beforeSend		: function(){
				$("#vote-loading").show();
			},
			success			: function(data){
				//console.log(data);
				$("#vote-loading").hide();
				$("#alert_success_vote").fadeIn("slow");
				$(".vote-me").prop("disabled", true);
				$("#polingkandidat"+data["id_kandidat"]+" b").remove();
				$("#polingkandidat"+data["id_kandidat"]).append('<b><i class="fa fa-check-square-o"></i> '+data["hasil_voting"]+' Votes</b>');
			}
		});
	})
});