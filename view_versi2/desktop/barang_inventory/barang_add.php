
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

table {
font-size: 12px;
}

</style>
<div class="row">
  <div class="col-md-12 text-left">
    <button class="btn btn-primary btn-sm tambah" type="button">Tambah Barang</button>
  </div>
  <hr>
  <div class="col-md-12 text-left">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Jenis Kartu Stok</th>
          <th>Jenis Barang</th>
          <th>Spesifikasi</th>
          <th>Merk</th>
          <th>Type</th>
          <th>Keterangan</th>
          <th colspan="2"><center>Aksi</center></th>
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
<div aria-labelledby="myLargeModalLabel" class="modal fade bs-example-modal-lg modalForm" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Barang Departemen</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:download();" class="fData" id="fData" name="fData">
          <div class="form-group">
            <label for="BARANG_NAMA">Nama Barang</label>
            <input autocomplete="off" class="form-control BARANG_NAMA" id="BARANG_NAMA" name="BARANG_NAMA" placeholder="BARANG_NAMA" type="text">
              <input autocomplete="off" class="form-control KODE_BARANG_MASTER" id="KODE_BARANG_MASTER" name="KODE_BARANG_MASTER" placeholder="KODE_BARANG_MASTER" type="hidden">
            <small class="help-block">Nama Barang IT</small>
          </div>
          <div class="form-group">
            <label for="BARANG_JENIS">Jenis Barang</label> <input autocomplete="off" class="form-control BARANG_JENIS" id="BARANG_JENIS" name="BARANG_JENIS" placeholder="BARANG_JENIS" type="text"> <small class="help-block">Jenis Barang : KEYB, MOU, MTR, dll</small>
          </div>
           <div class="form-group">
            <label for="KARTU_STOK">Jenis Kartu Stok</label>
            <select id="KARTU_STOK" name="KARTU_STOK"  type="text" class="form-control KARTU_STOK"  autocomplete="off" required>

          </select>
             <small class="help-block">Jenis Kartu Stok</small>
          </div>
          <div class="form-group">
            <label for="SATUAN">Satuan</label>
            <select id="SATUAN" name="SATUAN"  type="text" class="form-control SATUAN"  placeholder="SATUAN"  autocomplete="off" required>

          </select>
             <small class="help-block">Satuan Barang</small>
          </div>
          <div class="form-group">
            <label for="BARANG_TYPE">Type</label> <input autocomplete="off" class="form-control BARANG_TYPE" id="BARANG_TYPE" name="BARANG_TYPE" placeholder="BARANG_TYPE" type="text"> <small class="help-block">Type Barang IT</small>
          </div>
          <div class="form-group">
            <label for="BARANG_MERK">Merk</label> <input autocomplete="off" class="form-control BARANG_MERK" id="BARANG_MERK" name="BARANG_MERK" placeholder="BARANG_MERK" type="text"> <small class="help-block">Merk Barang IT</small>
          </div>
          <div class="form-group">
            <label for="BARANG_SPESIFIKASI">Spesifikasi</label>
            <textarea class="form-control BARANG_SPESIFIKASI" id="BARANG_SPESIFIKASI" name="BARANG_SPESIFIKASI" placeholder="BARANG_SPESIFIKASI"></textarea> <small class="help-block">Spesifikasi Brang IT</small>
          </div>
          <div class="form-group">
            <label for="BARANG_KETERANGAN">Keterangan</label>
            <textarea class="form-control BARANG_KETERANGAN" id="BARANG_KETERANGAN" name="BARANG_KETERANGAN" placeholder="BARANG_KETERANGAN"></textarea> <small class="help-block">Isi jika diperlukan</small>
          </div>
          <div class="form-group">
            <button class="btn btn-success btn-sm FormKirim">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
function barang_list(curPage) {
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
    data: 'ref=barang_list&batas=' + $('input#REC_PER_HALAMAN').val() + '&halaman=' + curPage + '&keyword=' + $("input#keyword").val(),
    success: function(data) {
      if (data.respon.pesan == "sukses") {
        $("tbody#zone_data").empty();
        $('#tujuan-light-pagination').pagination({
          pages: data.result_option.jml_halaman,
          cssStyle: 'light-theme',
          currentPage: curPage,
        });
        for (i = 0; i < data.result.length; i++) {
          $("tbody#zone_data").append("<tr class='detailLogId'  detailLogId='" + data.result[i].ICD_BARANG_INDEX + "'>" + "<td >" + data.result[i].NO + ".</td>" + "<td>" + data.result[i].ICD_BARANG_KODE + "</td>" + "<td>" + data.result[i].ICD_BARANG_NAMA + "</td>" +
          "<td>" + data.result[i].ICD_JENIS_KARTU_STOK + "</td>" +
          "<td>" + data.result[i].ICD_BARANG_JENIS + "</td>" +
          "<td>" + data.result[i].ICD_BARANG_SPESIFIKASI + "</td>" +
          "<td>" + data.result[i].ICD_BARANG_MERK + "</td>" +
          "<td>" + data.result[i].ICD_BARANG_TYPE + "</td>" +
          "<td>" + data.result[i].ICD_BARANG_KETERANGAN + "</td>" +
          "<td><a class='btn btn-success btn-sm edit_barang' ICD_BARANG_INDEX='" + data.result[i].ICD_BARANG_INDEX + "' ICD_BARANG_KODE='" + data.result[i].ICD_BARANG_KODE + "' ICD_BARANG_NAMA='" + data.result[i].ICD_BARANG_NAMA + "' ICD_BARANG_JENIS='" + data.result[i].ICD_BARANG_JENIS + "' WO_UNIT_ID='" + data.result[i].WO_UNIT_ID + "' ICD_BARANG_SPESIFIKASI='" + data.result[i].ICD_BARANG_SPESIFIKASI + "' ICD_JENIS_KARTU_STOK='" + data.result[i].ICD_JENIS_KARTU_STOK + "' ICD_BARANG_MERK='" + data.result[i].ICD_BARANG_MERK + "' ICD_BARANG_TYPE='" + data.result[i].ICD_BARANG_TYPE + "' ICD_BARANG_KETERANGAN='" + data.result[i].ICD_BARANG_KETERANGAN + "' ><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a></td>" +
          "<td><a class='btn btn-danger btn-sm hapus_barang' ICD_BARANG_KODE='" + data.result[i].ICD_BARANG_KODE + "'><i class='fa fa-trash' aria-hidden='true'></i> Hapus</a></td>" +
          "</tr>");
        }
      } else if (data.respon.pesan == "gagal") {
        $("tbody#zone_data").html("<tr><td colspan='9'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> barang_kamus_list()');
    } //end error
  });
}
$(function() {
  barang_list('1');
});
$(window).on('hashchange', function(e) {
  barang_list('1');
});
$("input#REC_PER_HALAMAN").on('change', function() {
  barang_list('1')
});

