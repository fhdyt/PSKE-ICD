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
</style>
<div class="row">
  <div class="col-md-12 text-left">
    <button class="btn btn-primary btn-sm tambah" type="button">Tambah Kamus Barang</button>
  </div>
  <hr>
  <div class="col-md-12 text-left">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Kode Barang Departemen</th>
          <th>Nama Barang IT</th>
          <th>Kode Barang LCS</th>
          <th>Nama Barang LCS</th>
          <!-- <th>Aksi</th> -->
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
        <h4 class="modal-title" id="myModalLabel">Tambah Kamus Barang</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:download();" class="fData form-group-sm" id="fData" name="fData">
          <div class="form-group">
            <label for="KODE_INVENTORI_IT">Kode Barang IT</label> <select class="KODE_INVENTORI_IT selectpicker_it with-ajax-personal form-control" data-live-search="true" id="KODE_INVENTORI_IT" name="KODE_INVENTORI_IT">
            </select> <small class="help-block">Kode Barang IT</small>
          </div>
          <div class="form-group">
            <label for="NAMA_BARANG_IT">Nama Barang IT</label> <input autocomplete="off" class="form-control NAMA_BARANG_IT" id="NAMA_BARANG_IT" name="NAMA_BARANG_IT" placeholder="NAMA_BARANG_IT" readonly="readonly" type="text"> <small class="help-block">Nama Barang IT</small>
          </div>
          <div class="form-group">
            <label for="KODE_INVENTORI_LCS">Kode Barang LCS</label> <select class="KODE_INVENTORI_LCS selectpicker_lcs with-ajax-personal form-control" data-live-search="true" id="KODE_INVENTORI_LCS" name="KODE_INVENTORI_LCS">
            </select> <small class="help-block">Kode Barang LCS</small>
          </div>
          <div class="form-group">
            <label for="NAMA_BARANG_LCS">Nama Barang LCS</label> <input autocomplete="off" class="form-control NAMA_BARANG_LCS" id="NAMA_BARANG_LCS" name="NAMA_BARANG_LCS" placeholder="NAMA_BARANG_LCS" readonly="readonly" type="text"> <small class="help-block">Nama Barang LCS</small>
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
function barang_kamus_list(curPage)
{
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
    data: 'ref=barang_kamus_list&batas=' + $('input#REC_PER_HALAMAN').val() + '&halaman=' + curPage + '&keyword=' + $("input#keyword").val(),
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

            $("tbody#zone_data").append("<tr class='detailLogId'  detailLogId='" + data.result[i].ICD_BARANG_KODE + "'>" +
              "<td >" + data.result[i].NO + ".</td>" +
              "<td>" + data.result[i].ICD_BARANG_KODE + "</td>" +
              "<td>" + data.result[i].ICD_BARANG_NAMA + "</td>" +
              "<td>" + data.result[i].ICD_BARANG_LCS_KODE + "</td>" +
              "<td>" + data.result[i].ICD_BARANG_LCS_NAMA_BARANG + "</td>" +

              // "<td></td>" +
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

//var send = new daftar_borongan_harian();
$(function(){ barang_kamus_list('1'); });

$(window).on('hashchange', function(e) {
  barang_kamus_list('1');
});

$("input#REC_PER_HALAMAN").on('change', function() {
  barang_kamus_list('1')
});

function search() {
  barang_kamus_list('1');
}

  $('.FormKirim').on('click', function() {
    var fData = $("#fData").serialize();
      $.ajax({
        type: 'POST',
        url: refseeAPI,
        dataType: 'json',
        data: 'ref=barang_kamus_add&' + fData,
        success: function(data) {
          if (data.respon.pesan == "sukses") {
            $(".modalForm").modal('hide');
            barang_kamus_list('1');
          } else {
            alert(data.respon.text_msg);
          }
        }
      });

  })

  $('.tambah').on('click', function() {
   $(".modalForm").modal('show');
  });


var options = {
  ajax: {
    url: refseeAPI,
    type: 'POST',
    dataType: 'json',
    data: {
      q: '{{{q}}}',
      ref: 'kode_inventori_it',
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
          text: data.result[i].ICD_BARANG_KODE,
          value: data.result[i].ICD_BARANG_KODE,
          data: {
            subtext: data.result[i].ICD_BARANG_NAMA+" "+data.result[i].ICD_BARANG_MERK
          }
        }));
      }
    } else {}
    return array;
  }
};
$('.selectpicker_it').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);
$('select.KODE_INVENTORI_IT').on('change', function() {
  var selectkodeinventori = $('.KODE_INVENTORI_IT option:selected').data('subtext');
  $('input.NAMA_BARANG_IT').val(selectkodeinventori);
});


var options = {
  ajax: {
    url: refseeAPI,
    type: 'POST',
    dataType: 'json',
    data: {
      q: '{{{q}}}',
      ref: 'kode_inventori_lcs',
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
          text: data.result[i].ICD_BARANG_LCS_KODE ,
          value: data.result[i].ICD_BARANG_LCS_KODE,
          data: {
            subtext: data.result[i].ICD_BARANG_LCS_NAMA_BARANG
          }
        }));
      }
    } else {}
    return array;
  }
};
$('.selectpicker_lcs').selectpicker().filter('.with-ajax-personal').ajaxSelectPicker(options);



$('select.KODE_INVENTORI_LCS').on('change', function() {
  var selectkodeinventori = $('.KODE_INVENTORI_LCS option:selected').data('subtext');
  $('input.NAMA_BARANG_LCS').val(selectkodeinventori);
});
</script>
