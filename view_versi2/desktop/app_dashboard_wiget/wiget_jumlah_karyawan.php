
<div class="col-md-3 col-sm-6 col-xs-12">
	<div class="info-box">
		<span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
		<div class="info-box-content">
			<span class="info-box-text">Jumlah Karyawan  </span>
			<span class="info-box-number jumlah_karyawan"><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
			<a href="?show=hrd/master/karyawan/">Tampilkan detail<i class="fa fa-arrow-right"></i></a>
		</div>
		<!-- /.info-box-content -->
	</div>
	<!-- /.info-box -->
</div>

<script>
//ajax get data
function getJumlahKaryawan(){
	$.ajax({type:'POST',url:refseeAPI,dataType:'json',data:'aplikasi=sistem&ref=personal_json_wiget_hrd_data_jumlah_karyawan',
		success:function success(data){ //alert(data.respon.text_msg);
			if(data.respon.pesan=='sukses'){
				$('.jumlah_karyawan').html(data.result.items[0].JUMLAH+' <small>Orang</small>');
			}else{
				$('.jumlah_karyawan').html('0 <small>Orang</small>');
				alert(data.respon.text_msg);
			}
		}
	});
}
$(function(){
	getJumlahKaryawan();
});
</script>
