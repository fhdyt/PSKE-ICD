<?php $INVENTORY_CONFIG=new INVENTORY_CONFIG();
//$station_id = $INVENTORY_CONFIG->station_id();
?>
<style>
.loader {
  border: 5px solid #f3f3f3;
  border-radius: 50%;
  border-top: 5px solid #3498db;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.modal-stationid{
  width:100;
}
</style>
<script src="aplikasi/<?php echo $_SESSION['aplikasi']; ?>/asset/js/jquery.mask.min.js" type="text/javascript"></script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="list-group">
			<div class="list-group-item">
				<div class="row">
					<div class="col-md-8">
						<h3><i class="fa fa-desktop"></i> <?php echo  $BAHASA->terjemahkan("Katalog Komputer");?></h3>
						<hr>
					</div>
					<div class="col-md-4 text-right"></div>
				</div><!--/.row-->
				<div class="row">
					<div class="col-md-12 text-left">
						<button class="btn btn-primary btn-sm tambah" type="button"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Station ID</button>
					</div>
				</div><br>
				<div class="row">
					<div class="col-md-12 text-left">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Station ID</th>
									<th>IP Address</th>
									<th>Penanggung<br>Jawab</th>
									<th>Departemen</th>
									<th>Lokasi</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody id="zone_data">
				<tr>
					<td colspan="9">
						<center>
							<div class="loader"></div>
						</center>
					</td>
				</tr>
			</tbody>
						</table>
					</div>
				</div>
        <div class="row">
          <div class="col-md-9">
            <div class="pagination-holder clearfix">
              <div class="pagination" id="tujuan-light-pagination"></div>
            </div>
          </div>
          <div class="col-md-3 text-right">
            <label>Jumlah Baris Per Halaman</label> <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="10">
          </div>
        </div><!--/row-->
			</div><!--/.list-group-item-->
		</div><!--/.list-group-->
	</div><!--/.col-->
</div><!--/.row-->

<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalForm" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Tambah Station ID</h4>
			</div>
			<div class="modal-body">
				<form action="javascript:download();" class="fData" id="fData" name="fData">
					<div class="form-group">
						<label for="LOKASI">Station ID</label> <input autocomplete="off" class="form-control STATION_ID_ID" id="STATION_ID_ID" name="STATION_ID_ID" placeholder="STATION_ID_ID" value="<?php echo $station_id; ?>" type="text">
						<small class="help-block"><span class="ck_station_id">Station ID</span></small>
					</div>
					<div class="form-group">
						<label for="LOKASI">Lokasi</label> <input autocomplete="off" class="form-control LOKASI" id="LOKASI" name="LOKASI" placeholder="LOKASI" type="text">
						<small class="help-block">Lokasi Station ID di Departemen</small>
					</div>
					<div class="form-group">
						<label for="DEPARTEMEN">Departemen</label> <select class="col-sm-2 form-control DEPARTEMEN" id="DEPARTEMEN" name="DEPARTEMEN" onchange="onchange_bh_company_unit()" required="">
							<option value="">
								--Pilih--
							</option>
									<?php
									$data = $INVENTORY_CONFIG->departemen();

									foreach ($data['rasult'] as $key => $value) {
									    foreach ($value as $data => $isi) {
									        ?>
							<option value="<?php echo $isi['COMPANY_UNIT_ID']; ?>">
								<?php  echo $isi['COMPANY_UNIT_NAME'];?>
							</option>
									<?php
									    }

									}
									?>
						</select>
						<small class="help-block">Departemen Station ID</small>
					</div>
					<div class="form-group">
						<label for="PENANGGUNG_JAWAB">Penanggung Jawab</label>
						<select name="PENANGGUNG_JAWAB" id="PENANGGUNG_JAWAB" class="PENANGGUNG_JAWAB selectpicker with-ajax-personal form-control"  data-live-search="true">
						</select>
						<small class="help-block">Penanggung Jawab Station ID</small>
					</div>
					<div class="form-group">
						<label for="KONDISI">Kondisi</label> <input autocomplete="off" class="form-control KONDISI" id="KONDISI" name="KONDISI" placeholder="KONDISI" stype="text">
						<small class="help-block">Kondisi</small>
					</div>
					<div class="form-group">
						<label for="KETERANGAN">Keterangan</label>
						<textarea class="form-control KETERANGAN" id="KETERANGAN" name="KETERANGAN" placeholder="KETERANGAN"></textarea>
						<small class="help-block">Isi Jika Diperlukan</small>
					</div>
					<div class="form-group">
						<table class="table">
							<tr>
								<th>IP Address</th>
								<th>MAC Address</th>
								<th></th>
							</tr>
							<tbody id="dynamic_field">
								<tr>
									<td>
										<input class="form-control IP_ADDRESS_ZERO" id="IP_ADDRESS_ZERO" name="IP_ADDRESS[0]" placeholder="IP_ADDRESS" type="text" autocomplete="off" >
										<small class="help-block">IP Address : 192.168.1.1</small>
									</td>
									<td>
										<input autocomplete="off" class="form-control MAC_ADDRESS_ZERO" id="MAC_ADDRESS_ZERO" name="MAC_ADDRESS[0]" placeholder="MAC_ADDRESS" type="text">
										<small class="help-block">Mac Address : 00:13:d3:f1:37:8e</small>
									</td>
									<td>
										<center>
											<button type="button" name="add" id="add" class="btn btn-primary add"><i class="fa fa-plus"></i></button>
										</center>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="form-group">
						<button class="btn btn-success btn-sm FormKirim">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div aria-labelledby="myLargeModalLabel" class="modal bs-example modalFormStationID" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-stationid" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Station ID</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-hover table-gudang">
					<thead></thead>
					<tbody id="zone_gudang">
						<tr>
							<td colspan="9">
								<center>
									<div class="loader"></div>
								</center>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$('.tambah').on('click', function() {
	 $(".modalForm").modal('show');
	});

