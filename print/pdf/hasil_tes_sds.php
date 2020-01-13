<?php
$data=array(
	'participantstest_id'=>$d3,
);
 
$cr_data=array(
	'case'=>"nilai_tes_sds_443",
	'batas'=>1,
	'halaman'=>1,
	'user_privileges_data'=>$_COOKIE['data_http'],
	'data'=>$data,
);

$SW=new SWITCH_DATA();
$SW->data_location="local"; //local,external
$SW->cr_data=$cr_data;
$SW->CLS=new recruitment_participants(); //nama class -> khusus untuk local data.
$SW->ref="recruitment_participants"; //nama file --> khusus untuk external data
$da=$SW->output(); 
#echo "<pre>".print_r($da,true)."</pre>";

foreach($da['refs'] as $row){
	$nilaites[]=$row;
}
foreach($nilaites[0]['Participants'] as $row_Participants){
	$participants[]=$row_Participants;
}
foreach($nilaites[0]['Topik_soal'] as $row_Topik_soal){
	$topiksoal[]=$row_Topik_soal;
}
foreach($nilaites[0]['Cita'] as $row_Cita){
	$cita[]=$row_Cita;
}
foreach($nilaites[0]['Jawab_19'] as $row_Jawab_19){
	$menilai_diri[]=$row_Jawab_19;
}
//---------------------------------------------------------------------
?>
<html
    xmlns:o='urn:schemas-microsoft-com:office:office'
    xmlns:w='urn:schemas-microsoft-com:office:word'
    xmlns='http://www.w3.org/TR/REC-html40'>
    <head>
        <title>Generate a document Word</title>
        <!--[if gte mso 9]-->
    <xml>
        <w:WordDocument>
            <w:View>
    Print</w:View>
<w:Zoom>90</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <!-- [endif]-->
    <style>
        p.MsoFooter, li.MsoFooter, div.MsoFooter{
            margin: 0cm;
            margin-bottom: 0001pt;
            mso-pagination:widow-orphan;
            font-size: 9.0 pt;
            text-align: right;
        }


        @page Section1{
           /* size: 29.7cm 21cm;
			size:21.59 cm*/
			size:21.59 cm;
            margin: 3cm 1cm 1cm 1cm;
            mso-page-orientation: portrait;
            /*mso-page-orientation: landscape;*/
            mso-footer:f1;
        }
        div.Section1 { page:Section1;}
