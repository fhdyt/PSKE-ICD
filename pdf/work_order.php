<?php

//==============================================================
//==============================================================
//==============================================================
include("../../main.config.php");


$mpdf=new mPDF('c','A4','','',10,10,9,10,5,5); 

//==============================================================

$mpdf->pagenumPrefix = 'Halaman ';
$mpdf->pagenumSuffix = '';
$mpdf->nbpgPrefix = ' dari ';
$mpdf->nbpgSuffix = '.';
$header = array(
	'L' => array(
	),
	'C' => array(
	),
	'R' => array(
		'content' => '{PAGENO}{nbpg}',
		'font-family' => 'sans',
		'font-style' => '',
		'font-size' => '9',	/* gives default */
	),
	'line' => 1,
);

$css="<style>
		
		.table2-header{
			border:1px solid #000 !important;
			border-collapse: collapse;
			margin-top:-1px;
			width:100%;
		}
		.table2-header td{
			font-weight:bold;
			padding:3px;
			border:1px solid #000 !important;	
			font-size:14px;
		}
		.table2-header td{
			padding:0px;
		}
		
		.table2{
			border:1px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
		}
		.table2 td,.table2 th{
			padding:1px;
			border:1px solid #000 !important;	
			font-size:11px;
			color:#150000;
		}
		
		.table2 th{
		 text-align:center;	
		 font-weight:bold !important;
		}
		
		.table2 td h3{
			font-size:12px;
			font-weight:bold;
			line-height:0px;
		}
		
		
		.table2-unbordered{
			border:0px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
			width:100%;
		}
		.table2-unbordered td,.table2-unbordered th{
			padding:3px;
			border:0px solid #000 !important;	
			font-size:9px;
		}
		
		
		
		.table3{
			border-collapse: collapse;
			margin-top:-1px;
		}
		.table3 td,.table3 th{
			padding:1px;
			font-size:11px;
			color:#150000;
		}
		
		.table3 th{
		 text-align:center;	
		 font-weight:bold !important;
		}
		
		.table3 td h3{
			font-size:12px;
			font-weight:bold;
			line-height:0px;
		}
		
		
		.table3-unbordered{
			border:0px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
			width:100%;
		}
		.table3-unbordered td,.table3-unbordered th{
			padding:3px;
			border:0px solid #000 !important;	
			font-size:9px;
		}
		
		
		
		.table4{
			border:1px solid #000;
			border-collapse: collapse;
			margin-top:-1px;
		}
		.table4 td,.table4 th{
			padding:1px;
			border:1px solid #000 !important;	
			border-top:0px solid #000 !important;	
			font-size:11px;
			color:#150000;
		}
		
		.table4 th{
		 text-align:center;	
		 font-weight:bold !important;
		}
		
		.table4 td h3{
			font-size:12px;
			font-weight:bold;
			line-height:0px;
		}
		
		
		.text-center{
			text-align:center;
		}
		.text-left{
			text-align:left;
		}
		
		.text-right{
			text-align:right;
		}
		
		.text-danger{
			color:#DF0C0F;
		}
		.text-warning{
			color:#DFB70C;
		}
		
		strong.unit-name{
			font-size:17px;
		}
		
		hr.header{
			color:#2F2B27;
		}
		
		h3{
			text-align:center;
		}
		
		.unit-name-33{
			color:#B83F21;
		}
		.unit-name-34{
			color:#21648E;
		}
		ol li{
			font-size:11px;
		}
		
		.box1{
			border:1px solid #000 !important;
			margin-top:-1.5px;
			width:100%;
			margin: auto;
			padding:30px;
			padding-bottom:0;
		}
		
		.table2-content{
			
		}
		
		.table2-content td{
			height:11px;
		}
		.sub-title{
			padding-left:20px;
			font-weight:bold;
			padding-top:2px;
			text-transform: uppercase;
			font-size:13px;
			color:#0D0303;
		}
		
		.sub-title i{
			color:#3A3939;
			text-transform: lowercase;
		}
		
		.td-kuning{
			background:#EFCD12;
		}
		
		
		.table-comments{
			width:100%;
		}
		.table-comments td,.table-comments th{
			width:210px;
			border-bottom:1px dotted #827D7D !important;
			text-align:left;
			font-size:8px;
		}
		.table-comments th.title{
			color:#424242;
		}
		
		.darurat{
			background:#EFCD12;
		}
		.td-hrd{
		  background-color:#BFBFBF;
		}
		.judul_wo{
			font-size:20px;

		}
		.tdjudul_list{
			font-weight:bold;
			border-bottom:1px solid #000;
		}
		.noborder{
			border:none;
		}
		.wo_red{background-color:#FF2D00;}
		.wo_yellow{background-color:#FFF100;}
		.wo_green{background-color:#008000;}
		
	</style>";

$input_option=array(
	'WO_MASTER_ID'=>$d4,
	'DATA_STATUS'=>$d5,
	'WO_MASTER_REVISI'=>$d6,
);
$params=array(
	//'case'=>"presensi_lembur_spl_pdf_nonlogin",
	'case'=>"nonlogin_wo_pdf",
	'batas'=>22,
	'halaman'=>1,
	'data_http'=>$_COOKIE['data_http'],
	'input_option'=>$input_option,
);
$respon=$WO->wo_master($params)->load->module;

foreach($respon['result'] as $r){
	$datawo[]=$r;
}
#echo "<pre>".print_r($respon,true)."</pre>";
//exit();

$no=1;
foreach($datawo[0]['DETAIL'] as $detail){
	if(count($datawo[0]['DETAIL'])>1)
	{
		if(count($datawo[0]['DETAIL'])>2)
		{
			$height="";
		}else
		{
			if($no==1){$height="";}else
			{$height="70";}
		}
	}else
	{
		$height="100";	
	}
	$detail_records .='<tr height="'.$height.'">
							<td valign="top" align="right"  height="'.$height.'">'.$no.'.</td>
							<td valign="top" >'.$detail['WO_DETAIL_DESCRIPTION'].'</td>
							<td valign="top"  style="border-right:0 !important;" align="right" width="30">'.$detail['WO_DETAIL_QUANTITY'].'</td>
							<td valign="top"  style="border-left:0 !important;" align="left" width="40">'.$detail['WO_UNIT_NAME'].'</td>
							<td valign="top" >'.$detail['WO_DETAIL_DATE_COMPLETED'].'</td>
							<td valign="top" >No. Rek : '.$detail['WO_DETAIL_NOREKENING'].'<br>'.$detail['WO_DETAIL_TUJUAN'].'</td>
						</tr>';
$no++;	
}


### == Tampilkan WO Approve ke HTML ===//
$no=0;
foreach($respon['result']['approval']['APPROVE'] as $r){
	
	if($r['CONFIG_APPROVE_DETAIL_PRIORITY']=='1'){
		$n['INDEX']=0;
	}
	elseif($r['CONFIG_APPROVE_DETAIL_PRIORITY']=='2'){
		$n['INDEX']=1;
	}
	else{
		$n['INDEX']=2;
	}
	
	$n['PERSONAL_NIK']=$r['PERSONAL_NIK'];
    $n['PERSONAL_NAME'] =$r['PERSONAL_NAME'];
    $n['COMPANY_UNIT_NAME'] =$r['COMPANY_UNIT_NAME'];
    $n['COMPANY_UNIT_SHORT_NAME'] =$r['COMPANY_UNIT_SHORT_NAME'];
    $n['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'] =$r['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'];
    $n['CONFIG_APPROVE_DETAIL_PRIORITY'] =$r['CONFIG_APPROVE_DETAIL_PRIORITY'];
    $n['SISTEM_APPROVE_COMMENT'] = $r['SISTEM_APPROVE_COMMENT'];
    $n['SISTEM_APPROVE_STATUS'] = $r['SISTEM_APPROVE_STATUS'];
    $n['SISTEM_APPROVE_TTD_LINK'] = $r['SISTEM_APPROVE_TTD_LINK'];
    $n['SISTEM_APPROVE_DATE'] = $r['SISTEM_APPROVE_DATE'];
    $n['SISTEM_APPROVE_DATE_FORMAT'] = $r['SISTEM_APPROVE_DATE_FORMAT'];
    $n['APPROVE_DATA_JSON2'] = $r['APPROVE_DATA_JSON2'];
    $n['APPROVE_DATA_JSON_AS'] = $r['APPROVE_DATA_JSON_AS']; 
   // $comments_spl .="<tr><td><strong>".$r['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME']."</strong> : ".$r['SISTEM_APPROVE_COMMENT']."</td></tr>";
    
    
	$approve_format[]=$n;
$no++;	
}

sort($approve_format);

$no=0;
foreach($approve_format as $r){
	if($r['INDEX']==$no){
		$r['NOT']=$r['INDEX'];	
	}else{
		$r['NOT']=$no;
	}
	
	$approve_format2[]=$r;
$no++;	
}

$no=0;
foreach($approve_format2 as $r){
	if($r['INDEX']!=$r['NOT']){
		$approve_format3[$no]['PERSONAL_NIK']="";
		$approve_format3[$no]['PERSONAL_NAME']="-";
		$approve_format3[$no]['COMPANY_UNIT_NAME']="-";
		$approve_format3[$no]['COMPANY_UNIT_SHORT_NAME']="-";
		$approve_format3[$no]['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME']="Division Head";
		$approve_format3[$no]['CONFIG_APPROVE_DETAIL_PRIORITY']="";
		$approve_format3[$no]['SISTEM_APPROVE_COMMENT']="";
		$approve_format3[$no]['SISTEM_APPROVE_STATUS']="-";
		$approve_format3[$no]['SISTEM_APPROVE_TTD_LINK']="-";
		$approve_format3[$no]['SISTEM_APPROVE_DATE']="-";
		$approve_format3[$no]['SISTEM_APPROVE_DATE_FORMAT']="-";
		$approve_format3[$no]['INDEX']=$r['NOT'];
		$approve_format3[$no]['NOT']="";
		
	}
	$approve_format3[]=$r;
$no++;	
}

#echo "<pre>".print_r($approve_format3,true)."</pre>";
#exit();

foreach($approve_format as $r){
	
	$html_approve .='<td>
							<table class="table2 table2-unbordered">
								<tr><td>Name</td><td>:'.$r['PERSONAL_NAME'].'</td></tr>
								<tr><td>Post/Dept</td><td>:'.$r['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'].' '.$r['COMPANY_UNIT_SHORT_NAME'].'</td></tr>
								<tr><td>Date</td><td>:'.$r['SISTEM_APPROVE_DATE_FORMAT'].'</td></tr>
							</table>
						</td>';
						
	//$html_approve_status .='<td>'.$r['SISTEM_APPROVE_STATUS'].'</td>';	
	 if($r['SISTEM_APPROVE_TTD_LINK']=='-'){
		 $html_approve_status .='<td>-</td>';
	 }else{
		//$html_approve_status .='<td class="text-center"><a href="javascript:;"  JSON="+data.result[i].APPROVE_DATA_JSON2.json+" Jabatan="+data.result[i].APPROVE_DATA_JSON2.Jabatan+" Name="+data.result[i].APPROVE_DATA_JSON2.Name+" Unit="+data.result[i].APPROVE_DATA_JSON2.Unit+" class="btn-approve" LABEL="Yakin akan melakukan Approve ?"><strong><i class="fa fa-thumbs-o-up fa-rotate-180 fa-4x text-danger"></i><i class="fa fa-thumbs-o-up fa-4x text-success"></i><br/>Approval</strong></a></td>';
		if(empty($r['APPROVE_DATA_JSON2'])){
			if(empty($r['SISTEM_APPROVE_TTD_LINK'])){
				if($r['SISTEM_APPROVE_STATUS']=='disapprove'){
					 $html_approve_status .='<td class="text-center"><strong class="text-danger">Disapprove</strong></td>';
				}else{
					$html_approve_status .="<td class='text-center'><a href=javascript:modal_approve('".$r['APPROVE_DATA_JSON_AS']."');><strong><i class='fa fa-thumbs-o-up fa-rotate-180 fa-4x text-muted'></i><i class='fa fa-thumbs-o-up fa-4x text-muted'></i><br/>Approve as</strong></a></td>";
				}
			}else{
				$html_approve_status .='<td class="text-center"><img src="'.$r['SISTEM_APPROVE_TTD_LINK'].'" width="90" alt="ttd"></td>';
			}
		}else{
			if(empty($r['SISTEM_APPROVE_TTD_LINK'])){
				if($r['SISTEM_APPROVE_STATUS']=='disapprove'){
					 $html_approve_status .='<td class="text-center"><strong class="text-danger">Disapprove</strong></td>';
				}else{
					$html_approve_status .="<td class='text-center'><a href='javascript:;'  JSON='".$r['APPROVE_DATA_JSON2']['json']."' Jabatan='".$r['APPROVE_DATA_JSON2']['Jabatan']."' Name='".$r['APPROVE_DATA_JSON2']['Name']."' Unit='".$r['APPROVE_DATA_JSON2']['Unit']."'  SISTEM_APPROVE_COMMENT='".$r['APPROVE_DATA_JSON2']['SISTEM_APPROVE_COMMENT']."' class='btn-approve' LABEL='Yakin akan melakukan Approve ?'><strong><i class='fa fa-thumbs-o-up fa-rotate-180 fa-4x text-danger'></i><i class='fa fa-thumbs-o-up fa-4x text-success'></i><br/>Approval</strong></a></td>";	
				}
			}else{
				$html_approve_status .='<td class="text-center"><img src="'.$r['SISTEM_APPROVE_TTD_LINK'].'" width="90" alt="ttd"></td>';
			}
		}
	 }
	 
	 
	 
	 $comments_spl .="<tr><td><strong>".$r['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME']."</strong> : ".$r['SISTEM_APPROVE_COMMENT']."</td></tr>";			
$no++;						
}
//lakukan ini jika data approve tidak ada
if(empty($respon['result']['approval']['APPROVE'])){
	$html_approve .='<td>
							<table class="table2 table2-unbordered">
								<tr><td>Name</td><td>:{{Name}}</td></tr>
								<tr><td>Post/Dept</td><td>:{{Position}}</td></tr>
								<tr><td>Date</td><td>:{{Date}}</td></tr>
							</table>
						</td>';
	$html_approve_status .='<td>-</td>';					
}
##===end  HTML SPL Approve==//



### == Tampilkan WO Approve Tujuan ke HTML ===//
$no_tujuan_tujuan=0;
foreach($respon['result']['approval_tujuan']['APPROVE'] as $r_tujuan){
	
	if($r_tujuan['CONFIG_APPROVE_DETAIL_PRIORITY']=='1'){
		$n_tujuan['INDEX']=0;
	}
	elseif($r_tujuan['CONFIG_APPROVE_DETAIL_PRIORITY']=='2'){
		$n_tujuan['INDEX']=1;
	}
	else{
		$n_tujuan['INDEX']=2;
	}
	
	$n_tujuan['PERSONAL_NIK']=$r_tujuan['PERSONAL_NIK'];
    $n_tujuan['PERSONAL_NAME'] =$r_tujuan['PERSONAL_NAME'];
    $n_tujuan['COMPANY_UNIT_NAME'] =$r_tujuan['COMPANY_UNIT_NAME'];
    $n_tujuan['COMPANY_UNIT_SHORT_NAME'] =$r_tujuan['COMPANY_UNIT_SHORT_NAME'];
    $n_tujuan['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'] =$r_tujuan['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'];
    $n_tujuan['CONFIG_APPROVE_DETAIL_PRIORITY'] =$r_tujuan['CONFIG_APPROVE_DETAIL_PRIORITY'];
    $n_tujuan['SISTEM_APPROVE_COMMENT'] = $r_tujuan['SISTEM_APPROVE_COMMENT'];
    $n_tujuan['SISTEM_APPROVE_STATUS'] = $r_tujuan['SISTEM_APPROVE_STATUS'];
    $n_tujuan['SISTEM_APPROVE_TTD_LINK'] = $r_tujuan['SISTEM_APPROVE_TTD_LINK'];
    $n_tujuan['SISTEM_APPROVE_DATE'] = $r_tujuan['SISTEM_APPROVE_DATE'];
    $n_tujuan['SISTEM_APPROVE_DATE_FORMAT'] = $r_tujuan['SISTEM_APPROVE_DATE_FORMAT'];
    $n_tujuan['APPROVE_DATA_JSON2'] = $r_tujuan['APPROVE_DATA_JSON2'];
    $n_tujuan['APPROVE_DATA_JSON_AS'] = $r_tujuan['APPROVE_DATA_JSON_AS']; 
   // $comments_spl .="<tr><td><strong>".$r_tujuan['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME']."</strong> : ".$r_tujuan['SISTEM_APPROVE_COMMENT']."</td></tr>";
    
    
	$approve_format_tujuan[]=$n_tujuan;
$no_tujuan++;	
}

sort($approve_format_tujuan);

$no_tujuan=0;
foreach($approve_format_tujuan as $r_tujuan){
	if($r_tujuan['INDEX']==$no_tujuan){
		$r_tujuan['NOT']=$r_tujuan['INDEX'];	
	}else{
		$r_tujuan['NOT']=$no_tujuan;
	}
	
	$approve_format_tujuan2[]=$r_tujuan;
$no_tujuan++;	
}

$no_tujuan=0;
foreach($approve_format_tujuan2 as $r_tujuan){
	if($r_tujuan['INDEX']!=$r_tujuan['NOT']){
		$approve_format_tujuan3[$no_tujuan]['PERSONAL_NIK']="";
		$approve_format_tujuan3[$no_tujuan]['PERSONAL_NAME']="-";
		$approve_format_tujuan3[$no_tujuan]['COMPANY_UNIT_NAME']="-";
		$approve_format_tujuan3[$no_tujuan]['COMPANY_UNIT_SHORT_NAME']="-";
		$approve_format_tujuan3[$no_tujuan]['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME']="Division Head";
		$approve_format_tujuan3[$no_tujuan]['CONFIG_APPROVE_DETAIL_PRIORITY']="";
		$approve_format_tujuan3[$no_tujuan]['SISTEM_APPROVE_COMMENT']="";
		$approve_format_tujuan3[$no_tujuan]['SISTEM_APPROVE_STATUS']="-";
		$approve_format_tujuan3[$no_tujuan]['SISTEM_APPROVE_TTD_LINK']="-";
		$approve_format_tujuan3[$no_tujuan]['SISTEM_APPROVE_DATE']="-";
		$approve_format_tujuan3[$no_tujuan]['SISTEM_APPROVE_DATE_FORMAT']="-";
		$approve_format_tujuan3[$no_tujuan]['INDEX']=$r_tujuan['NOT'];
		$approve_format_tujuan3[$no_tujuan]['NOT']="";
		
	}
	$approve_format_tujuan3[]=$r_tujuan;
$no_tujuan++;	
}

#echo "<pre>".print_r($approve_format_tujuan3,true)."</pre>";
#exit();

foreach($approve_format_tujuan3 as $r_tujuan){
	
	$html_approve_tujuan .='<td>
							<table class="table2 table2-unbordered">
								<tr><td>Name</td><td>:'.$r_tujuan['PERSONAL_NAME'].'</td></tr>
								<tr><td>Post/Dept</td><td>:'.$r_tujuan['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME'].' '.$r_tujuan['COMPANY_UNIT_SHORT_NAME'].'</td></tr>
								<tr><td>Date</td><td>:'.$r_tujuan['SISTEM_APPROVE_DATE_FORMAT'].'</td></tr>
							</table>
						</td>';
						
	//$html_approve_tujuan_status .='<td>'.$r_tujuan['SISTEM_APPROVE_STATUS'].'</td>';	
	 if($r_tujuan['SISTEM_APPROVE_TTD_LINK']=='-'){
		 $html_approve_tujuan_status .='<td>-</td>';
	 }else{
		//$html_approve_tujuan_status .='<td class="text-center"><a href="javascript:;"  JSON="+data.result[i].APPROVE_DATA_JSON2.json+" Jabatan="+data.result[i].APPROVE_DATA_JSON2.Jabatan+" Name="+data.result[i].APPROVE_DATA_JSON2.Name+" Unit="+data.result[i].APPROVE_DATA_JSON2.Unit+" class="btn-approve" LABEL="Yakin akan melakukan Approve ?"><strong><i class="fa fa-thumbs-o-up fa-rotate-180 fa-4x text-danger"></i><i class="fa fa-thumbs-o-up fa-4x text-success"></i><br/>Approval</strong></a></td>';
		if(empty($r_tujuan['APPROVE_DATA_JSON2'])){
			if(empty($r_tujuan['SISTEM_APPROVE_TTD_LINK'])){
				if($r_tujuan['SISTEM_APPROVE_STATUS']=='disapprove'){
					 $html_approve_tujuan_status .='<td class="text-center"><strong class="text-danger">Disapprove</strong></td>';
				}else{
					$html_approve_tujuan_status .="<td class='text-center'><a href=javascript:modal_approve('".$r_tujuan['APPROVE_DATA_JSON_AS']."');><strong><i class='fa fa-thumbs-o-up fa-rotate-180 fa-4x text-muted'></i><i class='fa fa-thumbs-o-up fa-4x text-muted'></i><br/>Approve as</strong></a></td>";
				}
			}else{
				$html_approve_tujuan_status .='<td class="text-center"><img src="'.$r_tujuan['SISTEM_APPROVE_TTD_LINK'].'" width="90" alt="ttd"></td>';
			}
		}else{
			if(empty($r_tujuan['SISTEM_APPROVE_TTD_LINK'])){
				if($r_tujuan['SISTEM_APPROVE_STATUS']=='disapprove'){
					 $html_approve_tujuan_status .='<td class="text-center"><strong class="text-danger">Disapprove</strong></td>';
				}else{
					$html_approve_tujuan_status .="<td class='text-center'><a href='javascript:;'  JSON='".$r_tujuan['APPROVE_DATA_JSON2']['json']."' Jabatan='".$r_tujuan['APPROVE_DATA_JSON2']['Jabatan']."' Name='".$r_tujuan['APPROVE_DATA_JSON2']['Name']."' Unit='".$r_tujuan['APPROVE_DATA_JSON2']['Unit']."'  SISTEM_APPROVE_COMMENT='".$r_tujuan['APPROVE_DATA_JSON2']['SISTEM_APPROVE_COMMENT']."' class='btn-approve' LABEL='Yakin akan melakukan Approve ?'><strong><i class='fa fa-thumbs-o-up fa-rotate-180 fa-4x text-danger'></i><i class='fa fa-thumbs-o-up fa-4x text-success'></i><br/>Approval</strong></a></td>";	
				}
			}else{
				$html_approve_tujuan_status .='<td class="text-center"><img src="'.$r_tujuan['SISTEM_APPROVE_TTD_LINK'].'" width="90" alt="ttd"></td>';
			}
		}
	 }
	 
	 
	 
	 $comments_spl .="<tr><td><strong>".$r_tujuan['COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME']."</strong> : ".$r_tujuan['SISTEM_APPROVE_COMMENT']."</td></tr>";			
$no_tujuan++;						
}
//lakukan ini jika data approve wo tujuan tidak ada
if(empty($respon['result']['approval_tujuan']['APPROVE'])){
	$html_approve_tujuan .='<td>
							<table class="table2 table2-unbordered">
								<tr><td>Name</td><td>:{{Name}}</td></tr>
								<tr><td>Post/Dept</td><td>:{{Position}}</td></tr>
								<tr><td>Date</td><td>:{{Date}}</td></tr>
							</table>
						</td>';
	$html_approve_tujuan_status .='<td>-</td>';					
}
##===end  HTML WO Tujuan Approve==//





//Hrd Verfication 
	$html_bkl_approve_status .='<td>'.$respon['result']['approval']['VERIFICATION']['STATUS'].'</td>';
	$html_bkl_approve .='<td>
							<table class="table2 table2-unbordered">
								<tr><td>Name</td><td>: '.$respon['result']['bkl']['sumary']['VERIFICATION']['PERSONAL_NAME'].'</td></tr>
								<tr><td>Position</td><td>: '.$respon['result']['bkl']['sumary']['VERIFICATION']['JABATAN'].'</td></tr>
								<tr><td>Date</td><td>: '.$respon['result']['bkl']['sumary']['VERIFICATION']['DATE_FORMAT'].'</td></tr>
							</table>
						</td>';
						
//End Hrd Verfication 

$headerHTML='<br>
<table class="table2 table-bordered" align="center" width="100%">
								<tr>
									<td rowspan="3" width="80" class="text-center tdjudul" style="border:1px solid #000 !important">
										<img src="'.$respon['header']['LOGO_LINK'].'" width="50"/>
									</td>
									<td rowspan="3" class="text-center">
										<font style="font-size:20px;"><strong><u>PESANAN KERJA</u><br>(WORK ORDER)</strong></font>
									</td>
									<td width="38" style="border-right:none !important;">No</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" class="noborder" style="border-left:none !important;">'.$datawo[0]['WO_MASTER_NOMOR'].'</td>
								</tr>
								<tr>
									<td width="38" style="border-right:none !important;">Date</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" style="border-left:none !important;">'.$datawo[0]['WO_MASTER_TANGGAL_2'].'</td>
								</tr>
								<tr>
									<td width="38" style="border-right:none !important;">Page</td>
									<td width="2" style="border-right:none !important;border-left:none !important;">:</td>
									<td width="160" style="border-left:none !important;">'.$datawo[0]['WO_MASTER_PAGE'].'</td>
								</tr>
						</table>
';


$html = '
	<html>
	<head>
		<title>PKB</title>
		'.$css.'
	</head>
	<body>'.$headerHTML.'
		<div class="box1">
			<table class="table3 table-unbordered table3-content" style="border:none;" width="100%">
				<tr>
					<td width="50"><strong>DEPT</strong></td>
					<td width="20"><strong>: &nbsp;</strong></td>
					<td>
						<strong><u>'.$datawo[0]['COMPANY_UNIT_NAME_TO'].'</u></strong>
					</td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3">
						<strong>Mohon dikerjakan pesanan berupa:<br>(Please work on the following)</strong>
					</td>
				</tr>
			</table><br>
		
			<table class="table4 table-bordered" width="100%">
				<tr>
					<td class="text-center tdjudul_list" width="35" style="border-bottom:1px solid #000;">No</td>
					<td class="text-center tdjudul_list">Description</td>
					<td class="text-center tdjudul_list" colspan="2">Quantity</td>
					<td class="text-center tdjudul_list">Date <br>Completed</td>
					<td class="text-center tdjudul_list">Remark</td>
				</tr>
				'.$detail_records.'
			</table>
			
			<br/>
			<table class="table3 table-unbordered table3-content" style="border:none;" width="100%">
											<tr>
												<td class="text-left" valign="bottom" style="border:none;" width="40%">
													<strong>Defenition: Post/Dept: Position/Department</strong>
												</td>
												<td align="right">
													<table class="table2 table-bordered table2-content" width="100%">
														<tr>
															<td width="50%" align="center"><strong>Requested By</strong></td>
															<td width="50%" align="center"><strong>Approved By</strong></td>
														</tr>
														<tr>'.$html_approve_status.$html_approve_tujuan_status.'</tr>
														<tr>
															'.$html_approve.$html_approve_tujuan.'
														</tr>
													</table>
												</td>
											</tr>
			</table>
			<table class="table3 table-unbordered table3-content" style="border:none;" width="100%">
				<tr>
					<td align="right">FRM-QMS-051-01</td>
				</tr>
			</table>
		</div>
		<br><br>
		
	</body>
	</html>
	

';


$footer = '
<table width="100%" style="vertical-align: top; font-size: 10px;"><tr>
<td width="50%" align="left"></td><td class="text-right"> {PAGENO}{nbpg} </td>
</tr></table>
';







//$mpdf->SetHeader($header,'O');
//$mpdf->SetHTMLFooter($footer);
//==============================================================

$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output(); 
exit;

//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>