function search() {
  barang_list('1');
}
$('.FormKirim').on('click', function() {
  function barang_add() {
    var fData = $("#fData").serialize();

    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data: 'ref=barang_add&' + fData,
      success: function(data) {
        if (data.respon.pesan == "sukses") {
          $(".modalForm").modal('hide');
          barang_list('1');
        } else {
          alert(data.respon.text_msg);
        }
      }
    });
  }
  if (confirm('Apakah anda sudah yakin dengan isian form yang akan dikirim? Setelah form dikirim, tidak dapat diubah.')) {
    $(function() {
      barang_add();
    });
  }
})
$('.tambah').on('click', function() {
  $('#fData')[0].reset();
  $('.KODE_BARANG_MASTER').val("");
  $(".modalForm").modal('show');
});

function kartu_stok() {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=kartu_stok',
    success: function(data) {
      if (data.respon.pesan == "gagal") {
        alert(adfadf);
      } else {
        // $('div.SRC_BPG_SPAN').html('<select id="BPG" name="BPG" class="col-sm-2 form-control BPG"  autocomplete="off" >');
        for (s = 0; s < data.result.length; s++) {
          $('select.KARTU_STOK').append('<option value="' + data.result[s].ICD_JENIS_KARTU_STOK + '">' + data.result[s].ICD_JENIS_KARTU_STOK + '</option>');
        }
      }
    }
  });
}
$(function() {
  kartu_stok();
});

function satuan() {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=satuan',
    success: function(data) {
      if (data.respon.pesan == "gagal") {
        alert(adfadf);
      } else {

        for (s = 0; s < data.result.length; s++) {
          $('select.SATUAN').append('<option value="' + data.result[s].WO_UNIT_ID + '">' + data.result[s].WO_UNIT_DESCRIPTION + '</option>');
        }
      }
    }
  });
}
$(function() {
  satuan();
});


$('tbody#zone_data').on('click', 'a.edit_barang', function(){
  console.log("edit");
  var ICD_BARANG_INDEX = $(this).attr("ICD_BARANG_INDEX");
  var ICD_BARANG_KODE = $(this).attr("ICD_BARANG_KODE");
  var ICD_BARANG_NAMA = $(this).attr("ICD_BARANG_NAMA");
  var ICD_BARANG_JENIS = $(this).attr("ICD_BARANG_JENIS");
  var WO_UNIT_ID = $(this).attr("WO_UNIT_ID");
  var ICD_BARANG_SPESIFIKASI = $(this).attr("ICD_BARANG_SPESIFIKASI");
  var ICD_JENIS_KARTU_STOK = $(this).attr("ICD_JENIS_KARTU_STOK");
  var ICD_BARANG_MERK = $(this).attr("ICD_BARANG_MERK");
  var ICD_BARANG_TYPE = $(this).attr("ICD_BARANG_TYPE");
  var ICD_BARANG_KETERANGAN = $(this).attr("ICD_BARANG_KETERANGAN");

  $('.KODE_BARANG_MASTER').val(ICD_BARANG_KODE);
  $('.BARANG_NAMA').val(ICD_BARANG_NAMA);
  $('.BARANG_JENIS').val(ICD_BARANG_JENIS);
  $('.KARTU_STOK').val(ICD_JENIS_KARTU_STOK);
  $('.SATUAN').val(WO_UNIT_ID);
  $('.BARANG_TYPE').val(ICD_BARANG_TYPE);
  $('.BARANG_MERK').val(ICD_BARANG_MERK);
  $('.BARANG_SPESIFIKASI').val(ICD_BARANG_SPESIFIKASI);
  $('.BARANG_KETERANGAN').val(ICD_BARANG_KETERANGAN);

  $(".modalForm").modal('show');

})


function barang_hapus(barang_kode) {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data: 'ref=barang_hapus&KODE_BARANG=' + barang_kode,
    success: function(data) {
      if (data.respon.pesan == "sukses") {
        console.log("Sukses Hapus");
        barang_list('1');
      } else {
        alert(data.respon.text_msg);
      }
    }
  });
}

$('tbody#zone_data').on('click', 'a.hapus_barang', function(){
  var barang_kode = $(this).attr("ICD_BARANG_KODE");
  if(confirm("Apakah anda sudah yakin menghapus barang ?"))
  {
    barang_hapus(barang_kode);
  }

})
</script>
