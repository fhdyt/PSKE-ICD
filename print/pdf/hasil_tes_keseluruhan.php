<?php
$data=array(
	'participantstest_id'=>$d3,
);
 
$cr_data=array(
	'case'=>"nilai_tes_keseluruhan_443",
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
    </style>
</head>
<body>
<?php
ini_set("memory_limit","512M");
ini_set("max_execution_time","120");
?>
<?php
header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=Daftar_Nilai_".$periodekeviewword."_".$tahunke.".doc");
header("Content-Disposition: attachment;Filename=Daftar_Nilai.doc");			
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td valign="top">
        	<table width="50%" border="1" cellpadding="0" cellspacing="1">
            	<tr>
                	<td><strong>No</strong></td><td><strong>Jawaban</strong></td><td><strong>Kunci</strong></td><td><strong>Keterangan</strong></td>
                </tr>
                <?php 
					$benar=0; $salah=0;
					foreach($nilaites[0]['Jawab'] as $row_Jawab)
					{				
						
						?>
            	<tr>
                	<td align="right"><?php echo $row_Jawab['tesintum_no'];?>.</td>
                    <td align="center"><?php echo $row_Jawab['jawab_tesintum_pil'];?></td>
                    <td align="center"><?php echo $row_Jawab['tesintum_kunci'];?></td>
                    <td>
						<?php 
						if($row_Jawab['jawab_tesintum_pil']=="")
						{ $jawab="N"; $salah++;}
						elseif($row_Jawab['jawab_tesintum_pil']==$row_Jawab['tesintum_kunci'])
						{ $jawab="B";$benar++;}
						else
						{$jawab="S";$salah++;}
						
						if($jawab=="B")
						{
						echo"<div align='right'>$jawab</div>";
						}elseif($jawab=="N")
						{
						echo"<div align='center'>$jawab</div>";
						}
						
						else
						{
							echo"<div align='left' style='color:#E00'>$jawab</div>";
						}
						?>
                     </td>
                </tr>
                	<?php } ?>
                
            </table>
        </td>
      <td valign="top">
        	<table width="67%" border="1" cellpadding="0" cellspacing="1">
            	
                <tr>
                	<td width="78%"><font color="#0066FF" size="+3">Total B</font></td><td width="4%"><font color="#0066FF" size="+3">:</font></td>
                    <td width="18%">
                        <font color="#0066FF" size="+3"><?php echo"$benar";	?></font>
                    </td>
                </tr>  
                <tr>
                	<td><font color="#EE0000" size="+3">Total S + N</font></td><td><font color="#EE0000" size="+3">:</font></td>
                    <td>
                        <font color="#EE0000" size="+3"><?php echo"$salah";	?></font>
                    </td>
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
														<td valign="top">B = Benar<br />S = Salah<br />N = Nihil(kosong)</td>
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