$('tbody#zone_data').on('click', 'a.station_id_detail', function()
{

	var detail = $(this).attr('ICD_STATION_ID');
	station_id_info(detail);
});

$(document).ready(function(){
   $('.IP_ADDRESS_ZERO').mask('0ZZ.0ZZ.0ZZ.0ZZ', {translation: {'Z': {pattern: /[0-9]/, optional: true}}});
  $('.MAC_ADDRESS_ZERO').mask('ZZ:ZZ:ZZ:ZZ:ZZ:ZZ', {translation: {'Z': {pattern: /[A-Za-z0-9]/, optional: true}}});
});

function station_id_list(curPage) {
  var url = window.location.href;
  var pageA = url.split("#");
  if (pageA[1] == undefined) {} else {
    var pageB = pageA[1].split("page-");
    if (pageB[1] == '') {
      var curPage = curPage;
    } else {
      var curPage = pageB[1];
    }
  }
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=station_id_list&batas=' + $('input#REC_PER_HALAMAN').val() + '&halaman=' + curPage + '&keyword=' + $("input#keyword").val(),
    success: function(data)
    {
		if (data.respon.pesan == "sukses")
		{
      $("tbody#zone_data").empty();
      $('#tujuan-light-pagination').pagination({
        pages: data.result_option.jml_halaman,
        cssStyle: 'light-theme',
        currentPage: curPage,
      });
	        for (i = 0; i < data.result.length; i++)
	        {

            if (data.result[i].APLIKASI == 'GAGAL')
            {
              var tr = "warning";
            }
            else if (data.result[i].ITEM == 'GAGAL')
            {
              var tr = "danger";
            }
            else
            {
              var tr = "";
            }
	          $("tbody#zone_data").append("<tr class='" + tr + "'  ICD_STATION_ID='" + data.result[i].ICD_STATION_ID + "'>" +
	            "<td >" + data.result[i].NO + ".</td>" +
	            "<td>" + data.result[i].ICD_STATION_ID + "</td>" +
	             "<td>" + data.result[i].ICD_IP_ADDRESS + "</td>" +
	            "<td>" + data.result[i].PERSONAL_NAME + "</td>" +
	            "<td>" + data.result[i].DEPT + "</td>" +
	            "<td>" + data.result[i].ICD_STATION_ID_LOKASI + "</td>" +


	            "<td><a class='btn btn-primary btn-sm station_id_item' type='button' STATION_ID=" + data.result[i].ICD_STATION_ID + "><i class='fa fa-list-ul' aria-hidden='true'></i> Item</a> <a class='btn btn-success btn-sm station_id_detail' type='button' ICD_STATION_ID=" + data.result[i].ICD_STATION_ID + "><i class='fa fa-list-ul' aria-hidden='true'></i> Detail</a></td>" +
			    "</tr>");
	        }
		}
		else if(data.respon.pesan == "gagal")
		{
			$("tbody#zone_data").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
		}
    }, //end success
    error: function(x, e)
    {
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}

$(function() {
  station_id_list('1');
});
$(window).on('hashchange', function(e) {
  station_id_list('1');
});
$("input#REC_PER_HALAMAN").on('change', function() {
  station_id_list('1')
});

function search() {
  station_id_list('1');
}

$('.FormKirim').on('click', function() {
	var fData = $("#fData").serialize();
	var IP_ADDRESS_ZERO = $("#IP_ADDRESS_ZERO").val();
	var MAC_ADDRESS_ZERO = $("#MAC_ADDRESS_ZERO").val();

	var IP_ADDRESS = $("#IP_ADDRESS").val();
	// if (IP_ADDRESS_ZERO != "")
	// {
	// 	alert("Tambahkan IP Address");
	// }
	// else if (MAC_ADDRESS_ZERO != "")
	// {
	// 	alert("Tambahkan IP Address");
	// }
//
	// else
	// {


		if ($("#PENANGGUNG_JAWAB").val() == null)
		{
			alert("Penanggung Jawab Tidak Boleh Kosong")
		}
		else if ($("#IP_ADDRESS_ZERO").val() === "")
		{
			alert("IP Address Tidak Boleh Kosong")
		}
		else if ($("#STATION_ID_ID").val() === "")
		{
			alert("Station ID Tidak Boleh Kosong")
		}
		else if ($("#DEPARTEMEN").val() === "")
		{
			alert("Departemen Tidak Boleh Kosong")
		}
		else
		{
			$.ajax({
				type: 'POST',
				url: refseeAPI,
				dataType: 'json',
				data: 'ref=station_id_add&' + fData,
				success: function(data) {
					if (data.respon.pesan == "sukses") {
						$(".modalForm").modal('hide');
						station_id_list();
					} else {
						alert(data.respon.text_msg);
					}
				}
			});
		}
//	}
});

	var options = {
  ajax: {
    url: refseeAPI,
    type: 'POST',
    dataType: 'json',
    data: {
      q: '{{{q}}}',
      ref: 'penanggung_jawab',
    }
  },
  locale: {
    emptyTitle: ' '
  },
  log: 3,
  preprocessData: function(data) {
    var i, l = data.result.length,
      array = [];

    if (l) {
      for (i = 0; i < l; i++) {
        array.push($.extend(true, data.result[i], {
          text: data.result[i].PERSONAL_NAME,
          value: data.result[i].PERSONAL_NIK,
          data: {
            subtext: data.result[i].PERSONAL_NIK +" ("+ data.result[i].COMPANY_UNIT_SHORT_NAME + ")"
          }
        }));
      }
    } else {}
    return array;
  }
};
$('.selectpicker').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);