.style3 {font-size: 12px}
    .style4 {font-size: 11px}
	.tdb{font-size:18px;}
	.tds{font-size:18px; color:#E00;}
    .Section1 table {
	font-size: 13px;
}
    </style>
</head>
<body>
<?php
ini_set("memory_limit","512M");
ini_set("max_execution_time","120");
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Daftar_Nilai_SDS.doc");			
		 ?>
<style type="text/css">
<!--
.style4 {font-size: 11px}
-->
</style>
<div class="Section1">
        <!--Buat ISI-->
<div style="float:left; font-size:20px; color:#000000; border-bottom:2px double #000; width:100%; text-align:center;"><b>INFORMASI PENGERJAAN SOAL - <?php echo  $nilaites[0]['TOPIK_JUDUL'];?></b></div>
<br /><div style="clear:both;"></div> 
<b>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="50%" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="39%">Nama Lengkap</td>
                    <td width="2%">:</td>
                    <td width="59%"><?php echo $participants[0]['PESERTA_NAMA'];?></td>
                 </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $participants[0]['PESERTA_EMAIL'];?></td>
                 </tr>
                <tr>
                    <td>Pendidikan</td>
                    <td>:</td>
                    <td><?php echo $nilaites[0]['TINGKATPENDIDIKAN_NAMA']; ?></td>
                 </tr>
                <tr>
                    <td>Posisi yg dilamar</td>
                    <td>:</td>
                    <td><?php echo $nilaites[0]['LOWONGANKERJA_NAMA']; ?></td>
                 </tr>
                 <tr>
                    <td>No.Telp</td>
                    <td>:</td>
                    <td><?php echo $participants[0]['PESERTA_NO_HP'];?></td>
                 </tr>
             </table>
          	</td>
      		<td width="50%" valign="top">
           		            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="45%">Waktu Max Peng. Soal</td>
                    <td width="2%">:</td>
                    <td width="53%">
						<?php
													$detik=$topiksoal[0]['TOPIKSOAL_WAKTUP'];
													//konvert detik ke jam menit detik
													$jam = floor($detik/3600);
													//Untuk menghitung jumlah dalam satuan menit:
													$sisa = $detik% 3600;
													$menit = floor($sisa/60);
													//Untuk menghitung jumlah dalam satuan detik:
													$sisa = $sisa % 60;
													$detik = floor($sisa/1);
													?>
                                                    
                                                    <?php echo"$jam jam $menit menit $detik detik";?>
                    </td>
                 </tr>
                <tr>
                    <td>Waktu Mulai</td>
                    <td>:</td>
                    <td><?php echo $nilaites[0]['waktu_mulai'];?></td>
                 </tr>
                <tr>
                    <td>Waktu Selesai</td>
                    <td>:</td>
                    <td><?php echo $nilaites[0]['waktu_selesai'];?></td>
                 </tr>
                <tr>
                    <td>Total Waktu Peng. Soal</td>
                    <td>:</td>
                    <td>
						<?php 
							$waktu_mulai=$nilaites[0]['waktu_mulai'];
							$waktu_selesai	=$nilaites[0]['waktu_selesai'];
							$kini = new DateTime($waktu_mulai);  
							$kemarin = new DateTime($waktu_selesai);  
							echo $kemarin->diff($kini)->format('%h jam %i menit %s detik');
						?>
                    </td>
                 </tr>
                 
             </table>

          </td>
    </tr>
</table>
</b>
<table width="100%" border="0">
  <tr>
    <td valign="top" colspan="3">Pekerjaan yang dicita-citakan :
	</td>
   </tr>
  <tr>
  	<td width="57">&nbsp;</td>
    <td valign="top" width="12">1.</td>
    <td width="1005" valign="top">
    	<?php echo $cita[0]['kerja_a'];?>
	</td>
   </tr>
  <tr>
  	<td width="57">&nbsp;</td>
    <td valign="top" width="12">2.</td>
    <td valign="top">
    	<?php echo $cita[0]['kerja_b'];?>
	</td>
   </tr>
  <tr>
  	<td width="57">&nbsp;</td>
    <td valign="top" width="12">3.</td>
    <td valign="top">
    	<?php echo $cita[0]['kerja_c'];?>
	</td>
   </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td valign="top">
<table width="100%" border="0">
  <tr>
    <td rowspan="2" width="12%"><b>Aktifitas</b></td>
    <td rowspan="2" width="12%"><b>Hal 2-3</b></td>
    <td width="12%">
    <table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				
				$jjawab1=$nilaites[0]['JUMLAH_JAWAB_1'];
				echo"$jjawab1";
		?>
        </td>
      </tr>
    </table>
    </td>
    <td width="12%">
    	<table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				
				$jjawab2=$nilaites[0]['JUMLAH_JAWAB_2'];;
				echo"$jjawab2";
		?>
        </td>
      </tr>
    </table>
    </td>
    <td width="12%">
    	<table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab3=$nilaites[0]['JUMLAH_JAWAB_3'];
				echo"$jjawab3";
		?>
        </td>
      </tr>
    </table>
    </td>
    <td width="12%">
    	<table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab4=$nilaites[0]['JUMLAH_JAWAB_4'];
				echo"$jjawab4";
		?>
        </td>
      </tr>
    </table>
    </td>
    <td width="12%">
    	<table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab5=$nilaites[0]['JUMLAH_JAWAB_5'];;
				echo"$jjawab5";
		?>
        </td>
      </tr>
    </table>
    </td>
    <td width="12%">
    	<table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab6=$nilaites[0]['JUMLAH_JAWAB_6'];;
				echo"$jjawab6";
		?>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center"><center><b>R</b></td>
    <td align="center"><center><b>I</b></td>
    <td align="center"><center><b>A</b></td>
    <td align="center"><center><b>S</b></td>
    <td align="center"><center><b>E</b></td>
    <td align="center"><center><b>C</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    </tr>
  <tr>
    <td rowspan="2"><b>Kompetensi</b></td>
    <td rowspan="2"><b>Hal 4-5</b></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab1a=$nilaites[0]['JUMLAH_JAWAB_7'];
				echo"$jjawab1a";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab2a=$nilaites[0]['JUMLAH_JAWAB_8'];
				echo"$jjawab2a";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab3a=$nilaites[0]['JUMLAH_JAWAB_9'];
				echo"$jjawab3a";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab4a=$nilaites[0]['JUMLAH_JAWAB_10'];
				echo"$jjawab4a";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab5a=$nilaites[0]['JUMLAH_JAWAB_11'];
				echo"$jjawab5a";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab6a=$nilaites[0]['JUMLAH_JAWAB_12'];
				echo"$jjawab6a";
		?>
        </td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td align="center"><center><b>R</b></td>
    <td align="center"><center><b>I</b></td>
    <td align="center"><center><b>A</b></td>
    <td align="center"><center><b>S</b></td>
    <td align="center"><center><b>E</b></td>
    <td align="center"><center><b>C</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    </tr>
  <tr>
    <td rowspan="2"><b>Pekerjaan</b></td>
    <td rowspan="2"><b>Hal 6</b></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab1b=$nilaites[0]['JUMLAH_JAWAB_13'];
				echo"$jjawab1b";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab2b=$nilaites[0]['JUMLAH_JAWAB_14'];
				echo"$jjawab2b";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab3b=$nilaites[0]['JUMLAH_JAWAB_15'];
				echo"$jjawab3b";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab4b=$nilaites[0]['JUMLAH_JAWAB_16'];
				echo"$jjawab4b";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab5b=$nilaites[0]['JUMLAH_JAWAB_17'];
				echo"$jjawab5b";
		?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        <?php
				$jjawab6b=$nilaites[0]['JUMLAH_JAWAB_18'];
				echo"$jjawab6b";
		?>
        </td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td align="center"><center><b>R</b></td>
    <td align="center"><center><b>I</b></td>
    <td align="center"><center><b>A</b></td>
    <td align="center"><center><b>S</b></td>
    <td align="center"><center><b>E</b></td>
    <td align="center"><center><b>C</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    </tr>
  <tr>
        <?php
				$jjawab1c=$menilai_diri[0]['kemampuan_mekanis'];
				$jjawab2c=$menilai_diri[0]['kemampuan_ilmiah'];
				$jjawab3c=$menilai_diri[0]['kemampuan_artistik'];
				$jjawab4c=$menilai_diri[0]['kemampuan_mengajar'];
				$jjawab5c=$menilai_diri[0]['kemampuan_menjual'];
				$jjawab6c=$menilai_diri[0]['kemampuan_mengetik'];
				
				$jjawab1d=$menilai_diri[0]['kemampuan_tangan'];
				$jjawab2d=$menilai_diri[0]['kemampuan_matematika'];
				$jjawab3d=$menilai_diri[0]['kemampuan_musik'];
				$jjawab4d=$menilai_diri[0]['memahami_orglain'];
				$jjawab5d=$menilai_diri[0]['kemampuan_manajerial'];
				$jjawab6d=$menilai_diri[0]['keterampilan_kerja'];
	
		?>
    <td><b>Penilaian Diri</b></td>
    <td><b>Hal 7</b></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab1c";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab2c";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab3c";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab4c";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab5c";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab6c";?></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><center><b>R</b></td>
    <td align="center"><center><b>I</b></td>
    <td align="center"><center><b>A</b></td>
    <td align="center"><center><b>S</b></td>
    <td align="center"><center><b>E</b></td>
    <td align="center"><center><b>C</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab1d";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab2d";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab3d";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab4d";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab5d";?></td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center"><?php echo"$jjawab6d";?></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><center><b>R</b></td>
    <td align="center"><center><b>I</b></td>
    <td align="center"><center><b>A</b></td>
    <td align="center"><center><b>S</b></td>
    <td align="center"><center><b>E</b></td>
    <td align="center"><center><b>C</b></td>
  </tr>
  <tr>
    <td colspan="8"><br /><hr/><br /></td>
    </tr>
  <tr>
    <td colspan="2" rowspan="2"><b>Total Nilai (Tambahkan jumlah dari kelima R, kelima I, dll)</b></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        	<?php $totalr=$jjawab1+$jjawab1a+$jjawab1b+$jjawab1c+$jjawab1d; echo"$totalr";?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        	<?php $totali=$jjawab2+$jjawab2a+$jjawab2b+$jjawab2c+$jjawab2d; echo"$totali";?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        	<?php $totala=$jjawab3+$jjawab3a+$jjawab3b+$jjawab3c+$jjawab3d; echo"$totala";?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        	<?php $totals=$jjawab4+$jjawab4a+$jjawab4b+$jjawab4c+$jjawab4d; echo"$totals";?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        	<?php $totale=$jjawab5+$jjawab5a+$jjawab5b+$jjawab5c+$jjawab5d; echo"$totale";?>
        </td>
      </tr>
    </table></td>
    <td><table width="100%" border="1">
      <tr>
        <td align="center">
        	<?php $totalc=$jjawab6+$jjawab6a+$jjawab6b+$jjawab6c+$jjawab6d; echo"$totalc";?>
        </td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td align="center"><center><b>R</b></td>
    <td align="center"><center><b>I</b></td>
    <td align="center"><center><b>A</b></td>
    <td align="center"><center><b>S</b></td>
    <td align="center"><center><b>E</b></td>
    <td align="center"><center><b>C</b></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellpadding="1" cellspacing="1">
        	<?php


//rsort($ar);


#echo print_r($ar,true)."<br/>";

CLASS AC{

public $input;


public function algo_out(){
	
		//input dec
		$ar=$this->input;
		
		foreach($ar as $variabel=>$value){
			//echo $variabel."=".$value."<br/>";
			$max[]=$value;
		}
		
		//--try cetak--//
		#echo "Max=".max($max)."<br/>";

		$tertinggi=max($max);


		foreach($ar as $variabel=>$value){
			//echo $variabel."=".$value."<br/>";
			//$max[]=$value;
			if($tertinggi==$value){
				$v_up[]=$variabel;	
			}
			
			elseif($value<$tertinggi){
				$kedua[]=$value;
			}
		}
		
		//--try cetak--//
		#echo "Kedua=".max($kedua)."<br/>";

		$kedua_u=max($kedua);

		foreach($ar as $variabel=>$value){
			//echo $variabel."=".$value."<br/>";
			//$max[]=$value;
			if($kedua_u==$value){
				$v_midle[]=$variabel;	
			}
			
			elseif($value<$kedua_u){
				$ketiga[]=$value;
			}
		}

		//--try cetak--//
		#echo "Ketiga=".max($ketiga)."<br/>";

		$ketiga_u=max($ketiga);


		foreach($ar as $variabel=>$value){
			//echo $variabel."=".$value."<br/>";
			//$max[]=$value;
			if($ketiga_u==$value){
				$v_ketiga[]=$variabel;	
			}
			
			elseif($value<$ketiga_u){
				$keempat[]=$value;
			}
		}
		
		$ranking=array($tertinggi,$kedua_u,$ketiga_u);	
		$end_output=array($v_up,$v_midle,$v_ketiga);
		
		$compres=array($end_output,$ranking);
		
		return $compres;
		
	}//--end function algo_out()---//
}//--end class--//

//declarasi input--//
$ar=array(
	'R'=>$totalr,
	'I'=>$totali,
	'A'=>$totala,
	'S'=>$totals,
	'E'=>$totale,
	'C'=>$totalc,
);

$C=new AC();
$C->input=$ar;  //----> input---//
$output=$C->algo_out();


//--keluaran---//
/*echo "Pertama".$output[1][0]." ".print_r($output[0][0],true)."<br/>";
echo "Kedua".$output[1][1]." ".print_r($output[0][1],true)."<br/>";
echo "ketiga".$output[1][2]." ".print_r($output[0][2],true)."<br/>";*/



?>

            
            
            <tr>
            	<td rowspan="2" width="25%"><b>KODE RINGKAS</b></td>
            	<td width="25%">
                <table width="100%" border="1">
            	  <tr>
            	    <td align="center">
                    	<?php
								$tertinggi="";
								foreach ( $output[0][0] as $v=>$n){
										$tertinggi .=$n;	
								}
								$hasil1=strlen($tertinggi);
								if($hasil1==5)
								{
									echo "".$tertinggi[0]."-".$tertinggi[1]."-".$tertinggi[2]."-".$tertinggi[3]."-".$tertinggi[4]."";
								}
								if($hasil1==4)
								{
									echo "".$tertinggi[0]."-".$tertinggi[1]."-".$tertinggi[2]."-".$tertinggi[3]."";
								}
								if($hasil1==3)
								{
									echo "".$tertinggi[0]."-".$tertinggi[1]."-".$tertinggi[2]."";
								}
								if($hasil1==2)
								{
									echo "".$tertinggi[0]."-".$tertinggi[1]."";
								}
								if($hasil1==1)
								{
									echo "".$tertinggi[0]."";
								}
						?>
                    </td>
          	    </tr>
          	  </table>
              </td>
            	<td width="25%">
                <table width="100%" border="1">
            	  <tr>
            	    <td align="center">
                    	<?php
								$kedua="";
								foreach ( $output[0][1] as $v=>$u){
										$kedua .=$u;	
								}
								$hasil2=strlen($kedua);
								if($hasil2==5)
								{
									echo "".$kedua[0]."-".$kedua[1]."-".$kedua[2]."-".$kedua[3]."-".$kedua[4]."";
								}
								if($hasil2==4)
								{
									echo "".$kedua[0]."-".$kedua[1]."-".$kedua[2]."-".$kedua[3]."";
								}
								if($hasil2==3)
								{
									echo "".$kedua[0]."-".$kedua[1]."-".$kedua[2]."";
								}
								if($hasil2==2)
								{
									echo "".$kedua[0]."-".$kedua[1]."";
								}
								if($hasil2==1)
								{
									echo "".$kedua[0]."";
								}
						?>
                    </td>
          	    </tr>
          	  </table>
              </td>
            	<td width="25%">
                <table width="100%" border="1">
            	  <tr>
            	    <td align="center">
                    	<?php
								$ketiga="";
								foreach ( $output[0][2] as $v=>$y){
										$ketiga .=$y;	
								}
								$hasil3=strlen($ketiga);
								if($hasil3==5)
								{
									echo "".$ketiga[0]."-".$ketiga[1]."-".$ketiga[2]."-".$ketiga[3]."-".$ketiga[4]."";
								}
								if($hasil3==4)
								{
									echo "".$ketiga[0]."-".$ketiga[1]."-".$ketiga[2]."-".$ketiga[3]."";
								}
								if($hasil3==3)
								{
									echo "".$ketiga[0]."-".$ketiga[1]."-".$ketiga[2]."";
								}
								if($hasil3==2)
								{
									echo "".$ketiga[0]."-".$ketiga[1]."";
								}
								if($hasil3==1)
								{
									echo "".$ketiga[0]."";
								}
						?>
                    </td>
          	    </tr>
          	  </table></td>
           	</tr>
        	<tr>
            	 <td align="center"><center><b>Tertinggi</b></td>
                <td align="center"><center><b>Kedua</b></td>
                <td align="center"><center><b>Ketiga</b></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" align="right">
    	<span class="style4">KUALA ENOK,<br />
											  PT. PULAU SAMBU KUALA ENOK<br />
											  <br />
											  <br />
											  
											  
											  <u><b>( Nama )</b></u><br />
											  Recruitment											</span>	
    </td>
  </tr>
</table>
</div>
