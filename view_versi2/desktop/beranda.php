<?php

//$aplikasi_user_aktif=$CD::aplikasi_user_aktif(array('data_http'=>$_COOKIE['data_http']));
require_once('menu_sidebar.php');

//echo "<pre>".print_r($aplikasi_user_aktif,true)."</pre>";

//$menu_user_aktif=$CD::menu_user_aktif(array('data_http'=>$_COOKIE['data_http'],'url_parameter'=>$url_parameter[1],));
//echo "<pre>".print_r($menu_user_aktif,true)."</pre>";




?>         


<!------------------------------------------------------------------>
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  
     <?php
	 //config breadcrumb halaman
		$adminLTE->breadcrumb(array(
			'title'=>"ICD",
			'title_sub'=>"1.0",
			'breadcrumb'=>array(
				// array('title'=>"Transaction",'link'=>"#"),
				//array('title'=>"Wiget",'link'=>"#"),
				//array('title'=>"more title",'link'=>"#"),
			),
		));
		
		
	 ?>
	


    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row box1" id="PlatformWiget">
		  
		<?php  
			foreach($user_wiget['result']['items']['box1'] as $wd){
				$APP_DASHBOARD=new APP_DASHBOARD();
				$APP_DASHBOARD->wiget(array('case'=>$wd['USER_DASHBOARD_CASE_NAME'],'dir_versi'=>$aplikasi_user_aktif['aktif'][0]['USER_APLIKASI_UI_DIR'],'USER_APLIKASI_ID'=>$wd['USER_APLIKASI_ID']));
			}
        ?>
         
      </div>
      <!-- /.row -->
      
      
      
      
      <!---------------------------------------------ISI----------------------------------------->
      
        			
		<div class="row">
			<div class="col-md-12">	
			<?php

			switch(strtoupper($d2)){

				case 'KATALOG_KOMPUTER' :
					require_once("katalog_komputer/katalog_komputer.php");
				break;
				default:
					require_once("barang_inventory/barang_inventory.php");
				break;
			}
			?>
			</div>


		</div><!--/row-->
      
      <!-----------------------------END ISI------------------------->
      
      
      



      
      
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
<script>
$(function(){
	$( "div[class^='notification-version']" ).hide();
});	
//config
//http://bootstraptour.com/api/	
var tour = new Tour({
	backdrop: true,
	storage: false 
});

// Add your steps. Not too many, you don't really want to get your users sleepy
tour.addSteps([{
  element: "#PlatformHeader", // string (jQuery selector) - html element next to which the step popover should be shown
  title: "Header Bar", // string - title of the popover
  content: "Bagian ini merupakan ", // string - content of the popover
  placement: "bottom",
},{
  element: "#PlatformMenu", // string (jQuery selector) - html element next to which the step popover should be shown
  title: "Kotak Pencarian", // string - title of the popover
  content: "Bagian ini merupakan kotak untuk memasukan kata kunci pencarian", // string - content of the popover
  placement: "right",
},{
  element: "#PlatformWiget", // string (jQuery selector) - html element next to which the step popover should be shown
  title: "Kotak Pencarian", // string - title of the popover
  content: "Bagian ini merupakan kotak untuk memasukan kata kunci pencarian", // string - content of the popover
  placement: "top",
},{
  element: "#PlatformHitoriAplikasi", // string (jQuery selector) - html element next to which the step popover should be shown
  title: "Notifikasi", // string - title of the popover
  content: "Bagian ini adalah fitur notifikasi, setiap ada pemberitahuan akan muncul disini", // string - content of the popover
  placement: "top",
}]);

// Initialize the tour
tour.init();

$('.PlatformTourStart').on('click',function(){ 
	// Start the tour
    if(tour.start()){
        tour.restart();
    }
});

</script>
