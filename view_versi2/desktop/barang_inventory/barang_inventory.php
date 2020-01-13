<?php 
if(empty($d3)){
    $d3="barang_add";
}else{
    $d3=$d3;
}
?>
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="list-group">
				<div class="list-group-item">
					<div class="row">
						<div class="col-md-8">
							<h3><i class="fa fa-cube"></i> <?php echo  $BAHASA->terjemahkan("Master Barang");?></h3>
						</div>
						<div class="col-md-4 text-right"></div>
					</div><!--/.row-->
					<div class="row">
						<div class="col-md-8 text-left">
						</div>
						<div class="col-md-4 text-right"></div>
					</div><br>
					<div class="row">
						<ul class="nav nav-tabs">
							<!--<li role="presentation" id="saldo" class=""><a href="?show=hrd/surat/cuti/saldo/">Saldo Cuti</a></li> -->
							<li id="barang_add" role="presentation">
								<a href="?show=inventory_dept/inventory_condept/barang_inventory/barang_add">Barang Departemen</a>
							</li>
							<li id="barang_lcs_add" role="presentation">
								<a href="?show=inventory_dept/inventory_condept/barang_inventory/barang_lcs_add">Barang LCS</a>
							</li>
							<li id="barang_kamus" role="presentation">
								<a href="?show=inventory_dept/inventory_condept/barang_inventory/barang_kamus">Kamus Barang</a>
							</li>
						</ul><br>
						<script>
						                           $(function(){
						                               $(".nav-tabs li").removeClass('active');
						                               $(".nav-tabs li#<?php echo $d3; ?>").addClass('active');
						                           });
						</script>
					</div>
					<div class="row">
						<div class="col-md-12 text-left">
							<?php
							if ($d3 == 'barang_add') {
							    require_once("barang_add.php");
							} elseif ($d3 == 'barang_lcs_add') {
							    require_once("barang_lcs_add.php");
							} elseif ($d3 == 'barang_kamus') {
							    require_once("barang_kamus.php");
							}else {
							    require_once("barang_add.php");
							}
							?>
							<!-- <table class="table table-bordered">
								<tr>
									<td>No.</td>
									<td>Kode Inventori</td>
									<td>Nama Barang</td>
									<td>Nama Barang LCS</td>
									<td>Kode Barang LCS</td>
									<td>Jenis Barang</td>
									<td>Spesifikasi</td>
									<td>Aksi</td>
								</tr>
							</table> -->
						</div>
					</div>
				</div><!--/.list-group-item-->
			</div><!--/.list-group-->
		</div><!--/.col-->
	</div><!--/.row-->
