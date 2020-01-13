<?php
$data=array(
	'participantstest_id'=>$d3,
);
 
$cr_data=array(
	'case'=>"nilai_tes_firob_443",
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
            margin: 1cm 1cm 1cm 1cm;
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
header("Content-Disposition: attachment;Filename=Daftar_Nilai_FIRO_B.doc");			
?>
<style type="text/css">
<!--
.style4 {font-size: 11px}
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
<table width="100%" border="0">
  <tr>
    <td width="16%" valign="top">
    	<table width="100%" border="1">
        	<tr>
            	<td colspan="4" align="center" bgcolor="#669900"><b>IE</b></td>
            </tr>
        	<tr>
            	<td align="center" bgcolor="#99FFFF">ITEM</td>
           	  <td align="center">KEY</td>
            	<td align="center" bgcolor="#FF9966">JB</td>
            	<td align="center" bgcolor="#0099FF">SCORE</td>
            </tr>
			<?php
				$ie=0;$ietot=0;
				foreach($nilaites[0]['Jawab_1'] as $row_Jawab)
				{
					$firobno1=$row_Jawab['firob_no'];
					$jawab1=$row_Jawab['jawab_firob_pil'];
					?>
        	<tr>
            	<td bgcolor="#99FFFF"><?php echo"$row_Jawab[firob_no]"; ?></td>
                <td>
                	<?php 
						if($firobno1=="1")
							{ echo"1-2-3";}
						elseif($firobno1=="3")
							{ echo"1-2-3-4";}
						elseif($firobno1=="5")
							{ echo"1-2-3-4";}
						elseif($firobno1=="7")
							{ echo"1-2-3";}
						elseif($firobno1=="9")
							{ echo"1-2";}
						elseif($firobno1=="11")
							{ echo"1-2";}
						elseif($firobno1=="13")
							{ echo"1-2";}
						elseif($firobno1=="15")
							{ echo"1";}
						elseif($firobno1=="16")
							{ echo"1";}
						else {}
					?>
                </td>
                <td bgcolor="#FF9966">
                	<?php 
						if($jawab1!=""){echo"$jawab1";}else{echo"<font color='#DD0000'>N</font>";}
					?>
               	</td>
                <td bgcolor="#0099FF">
                	<?php 
						if(($firobno1=="1" and ($jawab1=="1" or $jawab1=="2" or $jawab1=="3"))
							 or ($firobno1=="3" and ($jawab1=="1" or $jawab1=="2" or $jawab1=="3" or $jawab1=="4"))
							 or ($firobno1=="5" and ($jawab1=="1" or $jawab1=="2" or $jawab1=="3" or $jawab1=="4"))
							 or ($firobno1=="7" and ($jawab1=="1" or $jawab1=="2" or $jawab1=="3"))
							 or ($firobno1=="9" and ($jawab1=="1" or $jawab1=="2"))
							 or ($firobno1=="11" and ($jawab1=="1" or $jawab1=="2"))
							 or ($firobno1=="13" and ($jawab1=="1" or $jawab1=="2"))
							 or ($firobno1=="15" and ($jawab1=="1"))
							 or ($firobno1=="16" and ($jawab1=="1"))
							)
							{
								$ie=1;$ietot+=$ie; echo"$ie";	
							}else {echo"<font color='#EE0000'>0</font>";}
					?>
                </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF" colspan="3">SCORE</td>
                <td bgcolor="#0099FF"><?php echo"$ietot";?></td>
            </tr>
        </table>
    </td>
    <td width="16%" valign="top">
    	<table width="100%" border="1">
        	<tr>
            	<td colspan="4" align="center" bgcolor="#669900"><b>IW</b></td>
            </tr>
        	<tr>
            	<td align="center" bgcolor="#99FFFF">ITEM</td>
           	  <td align="center">KEY</td>
            	<td align="center" bgcolor="#FF9966">JB</td>
            	<td align="center" bgcolor="#0099FF">SCORE</td>
            </tr>
			<?php
				$iw=0;$iwtot=0;
				foreach($nilaites[0]['Jawab_2'] as $row_Jawab_2)
				{
					$firobno2=$row_Jawab_2['firob_no'];
					$jawab2=$row_Jawab_2['jawab_firob_pil'];
					?>
        	<tr>
            	<td bgcolor="#99FFFF"><?php echo"$row_Jawab_2[firob_no]"; ?></td>
                <td>
                	<?php 
						if($firobno2=="28")
							{ echo"1-2";}
						elseif($firobno2=="31")
							{ echo"1-2";}
						elseif($firobno2=="34")
							{ echo"1-2";}
						elseif($firobno2=="37")
							{ echo"1";}
						elseif($firobno2=="39")
							{ echo"1";}
						elseif($firobno2=="42")
							{ echo"1-2";}
						elseif($firobno2=="45")
							{ echo"1-2";}
						elseif($firobno2=="48")
							{ echo"1-2";}
						elseif($firobno2=="51")
							{ echo"1-2";}
						else {}
					?>
                </td>
                <td bgcolor="#FF9966">
                	<?php 
						if($jawab2!=""){echo"$jawab2";}else{echo"<font color='#DD0000'>N</font>";}
					?>
               	</td>
                <td bgcolor="#0099FF">
                	<?php 
						if(($firobno2=="28" and ($jawab2=="1" or $jawab2=="2"))
							 or ($firobno2=="31" and ($jawab2=="1" or $jawab2=="2"))
							 or ($firobno2=="34" and ($jawab2=="1" or $jawab2=="2"))
							 or ($firobno2=="37" and ($jawab2=="1"))
							 or ($firobno2=="39" and ($jawab2=="1"))
							 or ($firobno2=="42" and ($jawab2=="1" or $jawab2=="2"))
							 or ($firobno2=="45" and ($jawab2=="1" or $jawab2=="2"))
							 or ($firobno2=="48" and ($jawab2=="1" or $jawab2=="2"))
							 or ($firobno2=="51" and ($jawab2=="1" or $jawab2=="2"))
							)
							{
								$iw=1;$iwtot+=$iw; echo"$iw";	
							}else {echo"<font color='#EE0000'>0</font>";}
					?>
                </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF" colspan="3">SCORE</td>
                <td bgcolor="#0099FF"><?php echo"$iwtot";?></td>
            </tr>
        </table>
    </td>
    <td width="16%" valign="top">
    	<table width="100%" border="1">
        	<tr>
            	<td colspan="4" align="center" bgcolor="#669900"><b>CE</b></td>
            </tr>
        	<tr>
            	<td align="center" bgcolor="#99FFFF">ITEM</td>
           	  <td align="center">KEY</td>
            	<td align="center" bgcolor="#FF9966">JB</td>
            	<td align="center" bgcolor="#0099FF">SCORE</td>
            </tr>
			<?php
				$ce=0;$cetot=0;
				foreach($nilaites[0]['Jawab_3'] as $row_Jawab_3)
				{
					$firobno3=$row_Jawab_3['firob_no'];
					$jawab3=$row_Jawab_3['jawab_firob_pil'];
					?>
        	<tr>
            	<td bgcolor="#99FFFF"><?php echo"$row_Jawab_3[firob_no]"; ?></td>
                <td>
                	<?php 
						if($firobno3=="30")
							{ echo"1-2-3";}
						elseif($firobno3=="33")
							{ echo"1-2-3";}
						elseif($firobno3=="36")
							{ echo"1-2";}
						elseif($firobno3=="41")
							{ echo"1-2-3-4";}
						elseif($firobno3=="44")
							{ echo"1-2-3";}
						elseif($firobno3=="47")
							{ echo"1-2-3";}
						elseif($firobno3=="50")
							{ echo"1-2";}
						elseif($firobno3=="53")
							{ echo"1-2";}
						elseif($firobno3=="54")
							{ echo"1-2";}
						else {}
					?>
                </td>
                <td bgcolor="#FF9966">
                	<?php 
						if($jawab3!=""){echo"$jawab3";}else{echo"<font color='#DD0000'>N</font>";}
					?>
               	</td>
                <td bgcolor="#0099FF">
                	<?php 
						if(($firobno3=="30" and ($jawab3=="1" or $jawab3=="2" or $jawab3=="3"))
							 or ($firobno3=="33" and ($jawab3=="1" or $jawab3=="2" or $jawab3=="3"))
							 or ($firobno3=="36" and ($jawab3=="1" or $jawab3=="2"))
							 or ($firobno3=="41" and ($jawab3=="1" or $jawab3=="2" or $jawab3=="3" or $jawab3=="4"))
							 or ($firobno3=="44" and ($jawab3=="1" or $jawab3=="2" or $jawab3=="3"))
							 or ($firobno3=="47" and ($jawab3=="1" or $jawab3=="2" or $jawab3=="3"))
							 or ($firobno3=="50" and ($jawab3=="1" or $jawab3=="2"))
							 or ($firobno3=="53" and ($jawab3=="1" or $jawab3=="2"))
							 or ($firobno3=="54" and ($jawab3=="1" or $jawab3=="2"))
							)
							{
								$ce=1;$cetot+=$ce; echo"$ce";	
							}else {echo"<font color='#EE0000'>0</font>";}
					?>
                </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF" colspan="3">SCORE</td>
                <td bgcolor="#0099FF"><?php echo"$cetot";?></td>
            </tr>
        </table>
    </td>
    <td width="16%" valign="top">
    	<table width="100%" border="1">
        	<tr>
            	<td colspan="4" align="center" bgcolor="#669900"><b>CW</b></td>
            </tr>
        	<tr>
            	<td align="center" bgcolor="#99FFFF">ITEM</td>
           	  <td align="center">KEY</td>
            	<td align="center" bgcolor="#FF9966">JB</td>
            	<td align="center" bgcolor="#0099FF">SCORE</td>
            </tr>
			<?php
				$cw=0;$cwtot=0;
				foreach($nilaites[0]['Jawab_4'] as $row_Jawab_4)
				{
					$firobno4=$row_Jawab_4['firob_no'];
					$jawab4=$row_Jawab_4['jawab_firob_pil'];
					?>
        	<tr>
            	<td bgcolor="#99FFFF"><?php echo"$row_Jawab_4[firob_no]"; ?></td>
                <td>
                	<?php 
						if($firobno4=="2")
							{ echo"1-2-3-4";}
						elseif($firobno4=="6")
							{ echo"1-2-3-4";}
						elseif($firobno4=="10")
							{ echo"1-2-3";}
						elseif($firobno4=="14")
							{ echo"1-2-3";}
						elseif($firobno4=="18")
							{ echo"1-2-3";}
						elseif($firobno4=="20")
							{ echo"1-2-3";}
						elseif($firobno4=="22")
							{ echo"1-2-3-4";}
						elseif($firobno4=="24")
							{ echo"1-2-3";}
						elseif($firobno4=="26")
							{ echo"1-2-4";}
						else {}
					?>
                </td>
                <td bgcolor="#FF9966">
                	<?php 
						if($jawab4!=""){echo"$jawab4";}else{echo"<font color='#DD0000'>N</font>";}
					?>
               	</td>
                <td bgcolor="#0099FF">
                	<?php 
						if(($firobno4=="2" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3" or $jawab4=="4"))
							 or ($firobno4=="6" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3" or $jawab4=="4"))
							 or ($firobno4=="10" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3"))
							 or ($firobno4=="14" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3"))
							 or ($firobno4=="18" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3"))
							 or ($firobno4=="20" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3"))
							 or ($firobno4=="22" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3" or $jawab4=="4"))
							 or ($firobno4=="24" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3"))
							 or ($firobno4=="26" and ($jawab4=="1" or $jawab4=="2" or $jawab4=="3"))
							)
							{
								$cw=1;$cwtot+=$cw; echo"$cw";	
							}else {echo"<font color='#EE0000'>0</font>";}
					?>
                </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF" colspan="3">SCORE</td>
                <td bgcolor="#0099FF"><?php echo"$cwtot";?></td>
            </tr>
        </table>
    </td>
    <td width="16%" valign="top">
    	<table width="100%" border="1">
        	<tr>
            	<td colspan="4" align="center" bgcolor="#669900"><b>AE</b></td>
            </tr>
        	<tr>
            	<td align="center" bgcolor="#99FFFF">ITEM</td>
           	  <td align="center">KEY</td>
            	<td align="center" bgcolor="#FF9966">JB</td>
            	<td align="center" bgcolor="#0099FF">SCORE</td>
            </tr>
			<?php
				$ae=0;$aetot=0;
				foreach($nilaites[0]['Jawab_5'] as $row_Jawab_5)
				{
					$firobno5=$row_Jawab_5['firob_no'];
					$jawab5=$row_Jawab_5['jawab_firob_pil'];
					?>
        	<tr>
            	<td bgcolor="#99FFFF"><?php echo"$row_Jawab_5[firob_no]"; ?></td>
                <td>
                	<?php 
						if($firobno5=="4")
							{ echo"1-2";}
						elseif($firobno5=="8")
							{ echo"1-2";}
						elseif($firobno5=="12")
							{ echo"1";}
						elseif($firobno5=="17")
							{ echo"1-2";}
						elseif($firobno5=="19")
							{ echo"4-5-6";}
						elseif($firobno5=="21")
							{ echo"1-2";}
						elseif($firobno5=="23")
							{ echo"1-2";}
						elseif($firobno5=="25")
							{ echo"4-5-6";}
						elseif($firobno5=="27")
							{ echo"1-2";}
						else {}
					?>
                </td>
                <td bgcolor="#FF9966">
                	<?php 
						if($jawab5!=""){echo"$jawab5";}else{echo"<font color='#DD0000'>N</font>";}
					?>
               	</td>
                <td bgcolor="#0099FF">
                	<?php 
						if(($firobno5=="4" and ($jawab5=="1" or $jawab5=="2"))
							 or ($firobno5=="8" and ($jawab5=="1" or $jawab5=="2"))
							 or ($firobno5=="12" and ($jawab5=="1"))
							 or ($firobno5=="17" and ($jawab5=="1" or $jawab5=="2"))
							 or ($firobno5=="19" and ($jawab5=="4" or $jawab5=="5" or $jawab5=="6"))
							 or ($firobno5=="21" and ($jawab5=="1" or $jawab5=="2"))
							 or ($firobno5=="23" and ($jawab5=="1" or $jawab5=="2"))
							 or ($firobno5=="25" and ($jawab5=="4" or $jawab5=="5" or $jawab5=="6"))
							 or ($firobno5=="27" and ($jawab5=="1" or $jawab5=="2"))
							)
							{
								$ae=1;$aetot+=$ae; echo"$ae";	
							}else {echo"<font color='#EE0000'>0</font>";}
					?>
                </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF" colspan="3">SCORE</td>
                <td bgcolor="#0099FF"><?php echo"$aetot";?></td>
            </tr>
        </table>
    </td>
    <td width="16%" valign="top">
    	<table width="100%" border="1">
        	<tr>
            	<td colspan="4" align="center" bgcolor="#669900"><b>AW</b></td>
            </tr>
        	<tr>
            	<td align="center" bgcolor="#99FFFF">ITEM</td>
           	  <td align="center">KEY</td>
            	<td align="center" bgcolor="#FF9966">JB</td>
            	<td align="center" bgcolor="#0099FF">SCORE</td>
            </tr>
			<?php
				$aw=0;$awtot=0;
				foreach($nilaites[0]['Jawab_6'] as $row_Jawab_6)
				{
					$firobno6=$row_Jawab_6['firob_no'];
					$jawab6=$row_Jawab_6['jawab_firob_pil'];
					?>
        	<tr>
            	<td bgcolor="#99FFFF"><?php echo"$row_Jawab_6[firob_no]"; ?></td>
                <td>
                	<?php 
						if($firobno6=="29")
							{ echo"1-2";}
						elseif($firobno6=="32")
							{ echo"1-2";}
						elseif($firobno6=="35")
							{ echo"5-6";}
						elseif($firobno6=="38")
							{ echo"1-2";}
						elseif($firobno6=="40")
							{ echo"5-6";}
						elseif($firobno6=="43")
							{ echo"1";}
						elseif($firobno6=="46")
							{ echo"5-6";}
						elseif($firobno6=="49")
							{ echo"1-2";}
						elseif($firobno6=="52")
							{ echo"5-6";}
						else {}
					?>
                </td>
                <td bgcolor="#FF9966">
                	<?php 
						if($jawab6!=""){echo"$jawab6";}else{echo"<font color='#DD0000'>N</font>";}
					?>
               	</td>
                <td bgcolor="#0099FF">
                	<?php 
						if(($firobno6=="29" and ($jawab6=="1" or $jawab6=="2"))
							 or ($firobno6=="32" and ($jawab6=="1" or $jawab6=="2"))
							 or ($firobno6=="35" and ($jawab6=="5" or $jawab6=="6"))
							 or ($firobno6=="38" and ($jawab6=="1" or $jawab6=="2"))
							 or ($firobno6=="40" and ($jawab6=="5" or $jawab6=="6"))
							 or ($firobno6=="43" and ($jawab6=="1"))
							 or ($firobno6=="46" and ($jawab6=="5" or $jawab6=="6"))
							 or ($firobno6=="49" and ($jawab6=="1" or $jawab6=="2"))
							 or ($firobno6=="52" and ($jawab6=="5" or $jawab6=="6"))
							)
							{
								$aw=1;$awtot+=$aw; echo"$aw";	
							}else {echo"<font color='#EE0000'>0</font>";}
					?>
                </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF" colspan="3">SCORE</td>
                <td bgcolor="#0099FF"><?php echo"$awtot";?></td>
            </tr>
        </table>
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
														<td valign="top">JB = Jawaban<br />Score Benar = 1<br />Score Salah = 0<br />N = Nihil(kosong)</td>
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
