<?php
$data=array(
	'participantstest_id'=>$d3,
);
 
$cr_data=array(
	'case'=>"nilai_tes_mbti_443",
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
header("Content-Disposition: attachment;Filename=Daftar_Nilai_MBTI.doc");			
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
    <td width="20%" valign="top">Bagian I</td>
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$ei=0; $ii=0;
				foreach($nilaites[0]['Jawab_1'] as $row_Jawab)
				{
					$mbtino1=$row_Jawab['mbti_no'];
					$jawab1=$row_Jawab['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino1=="001" and $jawab1=="A") or ($mbtino1=="005" and $jawab1=="A")
							 or ($mbtino1=="009" and $jawab1=="A") or ($mbtino1=="013" and $jawab1=="B")
							 or ($mbtino1=="017" and $jawab1=="B") or ($mbtino1=="021" and $jawab1=="A")
							 or ($mbtino1=="025" and $jawab1=="A") or ($mbtino1=="029" and $jawab1=="A")
							 or ($mbtino1=="033" and $jawab1=="A") or ($mbtino1=="037" and $jawab1=="B")
							 or ($mbtino1=="041" and $jawab1=="A") or ($mbtino1=="045" and $jawab1=="A")
							 or ($mbtino1=="049" and $jawab1=="B") or ($mbtino1=="053" and $jawab1=="A")
							 or ($mbtino1=="057" and $jawab1=="A")
							)
							{
								$ei++; echo"$jawab1";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino1=="001" and $jawab1=="B") or ($mbtino1=="005" and $jawab1=="B")
							 or ($mbtino1=="009" and $jawab1=="B") or ($mbtino1=="013" and $jawab1=="A")
							 or ($mbtino1=="017" and $jawab1=="A") or ($mbtino1=="021" and $jawab1=="B")
							 or ($mbtino1=="025" and $jawab1=="B") or ($mbtino1=="029" and $jawab1=="B")
							 or ($mbtino1=="033" and $jawab1=="B") or ($mbtino1=="037" and $jawab1=="A")
							 or ($mbtino1=="041" and $jawab1=="B") or ($mbtino1=="045" and $jawab1=="B")
							 or ($mbtino1=="049" and $jawab1=="A") or ($mbtino1=="053" and $jawab1=="B")
							 or ($mbtino1=="057" and $jawab1=="B")
							)
							{
								$ii++; echo"$jawab1";	
							}else {}
					?>
                 </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$ei";?></td>
                <td bgcolor="#0099FF"><?php echo"$ii";?></td>
            </tr>
        	<tr>
            	<td></td><td bgcolor="#FFCC33">E</td><td bgcolor="#FFCC33">I</td>
            </tr>
        </table>
    </td>
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$si=0; $ni=0;
				foreach($nilaites[0]['Jawab_2'] as $row_Jawab_2)
				{
					$mbtino2=$row_Jawab_2['mbti_no'];
					$jawab2=$row_Jawab_2['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_2[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino2=="002" and $jawab2=="A") or ($mbtino2=="006" and $jawab2=="B")
							 or ($mbtino2=="010" and $jawab2=="A") or ($mbtino2=="014" and $jawab2=="B")
							 or ($mbtino2=="018" and $jawab2=="B") or ($mbtino2=="022" and $jawab2=="B")
							 or ($mbtino2=="026" and $jawab2=="B") or ($mbtino2=="030" and $jawab2=="B")
							 or ($mbtino2=="034" and $jawab2=="B") or ($mbtino2=="038" and $jawab2=="A")
							 or ($mbtino2=="042" and $jawab2=="A") or ($mbtino2=="046" and $jawab2=="A")
							 or ($mbtino2=="050" and $jawab2=="A") or ($mbtino2=="054" and $jawab2=="B")
							 or ($mbtino2=="058" and $jawab2=="A")
							)
							{
								$si++; echo"$jawab2";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino2=="002" and $jawab2=="B") or ($mbtino2=="006" and $jawab2=="A")
							 or ($mbtino2=="010" and $jawab2=="B") or ($mbtino2=="014" and $jawab2=="A")
							 or ($mbtino2=="018" and $jawab2=="A") or ($mbtino2=="022" and $jawab2=="A")
							 or ($mbtino2=="026" and $jawab2=="A") or ($mbtino2=="030" and $jawab2=="A")
							 or ($mbtino2=="034" and $jawab2=="A") or ($mbtino2=="038" and $jawab2=="B")
							 or ($mbtino2=="042" and $jawab2=="B") or ($mbtino2=="046" and $jawab2=="B")
							 or ($mbtino2=="050" and $jawab2=="B") or ($mbtino2=="054" and $jawab2=="A")
							 or ($mbtino2=="058" and $jawab2=="B")
							)
							{
								$ni++; echo"$jawab2";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$si";?></td>
                <td bgcolor="#0099FF"><?php echo"$ni";?></td>
            </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">S</td>
            	<td bgcolor="#FFCC33">N</td>
            </tr>
        </table>
    </td>
    
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$ti=0; $fi=0;
				foreach($nilaites[0]['Jawab_3'] as $row_Jawab_3)
				{
					$mbtino3=$row_Jawab_3['mbti_no'];
					$jawab3=$row_Jawab_3['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_3[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino3=="003" and $jawab3=="B") or ($mbtino3=="007" and $jawab3=="B")
							 or ($mbtino3=="011" and $jawab3=="B") or ($mbtino3=="015" and $jawab3=="B")
							 or ($mbtino3=="019" and $jawab3=="B") or ($mbtino3=="023" and $jawab3=="A")
							 or ($mbtino3=="027" and $jawab3=="B") or ($mbtino3=="031" and $jawab3=="B")
							 or ($mbtino3=="035" and $jawab3=="A") or ($mbtino3=="039" and $jawab3=="A")
							 or ($mbtino3=="043" and $jawab3=="A") or ($mbtino3=="047" and $jawab3=="A")
							 or ($mbtino3=="051" and $jawab3=="B") or ($mbtino3=="055" and $jawab3=="A")
							 or ($mbtino3=="059" and $jawab3=="A")
							)
							{
								$ti++; echo"$jawab3";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino3=="003" and $jawab3=="A") or ($mbtino3=="007" and $jawab3=="A")
							 or ($mbtino3=="011" and $jawab3=="A") or ($mbtino3=="015" and $jawab3=="A")
							 or ($mbtino3=="019" and $jawab3=="A") or ($mbtino3=="023" and $jawab3=="B")
							 or ($mbtino3=="027" and $jawab3=="A") or ($mbtino3=="031" and $jawab3=="A")
							 or ($mbtino3=="035" and $jawab3=="B") or ($mbtino3=="039" and $jawab3=="B")
							 or ($mbtino3=="043" and $jawab3=="B") or ($mbtino3=="047" and $jawab3=="B")
							 or ($mbtino3=="051" and $jawab3=="A") or ($mbtino3=="055" and $jawab3=="B")
							 or ($mbtino3=="059" and $jawab3=="B")
							)
							{
								$fi++; echo"$jawab3";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$ti";?></td>
                <td bgcolor="#0099FF"><?php echo"$fi";?></td>
          </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">T</td>
            	<td bgcolor="#FFCC33">F</td>
            </tr>
        </table>
    </td>
    
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$ji=0; $pi=0;
				foreach($nilaites[0]['Jawab_4'] as $row_Jawab_4)
				{
					$mbtino4=$row_Jawab_4['mbti_no'];
					$jawab4=$row_Jawab_4['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_4[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino4=="004" and $jawab4=="A") or ($mbtino4=="008" and $jawab4=="A")
							 or ($mbtino4=="012" and $jawab4=="B") or ($mbtino4=="016" and $jawab4=="A")
							 or ($mbtino4=="020" and $jawab4=="A") or ($mbtino4=="024" and $jawab4=="B")
							 or ($mbtino4=="028" and $jawab4=="A") or ($mbtino4=="032" and $jawab4=="A")
							 or ($mbtino4=="036" and $jawab4=="A") or ($mbtino4=="040" and $jawab4=="A")
							 or ($mbtino4=="044" and $jawab4=="B") or ($mbtino4=="048" and $jawab4=="B")
							 or ($mbtino4=="052" and $jawab4=="A") or ($mbtino4=="056" and $jawab4=="A")
							 or ($mbtino4=="060" and $jawab4=="A")
							)
							{
								$ji++; echo"$jawab4";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino4=="004" and $jawab4=="B") or ($mbtino4=="008" and $jawab4=="B")
							 or ($mbtino4=="012" and $jawab4=="A") or ($mbtino4=="016" and $jawab4=="B")
							 or ($mbtino4=="020" and $jawab4=="B") or ($mbtino4=="024" and $jawab4=="A")
							 or ($mbtino4=="028" and $jawab4=="B") or ($mbtino4=="032" and $jawab4=="B")
							 or ($mbtino4=="036" and $jawab4=="B") or ($mbtino4=="040" and $jawab4=="B")
							 or ($mbtino4=="044" and $jawab4=="A") or ($mbtino4=="048" and $jawab4=="A")
							 or ($mbtino4=="052" and $jawab4=="B") or ($mbtino4=="056" and $jawab4=="B")
							 or ($mbtino4=="060" and $jawab4=="B")
							)
							{
								$pi++; echo"$jawab4";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$ji";?></td>
                <td bgcolor="#0099FF"><?php echo"$pi";?></td>
            </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">J</td>
            	<td bgcolor="#FFCC33">P</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td width="20%" valign="top">Bagian II</td>
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$eia=0; $iia=0;
				foreach($nilaites[0]['Jawab_5'] as $row_Jawab_5)
				{
					$mbtino1a=$row_Jawab_5['mbti_no'];
					$jawab1a=$row_Jawab_5['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_5[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino1a=="061" and $jawab1a=="A") or ($mbtino1a=="065" and $jawab1a=="B")
							 or ($mbtino1a=="069" and $jawab1a=="B") or ($mbtino1a=="073" and $jawab1a=="A")
							 or ($mbtino1a=="077" and $jawab1a=="A") or ($mbtino1a=="081" and $jawab1a=="A")
							 or ($mbtino1a=="085" and $jawab1a=="A") or ($mbtino1a=="089" and $jawab1a=="B")
							 or ($mbtino1a=="093" and $jawab1a=="A")
							)
							{
								$eia++; echo"$jawab1a";	
							}else {}
					?>
                </td>
                <td>
                	<?php  
						if(($mbtino1a=="061" and $jawab1a=="B") or ($mbtino1a=="065" and $jawab1a=="A")
							 or ($mbtino1a=="069" and $jawab1a=="A") or ($mbtino1a=="073" and $jawab1a=="B")
							 or ($mbtino1a=="077" and $jawab1a=="B") or ($mbtino1a=="081" and $jawab1a=="B")
							 or ($mbtino1a=="085" and $jawab1a=="B") or ($mbtino1a=="089" and $jawab1a=="A")
							 or ($mbtino1a=="093" and $jawab1a=="B")
							)
							{
								$iia++; echo"$jawab1a";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$eia";?></td>
                <td bgcolor="#0099FF"><?php echo"$iia";?></td>
          </tr>
        	<tr>
            	<td></td><td bgcolor="#FFCC33">E</td><td bgcolor="#FFCC33">I</td>
            </tr>
        </table>
    </td>
	<td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$sia=0; $nia=0;
				foreach($nilaites[0]['Jawab_6'] as $row_Jawab_6)
				{
					$mbtino2a=$row_Jawab_6['mbti_no'];
					$jawab2a=$row_Jawab_6['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_6[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino2a=="062" and $jawab2a=="B") or ($mbtino2a=="066" and $jawab2a=="A")
							 or ($mbtino2a=="070" and $jawab2a=="A") or ($mbtino2a=="074" and $jawab2a=="A")
							 or ($mbtino2a=="078" and $jawab2a=="A") or ($mbtino2a=="082" and $jawab2a=="A")
							 or ($mbtino2a=="086" and $jawab2a=="A") or ($mbtino2a=="090" and $jawab2a=="A")
							 or ($mbtino2a=="094" and $jawab2a=="A")
							)
							{
								$sia++; echo"$jawab2a";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino2a=="062" and $jawab2a=="A") or ($mbtino2a=="066" and $jawab2a=="B")
							 or ($mbtino2a=="070" and $jawab2a=="B") or ($mbtino2a=="074" and $jawab2a=="B")
							 or ($mbtino2a=="078" and $jawab2a=="B") or ($mbtino2a=="082" and $jawab2a=="B")
							 or ($mbtino2a=="086" and $jawab2a=="B") or ($mbtino2a=="090" and $jawab2a=="B")
							 or ($mbtino2a=="094" and $jawab2a=="B")
							)
							{
								$nia++; echo"$jawab2a";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$sia";?></td>
                <td bgcolor="#0099FF"><?php echo"$nia";?></td>
          </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">S</td>
            	<td bgcolor="#FFCC33">N</td>
            </tr>
        </table>
    </td>
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$tia=0; $fia=0;
				foreach($nilaites[0]['Jawab_7'] as $row_Jawab_7)
				{
					$mbtino3a=$row_Jawab_7['mbti_no'];
					$jawab3a=$row_Jawab_7['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_7[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino3a=="063" and $jawab3a=="A") or ($mbtino3a=="067" and $jawab3a=="B")
							 or ($mbtino3a=="071" and $jawab3a=="B") or ($mbtino3a=="075" and $jawab3a=="B")
							 or ($mbtino3a=="079" and $jawab3a=="B") or ($mbtino3a=="083" and $jawab3a=="B")
							 or ($mbtino3a=="087" and $jawab3a=="B") or ($mbtino3a=="091" and $jawab3a=="A")
							 or ($mbtino3a=="095" and $jawab3a=="A")
							)
							{
								$tia++; echo"$jawab3a";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino3a=="063" and $jawab3a=="B") or ($mbtino3a=="067" and $jawab3a=="A")
							 or ($mbtino3a=="071" and $jawab3a=="A") or ($mbtino3a=="075" and $jawab3a=="A")
							 or ($mbtino3a=="079" and $jawab3a=="A") or ($mbtino3a=="083" and $jawab3a=="A")
							 or ($mbtino3a=="087" and $jawab3a=="A") or ($mbtino3a=="091" and $jawab3a=="B")
							 or ($mbtino3a=="095" and $jawab3a=="B")
							)
							{
								$fia++; echo"$jawab3a";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$tia";?></td>
                <td bgcolor="#0099FF"><?php echo"$fia";?></td>
          </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">T</td>
            	<td bgcolor="#FFCC33">F</td>
            </tr>
        </table>
    </td><td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$jia=0; $pia=0;
				foreach($nilaites[0]['Jawab_8'] as $row_Jawab_8)
				{
					$mbtino4a=$row_Jawab_8['mbti_no'];
					$jawab4a=$row_Jawab_8['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_8[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino4a=="064" and $jawab4a=="A") or ($mbtino4a=="068" and $jawab4a=="A")
							 or ($mbtino4a=="072" and $jawab4a=="A") or ($mbtino4a=="076" and $jawab4a=="A")
							 or ($mbtino4a=="080" and $jawab4a=="B") or ($mbtino4a=="084" and $jawab4a=="A")
							 or ($mbtino4a=="088" and $jawab4a=="B") or ($mbtino4a=="092" and $jawab4a=="B")
							 or ($mbtino4a=="096" and $jawab4a=="A")
							)
							{
								$jia++; echo"$jawab4a";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino4a=="064" and $jawab4a=="B") or ($mbtino4a=="068" and $jawab4a=="B")
							 or ($mbtino4a=="072" and $jawab4a=="B") or ($mbtino4a=="076" and $jawab4a=="B")
							 or ($mbtino4a=="080" and $jawab4a=="A") or ($mbtino4a=="084" and $jawab4a=="B")
							 or ($mbtino4a=="088" and $jawab4a=="A") or ($mbtino4a=="092" and $jawab4a=="A")
							 or ($mbtino4a=="096" and $jawab4a=="B")
							)
							{
								$pia++; echo"$jawab4a";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$jia";?></td>
                <td bgcolor="#0099FF"><?php echo"$pia";?></td>
          </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">J</td>
            	<td bgcolor="#FFCC33">P</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td width="20%" valign="top">Bagian III</td>
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$eib=0; $iib=0;
				foreach($nilaites[0]['Jawab_9'] as $row_Jawab_9)
				{
					$mbtino1b=$row_Jawab_9['mbti_no'];
					$jawab1b=$row_Jawab_9['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_9[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino1b=="097" and $jawab1b=="A")
							)
							{
								$eib++; echo"$jawab1b";	
							}else {}
					?>
                </td>
                <td>
                	<?php  
						if(($mbtino1b=="097" and $jawab1b=="B")
							)
							{
								$iib++; echo"$jawab1b";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$eib";?></td>
                <td bgcolor="#0099FF"><?php echo"$iib";?></td>
          </tr>
        	<tr>
            	<td></td><td bgcolor="#FFCC33">E</td><td bgcolor="#FFCC33">I</td>
            </tr>
        </table>
    </td>
	<td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$sib=0; $nib=0;
				foreach($nilaites[0]['Jawab_10'] as $row_Jawab_10)
				{
					$mbtino2b=$row_Jawab_10['mbti_no'];
					$jawab2b=$row_Jawab_10['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_10[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino2b=="098" and $jawab2b=="A")
							)
							{
								$sib++; echo"$jawab2b";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino2b=="098" and $jawab2b=="B")
							)
							{
								$nib++; echo"$jawab2b";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$sib";?></td>
                <td bgcolor="#0099FF"><?php echo"$nib";?></td>
          </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">S</td>
            	<td bgcolor="#FFCC33">N</td>
            </tr>
        </table>
    </td>
    <td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$tib=0; $fib=0;
				foreach($nilaites[0]['Jawab_11'] as $row_Jawab_11)
				{
					$mbtino3b=$row_Jawab_11['mbti_no'];
					$jawab3b=$row_Jawab_11['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_11[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino3b=="099" and $jawab3b=="A")
							)
							{
								$tib++; echo"$jawab3b";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino3b=="099" and $jawab3b=="B")
							)
							{
								$fib++; echo"$jawab3b";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$tib";?></td>
                <td bgcolor="#0099FF"><?php echo"$fib";?></td>
          </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">T</td>
            	<td bgcolor="#FFCC33">F</td>
            </tr>
        </table>
    </td><td width="20%" valign="top">
    	<table width="100%" border="1">
        	<?php
				$jib=0; $pib=0;
				foreach($nilaites[0]['Jawab_12'] as $row_Jawab_12)
				{
					$mbtino4b=$row_Jawab_12['mbti_no'];
					$jawab4b=$row_Jawab_12['jawab_mbti_pil'];
					?>
        	<tr>
            	<td><?php echo"$row_Jawab_12[mbti_no]"; ?></td>
                <td>
                	<?php 
						if(($mbtino4b=="100" and $jawab4b=="A")
							)
							{
								$jib++; echo"$jawab4b";	
							}else {}
					?>
                </td>
                <td>
                	<?php 
						if(($mbtino4b=="100" and $jawab4b=="B")
							)
							{
								$pib++; echo"$jawab4b";	
							}else {}
					?>
              </td>
            </tr>
            <?php } ?>
        	<tr>
            	<td bgcolor="#0099FF">JLH</td>
                <td bgcolor="#0099FF"><?php echo"$jib";?></td>
                <td bgcolor="#0099FF"><?php echo"$pib";?></td>
          </tr>
        	<tr>
            	<td></td>
            	<td bgcolor="#FFCC33">J</td>
            	<td bgcolor="#FFCC33">P</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td width="20%" valign="top" colspan="4">
    	<table width="92%" border="1">
        	<tr>
            	<td bgcolor="#FFCC33"><b>SUBJECT</b></td>
                <td align="center" bgcolor="#FFCC33"><b>E / I</b></td>
                <td align="center" bgcolor="#FFCC33"><b>S / N</b></td>
                <td align="center" bgcolor="#FFCC33"><b>T / F</b></td>
                <td align="center" bgcolor="#FFCC33"><b>J / P</b></td>
          </tr>
            
        	<tr>
            	<td><b>Bagian I</b></td>
                <td align="center" bgcolor="#66FFFF">
                	<b>
                    <?php
						if($ei > $ii) {echo"E";$eitotal=1;$iitotal=0;}else{echo"I";$eitotal=0;$iitotal=1;}
					?>
                    </b>
                </td>
                <td align="center">
                	<b>
                    <?php
						if($si > $ni) {echo"S";$sitotal=1;$nitotal=0;}else{echo"N";$sitotal=0;$nitotal=1;}
					?>
                    </b>
                </td>
                <td align="center" bgcolor="#66FFFF">
                	<b>
                    <?php
						if($ti > $fi) {echo"T";$titotal=1;$fitotal=0;}else{echo"F";$titotal=0;$fitotal=1;}
					?>
                    </b>
                </td>
                <td align="center">
                	<b>
                    <?php
						if($ji > $pi) {echo"J";$jitotal=1;$pitotal=0;}else{echo"P";$jitotal=0;$pitotal=1;}
					?>
                    </b>
              </td>
            </tr>
            
        	<tr>
            	<td><b>Bagian II</b></td>
                <td align="center" bgcolor="#66FFFF">
                	<b>
                    <?php
						if($eia > $iia) {echo"E";$eiatotal=1;$iiatotal=0;}else{echo"I";$eiatotal=0;$iiatotal=1;}
					?>
                    </b>
                </td>
                <td align="center">
                	<b>
                    <?php
						if($sia > $nia) {echo"S";$siatotal=1;$niatotal=0;}else{echo"N";$siatotal=0;$niatotal=1;}
					?>
                    </b>
                </td>
                <td align="center" bgcolor="#66FFFF">
                	<b>
                    <?php
						if($tia > $fia) {echo"T";$tiatotal=1;$fiatotal=0;}else{echo"F";$tiatotal=0;$fiatotal=1;}
					?>
                    </b>
                </td>
                <td align="center">
                	<b>
                    <?php
						if($jia > $pia) {echo"J";$jiatotal=1;$piatotal=0;}else{echo"P";$jiatotal=0;$piatotal=1;}
					?>
                    </b>
                </td>
            </tr>
            
        	<tr>
            	<td><b>Bagian III</b></td>
                <td align="center" bgcolor="#66FFFF">
                	<b>
                    <?php
						if($eib > $iib) {echo"E";$eibtotal=1;$iibtotal=0;}else{echo"I";$eibtotal=0;$iibtotal=1;}
					?>
                    </b>
                </td>
                <td align="center">
                	<b>
                    <?php
						if($sib > $nib) {echo"S";$sibtotal=1;$nibtotal=0;}else{echo"N";$sibtotal=0;$nibtotal=1;}					?>
                    </b>
                </td>
                <td align="center" bgcolor="#66FFFF">
                	<b>
                    <?php
						if($tib > $fib) {echo"T";$tibtotal=1;$fibtotal=0;}else{echo"F";$tibtotal=0;$fibtotal=1;}
					?>
                    </b>
                </td>
                <td align="center">
                	<b>
                    <?php
						if($jib > $pib) {echo"J";$jibtotal=1;$pibtotal=0;}else{echo"P";$jibtotal=0;$pibtotal=1;}
					?>
                    </b>
                </td>
            </tr>
            
        	<tr>
            	<td bgcolor="#FFCCFF"><b>Tipe Kepribadian</b></td>
                <td align="center" bgcolor="#FFCCFF">
                	<b>
                    <?php
						$eto=$eitotal+$eiatotal+$eibtotal;
						$ito=$iitotal+$iiatotal+$iibtotal;
						if($eto > $ito) {echo"E";}else{echo"I";}
					?>
                    </b>
                </td>
                <td align="center" bgcolor="#FFCCFF">
                	<b>
                    <?php
						$sto=$sitotal+$siatotal+$sibtotal;
						$nto=$nitotal+$niatotal+$nibtotal;
						if($sto > $nto) {echo"S";}else{echo"N";}
					?>
                    </b>
                </td>
                <td align="center" bgcolor="#FFCCFF">
                	<b>
                    <?php
						$tto=$titotal+$tiatotal+$tibtotal;
						$fto=$fitotal+$fiatotal+$fibtotal;
						if($tto > $fto) {echo"T";}else{echo"F";}
					?>
                    </b>
              </td>
                <td align="center" bgcolor="#FFCCFF">
                	<b>
                    <?php
						$jto=$jitotal+$jiatotal+$jibtotal;
						$pto=$pitotal+$piatotal+$pibtotal;
						if($jto > $pto) {echo"J";}else{echo"P";}
					?>
                    </b>
              </td>
            </tr>
        </table>
    </td>
    <td width="20%" valign="top" align="left">
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
