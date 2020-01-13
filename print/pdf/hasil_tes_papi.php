<?php
$data=array(
	'participantstest_id'=>$d3,
);
 
$cr_data=array(
	'case'=>"nilai_tes_papi_443",
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
			size:21.59 cm;
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
header("Content-Disposition: attachment;Filename=Daftar_Nilai_PAPI_KOSTICK.doc");			
		 ?>
<style type="text/css">
<!--
.style4 {font-size: 11px}
-->
</style>
<div class="Section1">
        <!--Buat ISI-->
<div style="float:left; font-size:20px; color:#000000; border-bottom:2px double #000; width:100%; text-align:center;"><b>INFORMASI PENGERJAAN SOAL - <?php echo $nilaites[0]['TOPIK_SOAL'];?></b></div>
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
    	<td valign="top" width="32%">
        	<table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td><strong>No</strong></td><td><strong>Jawaban</strong></td><td><strong>Ket</strong></td>
                </tr>
                <?php 
					foreach($nilaites[0]['Jawab'] as $row_Jawab)
					{?>
            	<tr>
                	<td align="right"><?php echo $row_Jawab['papi_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab['jawab_papi_pil'];?>
                    </td>
                    <td>
						<?php 
						if($row_Jawab['jawab_papi_pil']=="")
						{ $jawab="N";echo"<div align='right' style='color:#E00'>$jawab</div>";}
						else
						{$jawab="";}
						?>
                  </td>
                </tr>
                	<?php } ?>
                
            </table>
        </td>
        <td width="2">&nbsp;</td>
        <td valign="top" width="32%">
        	<table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td><strong>No</strong></td><td><strong>Jawaban</strong></td><td><strong>Ket</strong></td>
                </tr>
                <?php 
					foreach($nilaites[0]['Jawab_2'] as $row_Jawab_2)
					{?>
            	<tr>
                	<td align="right"><?php echo $row_Jawab_2['papi_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_2['jawab_papi_pil'];?>
                    </td>
                  <td>
						<?php 
						if($row_Jawab_2['jawab_papi_pil']=="")
						{ $jawab="N";echo"<div align='right' style='color:#E00'>$jawab</div>";}
						else
						{$jawab="";}
						?>
                  </td>
                </tr>
                	<?php } ?>
                
            </table>
        </td>
        <td width="2">&nbsp;</td>
        <td valign="top" width="32%">
        	<table width="100%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td><strong>No</strong></td><td><strong>Jawaban</strong></td><td><strong>Ket</strong></td>
                </tr>
                <?php 
					foreach($nilaites[0]['Jawab_3'] as $row_Jawab_3)
					{?>
            	<tr>
                	<td align="right"><?php echo $row_Jawab_3['papi_no'];?>.</td>
                    <td align="center">
						<?php echo $row_Jawab_3['jawab_papi_pil'];?>
                    </td>
                    <td>
						<?php 
						if($row_Jawab_3['jawab_papi_pil']=="")
						{ $jawab="N";echo"<div align='right' style='color:#E00'>$jawab</div>";}
						else
						{$jawab="";}
						?>
                  </td>
                </tr>
                	<?php } ?>
                
            </table>
        </td>
    </tr>
</table>
<br>
<?php
$g1=0;$l1=0;$i1=0;$t1=0;$v1=0;$s1=0;$r1=0;$d1=0;$c1=0;$e1=0;

$n1=0;$a1=0;$p1=0;$x1=0;$b1=0;$o1=0;$z1=0;$k1=0;$f1=0;$w1=0;

foreach($nilaites[0]['TOTAL_Jawab'] as $row_TOTAL_Jawab)
{
		$papino=$row_TOTAL_Jawab['papi_no'];
		$pointjawab=$row_TOTAL_Jawab['jawab_papi_pil'];
		if(
		  ($papino=="1" and $pointjawab=="A") or ($papino=="11" and $pointjawab=="A") or ($papino=="21" and $pointjawab=="A") or
		  ($papino=="31" and $pointjawab=="A") or ($papino=="41" and $pointjawab=="A") or ($papino=="51" and $pointjawab=="A") or
		  ($papino=="61" and $pointjawab=="A") or ($papino=="71" and $pointjawab=="A") or ($papino=="81" and $pointjawab=="A")
		  )
		  {
			  $g1++;
		  }
		  elseif(
		  ($papino=="12" and $pointjawab=="A") or ($papino=="22" and $pointjawab=="A") or ($papino=="32" and $pointjawab=="A") or
		  ($papino=="42" and $pointjawab=="A") or ($papino=="52" and $pointjawab=="A") or ($papino=="62" and $pointjawab=="A") or
		  ($papino=="72" and $pointjawab=="A") or ($papino=="82" and $pointjawab=="A") or ($papino=="81" and $pointjawab=="B")
		  )
		  {
			  $l1++;
		  }
		  elseif(
		  ($papino=="23" and $pointjawab=="A") or ($papino=="33" and $pointjawab=="A") or ($papino=="43" and $pointjawab=="A") or
		  ($papino=="53" and $pointjawab=="A") or ($papino=="63" and $pointjawab=="A") or ($papino=="73" and $pointjawab=="A") or
		  ($papino=="83" and $pointjawab=="A") or ($papino=="71" and $pointjawab=="B") or ($papino=="82" and $pointjawab=="B")
		  )
		  {
			  $i1++;
		  }
		  elseif(
		  ($papino=="34" and $pointjawab=="A") or ($papino=="44" and $pointjawab=="A") or ($papino=="54" and $pointjawab=="A") or
		  ($papino=="64" and $pointjawab=="A") or ($papino=="74" and $pointjawab=="A") or ($papino=="84" and $pointjawab=="A") or
		  ($papino=="61" and $pointjawab=="B") or ($papino=="72" and $pointjawab=="B") or ($papino=="83" and $pointjawab=="B")
		  )
		  {
			  $t1++;
		  }
		  elseif(
		  ($papino=="45" and $pointjawab=="A") or ($papino=="55" and $pointjawab=="A") or ($papino=="65" and $pointjawab=="A") or
		  ($papino=="75" and $pointjawab=="A") or ($papino=="85" and $pointjawab=="A") or ($papino=="51" and $pointjawab=="B") or
		  ($papino=="62" and $pointjawab=="B") or ($papino=="73" and $pointjawab=="B") or ($papino=="84" and $pointjawab=="B")
		  )
		  {
			  $v1++;
		  }
		  elseif(
		  ($papino=="56" and $pointjawab=="A") or ($papino=="66" and $pointjawab=="A") or ($papino=="76" and $pointjawab=="A") or
		  ($papino=="86" and $pointjawab=="A") or ($papino=="41" and $pointjawab=="B") or ($papino=="52" and $pointjawab=="B") or
		  ($papino=="63" and $pointjawab=="B") or ($papino=="74" and $pointjawab=="B") or ($papino=="85" and $pointjawab=="B")
		  )
		  {
			  $s1++;
		  }
		  elseif(
		  ($papino=="67" and $pointjawab=="A") or ($papino=="77" and $pointjawab=="A") or ($papino=="87" and $pointjawab=="A") or
		  ($papino=="31" and $pointjawab=="B") or ($papino=="42" and $pointjawab=="B") or ($papino=="53" and $pointjawab=="B") or
		  ($papino=="64" and $pointjawab=="B") or ($papino=="75" and $pointjawab=="B") or ($papino=="86" and $pointjawab=="B")
		  )
		  {
			  $r1++;
		  }
		  elseif(
		  ($papino=="78" and $pointjawab=="A") or ($papino=="88" and $pointjawab=="A") or ($papino=="21" and $pointjawab=="B") or
		  ($papino=="32" and $pointjawab=="B") or ($papino=="43" and $pointjawab=="B") or ($papino=="54" and $pointjawab=="B") or
		  ($papino=="65" and $pointjawab=="B") or ($papino=="76" and $pointjawab=="B") or ($papino=="87" and $pointjawab=="B")
		  )
		  {
			  $d1++;
		  }
		  elseif(
		  ($papino=="89" and $pointjawab=="A") or ($papino=="11" and $pointjawab=="B") or ($papino=="22" and $pointjawab=="B") or
		  ($papino=="33" and $pointjawab=="B") or ($papino=="44" and $pointjawab=="B") or ($papino=="55" and $pointjawab=="B") or
		  ($papino=="66" and $pointjawab=="B") or ($papino=="77" and $pointjawab=="B") or ($papino=="88" and $pointjawab=="B")
		  )
		  {
			  $c1++;
		  }
		  elseif(
		  ($papino=="1" and $pointjawab=="B") or ($papino=="12" and $pointjawab=="B") or ($papino=="23" and $pointjawab=="B") or
		  ($papino=="34" and $pointjawab=="B") or ($papino=="45" and $pointjawab=="B") or ($papino=="56" and $pointjawab=="B") or
		  ($papino=="67" and $pointjawab=="B") or ($papino=="78" and $pointjawab=="B") or ($papino=="89" and $pointjawab=="B")
		  )
		  {
			  $e1++;
		  }
		  elseif(
		  ($papino=="2" and $pointjawab=="B") or ($papino=="13" and $pointjawab=="B") or ($papino=="24" and $pointjawab=="B") or
		  ($papino=="35" and $pointjawab=="B") or ($papino=="46" and $pointjawab=="B") or ($papino=="57" and $pointjawab=="B") or
		  ($papino=="68" and $pointjawab=="B") or ($papino=="79" and $pointjawab=="B") or ($papino=="90" and $pointjawab=="B")
		  )
		  {
			  $n1++;
		  }
		  elseif(
		  ($papino=="3" and $pointjawab=="B") or ($papino=="14" and $pointjawab=="B") or ($papino=="25" and $pointjawab=="B") or
		  ($papino=="36" and $pointjawab=="B") or ($papino=="47" and $pointjawab=="B") or ($papino=="58" and $pointjawab=="B") or
		  ($papino=="69" and $pointjawab=="B") or ($papino=="80" and $pointjawab=="B") or ($papino=="2" and $pointjawab=="A")
		  )
		  {
			  $a1++;
		  }
		  elseif(
		  ($papino=="4" and $pointjawab=="B") or ($papino=="15" and $pointjawab=="B") or ($papino=="26" and $pointjawab=="B") or
		  ($papino=="37" and $pointjawab=="B") or ($papino=="48" and $pointjawab=="B") or ($papino=="59" and $pointjawab=="B") or
		  ($papino=="70" and $pointjawab=="B") or ($papino=="3" and $pointjawab=="A") or ($papino=="13" and $pointjawab=="A")
		  )
		  {
			  $p1++;
		  }
		  elseif(
		  ($papino=="5" and $pointjawab=="B") or ($papino=="16" and $pointjawab=="B") or ($papino=="27" and $pointjawab=="B") or
		  ($papino=="38" and $pointjawab=="B") or ($papino=="49" and $pointjawab=="B") or ($papino=="60" and $pointjawab=="B") or
		  ($papino=="4" and $pointjawab=="A") or ($papino=="14" and $pointjawab=="A") or ($papino=="24" and $pointjawab=="A")
		  )
		  {
			  $x1++;
		  }
		  elseif(
		  ($papino=="6" and $pointjawab=="B") or ($papino=="17" and $pointjawab=="B") or ($papino=="28" and $pointjawab=="B") or
		  ($papino=="39" and $pointjawab=="B") or ($papino=="50" and $pointjawab=="B") or ($papino=="5" and $pointjawab=="A") or
		  ($papino=="15" and $pointjawab=="A") or ($papino=="25" and $pointjawab=="A") or ($papino=="35" and $pointjawab=="A")
		  )
		  {
			  $b1++;
		  }
		  elseif(
		  ($papino=="7" and $pointjawab=="B") or ($papino=="18" and $pointjawab=="B") or ($papino=="29" and $pointjawab=="B") or
		  ($papino=="40" and $pointjawab=="B") or ($papino=="6" and $pointjawab=="A") or ($papino=="16" and $pointjawab=="A") or
		  ($papino=="26" and $pointjawab=="A") or ($papino=="36" and $pointjawab=="A") or ($papino=="46" and $pointjawab=="A")
		  )
		  {
			  $o1++;
		  }
		  elseif(
		  ($papino=="8" and $pointjawab=="B") or ($papino=="19" and $pointjawab=="B") or ($papino=="30" and $pointjawab=="B") or
		  ($papino=="7" and $pointjawab=="A") or ($papino=="17" and $pointjawab=="A") or ($papino=="27" and $pointjawab=="A") or
		  ($papino=="37" and $pointjawab=="A") or ($papino=="47" and $pointjawab=="A") or ($papino=="57" and $pointjawab=="A")
		  )
		  {
			  $z1++;
		  }
		  elseif(
		  ($papino=="9" and $pointjawab=="B") or ($papino=="20" and $pointjawab=="B") or ($papino=="8" and $pointjawab=="A") or
		  ($papino=="18" and $pointjawab=="A") or ($papino=="28" and $pointjawab=="A") or ($papino=="38" and $pointjawab=="A") or
		  ($papino=="48" and $pointjawab=="A") or ($papino=="58" and $pointjawab=="A") or ($papino=="68" and $pointjawab=="A")
		  )
		  {
			  $k1++;
		  }
		  elseif(
		  ($papino=="10" and $pointjawab=="B") or ($papino=="9" and $pointjawab=="A") or ($papino=="19" and $pointjawab=="A") or
		  ($papino=="29" and $pointjawab=="A") or ($papino=="39" and $pointjawab=="A") or ($papino=="49" and $pointjawab=="A") or
		  ($papino=="59" and $pointjawab=="A") or ($papino=="69" and $pointjawab=="A") or ($papino=="79" and $pointjawab=="A")
		  )
		  {
			  $f1++;
		  }
		  elseif(
		  ($papino=="10" and $pointjawab=="A") or ($papino=="20" and $pointjawab=="A") or ($papino=="30" and $pointjawab=="A") or
		  ($papino=="40" and $pointjawab=="A") or ($papino=="50" and $pointjawab=="A") or ($papino=="60" and $pointjawab=="A") or
		  ($papino=="70" and $pointjawab=="A") or ($papino=="80" and $pointjawab=="A") or ($papino=="90" and $pointjawab=="A")
		  )
		  {
			  $w1++;
		  }else{}
	}
?>

<table width="100%" border="1" cellpadding="0" cellspacing="1">
	<tr>
    	<td width="26%">TOTAL</td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>G</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>L</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>I</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>T</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>V</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>S</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>R</strong></td>
      <td width="7%" bgcolor="#0099FF" align="center"><strong>D</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>C</strong></td>
        <td width="7%" bgcolor="#0099FF" align="center"><strong>E</strong></td>
    </tr>
    <tr>
      <td width="11%"><?php $totaljb1=$g1+$l1+$i1+$t1+$v1+$s1+$r1+$d1+$c1+$e1; echo"$totaljb1"; ?> </td>
        <td align="center"><?php echo"$g1";?></td>
        <td align="center"><?php echo"$l1";?></td>
        <td align="center"><?php echo"$i1";?></td>
        <td align="center"><?php echo"$t1";?></td>
        <td align="center"><?php echo"$v1";?></td>
        <td align="center"><?php echo"$s1";?></td>
        <td align="center"><?php echo"$r1";?></td>
      <td align="center"><?php echo"$d1";?></td>
      <td align="center"><?php echo"$c1";?></td>
      <td align="center"><?php echo"$e1";?></td>
    </tr>
    <tr><td colspan="11">&nbsp;</td></tr>
    <tr>
    	<td width="26%">TOTAL</td>
        <td width="7%" bgcolor="#FF6600" align="center"><strong>N</strong></td>
        <td width="7%" bgcolor="#FF6600" align="center"><strong>A</strong></td>
        <td width="7%" bgcolor="#FF6600" align="center"><strong>P</strong></td>
        <td width="7%" bgcolor="#FF6600" align="center"><strong>X</strong></td>
        <td width="7%" bgcolor="#FF6600" align="center"><strong>B</strong></td>
        <td width="7%" bgcolor="#FF6600" align="center"><strong>O</strong></td>
        <td width="7%" bgcolor="#FF6600" align="center"><strong>Z</strong></td>
      <td width="7%" bgcolor="#FF6600" align="center"><strong>K</strong></td>
      <td width="7%" bgcolor="#FF6600" align="center"><strong>F</strong></td>
      <td width="7%" bgcolor="#FF6600" align="center"><strong>W</strong></td>
    </tr>
    <tr>
        <td width="11%"><?php $totaljb2=$n1+$a1+$p1+$x1+$b1+$o1+$z1+$k1+$f1+$w1; echo"$totaljb2"; ?> </td>
      <td align="center"><?php echo"$n1";?></td>
      <td align="center"><?php echo"$a1";?></td>
      <td align="center"><?php echo"$p1";?></td>
      <td align="center"><?php echo"$x1";?></td>
      <td align="center"><?php echo"$b1";?></td>
        <td align="center"><?php echo"$o1";?></td>
        <td align="center"><?php echo"$z1";?></td>
        <td align="center"><?php echo"$k1";?></td>
        <td align="center"><?php echo"$f1";?></td>
        <td align="center"><?php echo"$w1";?></td>
    </tr>
</table>
<br />
<table  id="" cellspacing="0" width="100%" border="0" style="color:#000000;0">
                                        <tr>
                                            <td valign="top">
												<table>
													<tr>
														<td valign="top">Note :</td>
														<td valign="top">N = Nihil(kosong)</td>
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