$('tbody#zone_data').on('click', 'a.station_id_item', function()
{
var station_id = $(this).attr('STATION_ID');
	 window.location.replace( '?show=inventory_dept/inventory_condept/station_id_detail/'+station_id+'' );
});

$(document).ready(function()
{
     var i=1;

     $('#add').click(function()
     {
       var ip= $("input.IP_ADDRESS_ZERO").val();
       var mac= $("input.MAC_ADDRESS_ZERO").val();
          i++;
          $('#dynamic_field').append('<tr id="row'+i+'">'+
          '<td><input type="text" name="IP_ADDRESS['+i+']" value="'+ip+'" placeholder="Enter your Name" class="form-control" /></td>'+
          '<td><input type="text" name="MAC_ADDRESS['+i+']" value="'+mac+'" placeholder="Enter your Name" class="form-control" /></td>'+
          '<td><center><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></center></td></tr>');

            $('input.IP_ADDRESS_ZERO').val('');
  $('input.MAC_ADDRESS_ZERO').val('');
     });
     $(document).on('click', '.btn_remove', function(){
          var button_id = $(this).attr("id");
          $('#row'+button_id+'').remove();
     });

});

function station_id_info(detail)
{
	$(".modalFormStationID").modal('show');
	$.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=station_id_info&ICD_STATION_ID='+detail,
    success: function(data)
    {
		//alert(data.respon.pesan);
		if (data.respon.pesan == "sukses")
		{
			$("tbody#zone_gudang").empty();
	        for (i = 0; i < data.result.length; i++)
	        {
$("tbody#zone_gudang").append("<tr>" +
	            "<td >Station ID</td>" +
				"<td>" + data.result[i].ICD_STATION_ID+ "</td>" +
			    "</tr>"+
			    "<tr>" +
			    "<td >Lokasi</td>" +
				"<td>" + data.result[i].ICD_STATION_ID_LOKASI+ "</td>" +
			    "</tr>"+
			    "<tr>"+
			    "<td >Departemen</td>" +
				"<td>" + data.result[i].DEPT+ "</td>" +
			    "</tr>"+
			    "<tr>"+
			    "<td >Penanggung Jawab NIK</td>" +
				"<td>" + data.result[i].PERSONAL_NIK+ "</td>" +
			    "</tr>"+
			    "<tr>" +
	            "<td >Penanggung Jawab</td>" +
				"<td>" + data.result[i].PERSONAL_NAME+ "</td>" +
			    "</tr>" +
			    "<tr>" +
	            "<td >Kondisi</td>" +
				"<td>" + data.result[i].ICD_STATION_ID_KONDISI+ "</td>" +
			    "</tr>" +
			    "<tr>" +
	            "<td >Keterangan</td>" +
				"<td>" + data.result[i].ICD_STATION_ID_KETERANGAN+ "</td>" +
			    "</tr>" +
			    "<tr>"+
			    "<td></td><td></td>"+
			    "</tr>"+
			    "<td><b>IP ADDRESS</b></td>" +
				"<td><b>MAC ADDRESS</b></td>" +
			    "</tr>"+
			    data.result[i].IP

			    );
	        }

		}
		else if(data.respon.pesan == "gagal")
		{

			$("tbody#zone_data").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
		}
    }, //end success
    error: function(x, e)
    {
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}



var delay = (function()
{
	var timer = 0;
	return function(callback, ms)
	{
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	};
})();

$('input.STATION_ID_ID').keyup(function()
{
	var STATION_ID = $(this).val();
	$("button.FormKirim").attr("disabled", "disabled");
	$(".ck_station_id").html("<span class='text-danger'>Checking...</span>");
	delay(function()
	{
    if (STATION_ID.length > 7)
    {
      $("button.FormKirim").attr("disabled", "disabled");
      $(".ck_station_id").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Station ID Tidak Valid</span>");
    }
    else if (STATION_ID.length < 7)
    {
      $("button.FormKirim").attr("disabled", "disabled");
      $(".ck_station_id").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Station ID Tidak Valid</span>");
    }
    else
    {
		    cek_station_id(STATION_ID);
    }
	}, 500);
});

function cek_station_id(STATION_ID)
{

	console.log(STATION_ID);
	$.ajax({
		type: 'POST',
		url: refseeAPI,
		dataType: 'json',
		data: 'ref=cek_station_id&STATION_ID=' + STATION_ID,
		success: function(data)
		{
      console.log(data.respon.pesan);
			if (data.respon.pesan == "sukses")
			{
				for (i = 0; i < data.result.length; i++)
				{

						$("button.FormKirim").attr("disabled", "disabled");
						$(".ck_station_id").html("<span class='text-danger'><i class='glyphicon glyphicon-remove-circle'></i> Station ID telah terdaftar. <a href='?show=inventory_dept/inventory_condept/station_id_detail/"+data.result[i].ICD_STATION_ID+"'>Edit</a></span>");

				}
			}
			else
			{
        $("button.FormKirim").removeAttr("disabled");
        $(".ck_station_id").html("<span class='text-success'><i class='glyphicon glyphicon-ok-circle'></i> Station ID Tersedia.</span>");
			}
		}
	});
}
</script>
