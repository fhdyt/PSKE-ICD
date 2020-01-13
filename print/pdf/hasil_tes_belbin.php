<?php
$data=array(
	'participantstest_id'=>$d3,
);
 
$cr_data=array(
	'case'=>"nilai_tes_belbin_443",
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
foreach($nilaites[0]['KUNCI'] as $row_KUNCI){
	$KUNCI[]=$row_KUNCI;
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
			size: 29.7cm 21cm;
            margin: 2cm 1cm 1cm 1cm;
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
?>
<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Daftar_Nilai_BELBIN_INVENTORY.doc");			
		 ?>
<style type="text/css">
<!--
.style4 {font-size: 16px;}
-->
</style>
<div class="Section1">
        <!--Buat ISI-->
<div style="float:left; font-size:20px; color:#000000; border-bottom:2px double #000; width:100%; text-align:center;"><b>INFORMASI PENGERJAAN SOAL - <?php echo $nilaites[0]['TOPIK_JUDUL'];?></b></div>
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
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td valign="top" width="14%">
       	  <table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td align="center" colspan="2"><strong>SECTION A</strong></td>
                </tr>
                <tr>
                	<td bgcolor="#EEEEEE"><strong>No</strong></td><td><strong>Point</strong></td>
              </tr>
                <?php 
					foreach($nilaites[0]['Jawab_1'] as $row_Jawab_1)
					{?>
            	<tr>
                	<td align="right" bgcolor="#EEEEEE"><?php echo $row_Jawab_1['belbin_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_1['jawab_belbin_pil'];?>
                    </td>
              </tr>
                	<?php } ?>
                
            </table>
      </td>
        <td width="2">&nbsp;</td>
        
    	<td valign="top" width="14%">
       	  <table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td colspan="2" align="center"><strong>SECTION B</strong></td>
                </tr>
                <tr>
                	<td bgcolor="#EEEEEE"><strong>No</strong></td><td><strong>Point</strong></td>
              </tr>
                <?php 
					foreach($nilaites[0]['Jawab_2'] as $row_Jawab_2)
					{?>
            	<tr>
                	<td align="right" bgcolor="#EEEEEE"><?php echo $row_Jawab_2['belbin_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_2['jawab_belbin_pil'];?>
                    </td>
              </tr>
                	<?php } ?>
                
            </table>
      </td>
        <td width="2">&nbsp;</td>
        
    	<td valign="top" width="14%">
       	  <table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td colspan="2" align="center"><strong>SECTION C</strong></td>
                </tr>
                <tr>
                	<td bgcolor="#EEEEEE"><strong>No</strong></td><td><strong>Point</strong></td>
              </tr>
                <?php 
					foreach($nilaites[0]['Jawab_3'] as $row_Jawab_3)
					{?>
            	<tr>
                	<td align="right" bgcolor="#EEEEEE"><?php echo $row_Jawab_3['belbin_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_3['jawab_belbin_pil'];?>
                    </td>
              </tr>
                	<?php } ?>
                
            </table>
      </td>
        <td width="2">&nbsp;</td>
        
    	<td valign="top" width="14%">
       	  <table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td colspan="2" align="center"><strong>SECTION D</strong></td>
                </tr>
                <tr>
                	<td bgcolor="#EEEEEE"><strong>No</strong></td><td><strong>Point</strong></td>
              </tr>
                <?php 
					foreach($nilaites[0]['Jawab_4'] as $row_Jawab_4)
					{?>
            	<tr>
                	<td align="right" bgcolor="#EEEEEE"><?php echo $row_Jawab_4['belbin_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_4['jawab_belbin_pil'];?>
                    </td>
              </tr>
                	<?php } ?>
                
            </table>
      </td>
        <td width="2">&nbsp;</td>
        
    	<td valign="top" width="14%">
       	  <table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td colspan="2" align="center"><strong>SECTION E</strong></td>
                </tr>
                <tr>
                	<td bgcolor="#EEEEEE"><strong>No</strong></td><td><strong>Point</strong></td>
              </tr>
                <?php 
					foreach($nilaites[0]['Jawab_5'] as $row_Jawab_5)
					{?>
            	<tr>
                	<td align="right" bgcolor="#EEEEEE"><?php echo $row_Jawab_5['belbin_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_5['jawab_belbin_pil'];?>
                    </td>
              </tr>
                	<?php } ?>
                
            </table>
      </td>
        <td width="2">&nbsp;</td>
        
    	<td valign="top" width="14%">
       	  <table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td colspan="2" align="center"><strong>SECTION F</strong></td>
                </tr>
                <tr>
                	<td bgcolor="#EEEEEE"><strong>No</strong></td><td><strong>Point</strong></td>
              </tr>
                <?php 
					foreach($nilaites[0]['Jawab_6'] as $row_Jawab_6)
					{?>
            	<tr>
                	<td align="right" bgcolor="#EEEEEE"><?php echo $row_Jawab_6['belbin_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_6['jawab_belbin_pil'];?>
                    </td>
              </tr>
                	<?php } ?>
                
            </table>
      </td>
        <td width="2">&nbsp;</td>
        
    	<td valign="top" width="14%">
       	  <table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td colspan="2" align="center"><strong>SECTION G</strong></td>
                </tr>
                <tr>
                	<td bgcolor="#EEEEEE"><strong>No</strong></td><td><strong>Point</strong></td>
              </tr>
                <?php 
					foreach($nilaites[0]['Jawab_7'] as $row_Jawab_7)
					{?>
            	<tr>
                	<td align="right" bgcolor="#EEEEEE"><?php echo $row_Jawab_7['belbin_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_7['jawab_belbin_pil'];?>
                    </td>
              </tr>
                	<?php } ?>
                
            </table>
      </td>
    </tr>
</table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center><font style="font-size:18px;"><b>KUNCI JAWABAN BELBIN</b></font></center><br>
<table width="100%" border="1" cellpadding="0" cellspacing="1">
	<tr>
    	<td width="12%" height="37">&nbsp;</td>
        <td width="8%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="8%" bgcolor="#FFFFFF" align="center"><strong>SH</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><strong>CO</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><strong>PL</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><strong>RI</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><strong>ME</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><strong>IMP</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><strong>TW</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">No.Item</td>
        <td width="7%" bgcolor="#FFFFFF" align="center"><strong>CF</strong></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#FFFFFF"><strong>SECTION A</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">3</td>
        <td width="5%" bgcolor="#FFFFFF" align="center">
        	<?php
					$sh1=$KUNCI[2]['jawab_belbin_pil']; 
					echo"$sh1";
			?>
        </td>
        <td width="5%" bgcolor="#EEEEEE" align="center">7</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				
					$co1=$KUNCI[6]['jawab_belbin_pil']; 
					echo"$co1";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">4</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				
					$pl1=$KUNCI[3]['jawab_belbin_pil']; 
					echo"$pl1";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">6</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				
					$ri1=$KUNCI[5]['jawab_belbin_pil']; 
					echo"$ri1";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">5</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				
					$me1=$KUNCI[4]['jawab_belbin_pil']; 
					echo"$me1";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">1</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				
					$imp1=$KUNCI[0]['jawab_belbin_pil']; 
					echo"$imp1";
				
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">8</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				
					$tw1=$KUNCI[7]['jawab_belbin_pil']; 
					echo"$tw1";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">2</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				
					$cf1=$KUNCI[1]['jawab_belbin_pil']; 
					echo"$cf1";
			?></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#FFFFFF"><strong>SECTION B</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">1</td>
        <td width="5%" bgcolor="#FFFFFF" align="center">
        	<?php
				$sh2=$KUNCI[8]['jawab_belbin_pil']; echo"$sh2";
			?>
        </td>
        <td width="5%" bgcolor="#EEEEEE" align="center">6</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$co2=$KUNCI[13]['jawab_belbin_pil']; echo"$co2";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">5</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$pl2=$KUNCI[12]['jawab_belbin_pil']; echo"$pl2";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">8</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$ri2=$KUNCI[15]['jawab_belbin_pil']; echo"$ri2";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">4</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$me2=$KUNCI[11]['jawab_belbin_pil']; echo"$me2";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">7</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$imp2=$KUNCI[14]['jawab_belbin_pil']; echo"$imp2";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">3</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$tw2=$KUNCI[10]['jawab_belbin_pil']; echo"$tw2";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">2</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$cf2=$KUNCI[9]['jawab_belbin_pil']; echo"$cf2";
			?></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#FFFFFF"><strong>SECTION C</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">7</td>
        <td width="5%" bgcolor="#FFFFFF" align="center">
        	<?php
				$sh3=$KUNCI[22]['jawab_belbin_pil']; echo"$sh3";
			?>
            </td>
        <td width="5%" bgcolor="#EEEEEE" align="center">4</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$co3=$KUNCI[19]['jawab_belbin_pil']; echo"$co3";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">6</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$pl3=$KUNCI[21]['jawab_belbin_pil']; echo"$pl3";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">2</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$ri3=$KUNCI[17]['jawab_belbin_pil']; echo"$ri3";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">3</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$me3=$KUNCI[18]['jawab_belbin_pil']; echo"$me3";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">5</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$imp3=$KUNCI[20]['jawab_belbin_pil']; echo"$imp3";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">8</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$tw3=$KUNCI[23]['jawab_belbin_pil']; echo"$tw3";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">1</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$cf3=$KUNCI[16]['jawab_belbin_pil']; echo"$cf3";
			?></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#FFFFFF"><strong>SECTION D</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">2</td>
        <td width="5%" bgcolor="#FFFFFF" align="center">
        	<?php
				$sh4=$KUNCI[25]['jawab_belbin_pil']; echo"$sh4";
			?>
            </td>
        <td width="5%" bgcolor="#EEEEEE" align="center">3</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$co4=$KUNCI[26]['jawab_belbin_pil']; echo"$co4";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">6</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$pl4=$KUNCI[29]['jawab_belbin_pil']; echo"$pl4";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">4</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$ri4=$KUNCI[27]['jawab_belbin_pil']; echo"$ri4";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">5</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$me4=$KUNCI[28]['jawab_belbin_pil']; echo"$me4";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">1</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$imp4=$KUNCI[24]['jawab_belbin_pil']; echo"$imp4";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">8</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$tw4=$KUNCI[31]['jawab_belbin_pil']; echo"$tw4";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">7</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$cf4=$KUNCI[30]['jawab_belbin_pil']; echo"$cf4";
			?></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#FFFFFF"><strong>SECTION E</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">6</td>
        <td width="5%" bgcolor="#FFFFFF" align="center">
        	<?php
				$sh5=$KUNCI[37]['jawab_belbin_pil']; echo"$sh5";
			?>
            </td>
        <td width="5%" bgcolor="#EEEEEE" align="center">5</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$co5=$KUNCI[36]['jawab_belbin_pil']; echo"$co5";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">1</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$pl5=$KUNCI[32]['jawab_belbin_pil']; echo"$pl5";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">7</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$ri5=$KUNCI[38]['jawab_belbin_pil']; echo"$ri5";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">3</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$me5=$KUNCI[34]['jawab_belbin_pil']; echo"$me5";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">4</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$imp5=$KUNCI[35]['jawab_belbin_pil']; echo"$imp5";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">2</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$tw5=$KUNCI[33]['jawab_belbin_pil']; echo"$tw5";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">8</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$cf5=$KUNCI[39]['jawab_belbin_pil']; echo"$cf5";
			?></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#FFFFFF"><strong>SECTION F</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">6</td>
        <td width="5%" bgcolor="#FFFFFF" align="center">
        	<?php
				$sh6=$KUNCI[45]['jawab_belbin_pil']; echo"$sh6";
			?>
            </td>
        <td width="5%" bgcolor="#EEEEEE" align="center">4</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$co6=$KUNCI[43]['jawab_belbin_pil']; echo"$co6";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">5</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$pl6=$KUNCI[44]['jawab_belbin_pil']; echo"$pl6";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">1</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$ri6=$KUNCI[40]['jawab_belbin_pil']; echo"$ri6";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">3</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$me6=$KUNCI[42]['jawab_belbin_pil']; echo"$me6";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">8</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$imp6=$KUNCI[47]['jawab_belbin_pil']; echo"$imp6";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">7</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$tw6=$KUNCI[46]['jawab_belbin_pil']; echo"$tw6";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">2</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$cf6=$KUNCI[41]['jawab_belbin_pil']; echo"$cf6";
			?></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#FFFFFF"><strong>SECTION G</strong></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">5</td>
        <td width="5%" bgcolor="#FFFFFF" align="center">
        	<?php
				$sh7=$KUNCI[52]['jawab_belbin_pil']; echo"$sh7";
			?>
            </td>
        <td width="5%" bgcolor="#EEEEEE" align="center">7</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$co7=$KUNCI[54]['jawab_belbin_pil']; echo"$co7";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">6</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$pl7=$KUNCI[53]['jawab_belbin_pil']; echo"$pl7";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">3</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$ri7=$KUNCI[50]['jawab_belbin_pil']; echo"$ri7";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">2</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$me7=$KUNCI[49]['jawab_belbin_pil']; echo"$me7";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">1</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$imp7=$KUNCI[48]['jawab_belbin_pil']; echo"$imp7";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">8</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$tw7=$KUNCI[55]['jawab_belbin_pil']; echo"$tw7";
			?></td>
        <td width="5%" bgcolor="#EEEEEE" align="center">4</td>
        <td width="5%" bgcolor="#FFFFFF" align="center"><?php
				$cf7=$KUNCI[51]['jawab_belbin_pil']; echo"$cf7";
			?></td>
    </tr>
    
    <tr>
        <td width="8%" height="22" align="center" bgcolor="#33CCCC"><strong>TOTAL</strong></td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totalsh=$sh1+$sh2+$sh3+$sh4+$sh5+$sh6+$sh7; echo"$totalsh";
			?>
        </td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totalco=$co1+$co2+$co3+$co4+$co5+$co6+$co7; echo"$totalco";
			?>
        </td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totalpl=$pl1+$pl2+$pl3+$pl4+$pl5+$pl6+$pl7; echo"$totalpl";
			?>
            </td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totalri=$ri1+$ri2+$ri3+$ri4+$ri5+$ri6+$ri7; echo"$totalri";
			?>
            </td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totalme=$me1+$me2+$me3+$me4+$me5+$me6+$me7; echo"$totalme";
			?>
            </td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totalimp=$imp1+$imp2+$imp3+$imp4+$imp5+$imp6+$imp7; echo"$totalimp";
			?>
            </td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totaltw=$tw1+$tw2+$tw3+$tw4+$tw5+$tw6+$tw7; echo"$totaltw";
			?>
            </td>
      <td width="5%" align="center" bgcolor="#33CCCC">&nbsp;</td>
        <td width="5%" align="center" bgcolor="#33CCCC">
        	<?php 
				$totalcf=$cf1+$cf2+$cf3+$cf4+$cf5+$cf6+$cf7; echo"$totalcf";
			?>
            </td>
    </tr>
</table>
<br />
<table  id="" cellspacing="0" width="100%" border="0" style="color:#000000;0">
                                        <tr>
                                            <td valign="top">
											  <table>
													<tr>
														<td valign="top">Note :</td>
														<td valign="top">
                                                        	SH = Shapper<br>
                                                        	CO = Coordinator<br>
                                                        	PL = Plant<br>
                                                        	RI = Resource Investigator<br>
                                                        	ME = Monitor Evaluator<br>
                                                        	IMP = Implementer<br>
                                                        	TW = Teamworker<br>
                                                   	  CF = Completer-finisher<br></td>
													</tr>
												</table>											</td>
											<td width="30%" valign="top">
												<span class="style4">KUALA ENOK,<br />
											  PT. PULAU SAMBU KUALA ENOK<br />
											  <br />
											  <br />
											  
											  
											  <u><b>( Nama )</b></u><br />
											  Recruitment											</span></td>
                                        </tr>
</table>
</div>
