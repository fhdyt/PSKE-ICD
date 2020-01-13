<?php
$WO_CONFIG=new WO_CONFIG;
//crontrol
if(empty($params['case'])){
	$result['respon']['pesan']="gagal";
	$result['respon']['text_msg']="Module tidak dapat di muat";
	echo json_encode($result);
	exit();
}


$input=$params['input_option'];
	//$this->callback['respon']['pesan']="sukses";
	//$this->callback['respon']['text_msg']="Data kosong".print_r($input,true);
	//return;
$this->MYSQL=new MYSQL();
$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
$this->MYSQL->queri="select * from WO_MASTER where WO_MASTER_ID='".$input['WO_MASTER_ID']."' and WO_MASTER_INDEX='".$input['WO_MASTER_INDEX']."' and RECORD_STATUS='A'";	
$result_a=$this->MYSQL->data();
$no=1;
foreach($result_a as $r){
	//AMBIL DATA DEPARTMENT
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select COMPANY_UNIT_ID,COMPANY_UNIT_SHORT_NAME, COMPANY_UNIT_NAME from COMPANY_UNIT WHERE  COMPANY_UNIT_ID='".$r['COMPANY_UNIT_ID_TO']."' and RECORD_STATUS='A' AND (COMPANY_UNIT_TYPE='Department' OR COMPANY_UNIT_TYPE='Non-Departement')";	
	$result_department=$this->MYSQL->data();
	$r['DEPARTMENT']=$result_department;
	
	//AMBIL DATA APPROVAL DEPT
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select 
							PERSONAL_NIK,PERSONAL_NAME, COMPANY_STRUKTUR_ORGANISASI_JABATAN_NAME,SISTEM_APPROVE_DATE 
						from SISTEM_APPROVE
						WHERE SISTEM_APPROVE_NOREF='".$r['WO_MASTER_ID']."' and SISTEM_APPROVE_INDEXREF='".$r['WO_MASTER_INDEX']."' and RECORD_STATUS='A'";	
	$result_approve_dept=$this->MYSQL->data();
	foreach($result_approve_dept as $r_approve_dept)
	{
		if($r_approve_dept['SISTEM_APPROVE_DATE']=="" or $r_approve_dept['SISTEM_APPROVE_DATE']==null or $r_approve_dept['SISTEM_APPROVE_DATE']=="0000-00-00 00:00:00")
		{
			$r_approve_dept['SISTEM_APPROVE_DATE_FORMAT']="";
		}else
		{
			$r_approve_dept['SISTEM_APPROVE_DATE_FORMAT']=Date('d/m/Y',strtotime($r_approve_dept['SISTEM_APPROVE_DATE']));
		}
		$r_approve_dept['SISTEM_APPROVE_TTD']="asset/platform/files/ttd/".$r_approve_dept['PERSONAL_NIK'].".png";
		$result_approve_dept2[]=$r_approve_dept;
	}
	
	$r['DEPARTMENT_APPROVE']=$result_approve_dept2;
	
	
	//AMBIL APPROVAL TUJUAN
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select PERSONAL_NIK,PERSONAL_NAME from CONFIG_APPROVE_DETAIL 
		WHERE CONFIG_APPROVE_MASTER_APLIKASI_ID='wo' AND CONFIG_APPROVE_DETAIL_SET_FOR='".$r['COMPANY_UNIT_ID_TO']."' AND RECORD_STATUS='A' AND CONFIG_APPROVE_DETAIL_TYPE='in'";	
	$result_approval_tujuan=$this->MYSQL->data();
	$r['CONFIG_APPROVE_TUJUAN_DETAIL']=$result_approval_tujuan;
	
	
	//AMBIL DATA DETAIL
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select WO_DETAIL_INDEX,WO_DETAIL_ID,WO_DETAIL_DESCRIPTION, WO_DETAIL_QUANTITY,WO_UNIT_ID,WO_UNIT_NAME,WO_DETAIL_DATE_COMPLETED,WO_DETAIL_NOREKENING, WO_DETAIL_TUJUAN
						 from WO_DETAIL WHERE WO_MASTER_NOMOR='".$r['WO_MASTER_NOMOR']."' AND WO_MASTER_ID='".$r['WO_MASTER_ID']."' AND RECORD_STATUS='A'";	
	$result_detail=$this->MYSQL->data();
	$r['DETAIL']=$result_detail;
	
	
	$this->MYSQL=new MYSQL();
	$this->MYSQL->database=$this->CONFIG->mysql_koneksi()->db_nama;
	$this->MYSQL->queri="select WO_UNIT_ID,WO_UNIT_NAME from WO_UNIT WHERE RECORD_STATUS='A'";	
	$result_unit=$this->MYSQL->data();
	$r['UNIT']=$result_unit;
				
		 //TANGGAL INDONESIA */
			$tgl=$r['WO_MASTER_TANGGAL'];
			$indonesia=new indonesia;
			$indonesia->tgl_indo($tgl);
			$r['WO_MASTER_TANGGAL_2']=$indonesia->tanggal."-".substr($indonesia->bulan,0,3)."-".substr($indonesia->tahun,2,2);
		
	
	$result[]=$r;
$no++;	
}

//MENENTUKAN TUJUAN
$data_tujuan=array("Investasi","Perawatan/Modifikasi","Pergantian","Umum");
$jlh_data_tujuan=count($data_tujuan);
$NOBB=1;
for($is=0;$is<$jlh_data_tujuan;$is++)
{
	if($data_tujuan[$is]==$result_a[0]['WO_LAMPIRAN_TUJUAN'])
	{
		$cek_tujuan.='
			<tr>
				<td  width="17%">
					<input type="checkbox" class="form-check stkstatus stkstatus'.$NOBB.'" name="WO_LAMPIRAN_TUJUAN"  checked="checked" onClick=ubahstkstatus('.$NOBB.') value="'.$result_a[0]['WO_LAMPIRAN_TUJUAN'].'">
				</td>
				<td width="83%">'.$result_a[0]['WO_LAMPIRAN_TUJUAN'].'</td>
			</tr>';	
			
	}else
	{
		$cek_tujuan.='								
					<tr>
						<td width="17%">
							<input type="checkbox" class="form-check stkstatus stkstatus'.$NOBB.'" name="WO_LAMPIRAN_TUJUAN" onClick=ubahstkstatus('.$NOBB.') value="'.$data_tujuan[$is].'" disabled>
						</td>
						<td width="83%">'.$data_tujuan[$is].'</td>
					</tr>
					';
	}
	$NOBB++;
}

$tujuan_items=$cek_tujuan;
//END TUJUAN


//MENENTUKAN PRIORITAS
$data_prioritas=array("Menghambat proses produksi","Merusak, kontaminasi produk dan bahan baku","Membahayakan keselamatan","Merusak properti lainnya","Menyebabkan pemborosan","Menurunkan efisiensi","Hubungan sosial kemasyarakatan","Mempengaruhi estetika 5s, melengkapi kekurangan");
$jlh_data_prioritas=count($data_prioritas);
$NOTJ=1;
for($ip=0;$ip<$jlh_data_prioritas;$ip++)
{
	if($data_prioritas[$ip]=="Menghambat proses produksi" or $data_prioritas[$ip]=="Membahayakan keselamatan" or $data_prioritas[$ip]=="Merusak, kontaminasi produk dan bahan baku")
	{
		$warna="wo_red";
	}else if($data_prioritas[$ip]=="Merusak properti lainnya" or $data_prioritas[$ip]=="Menyebabkan pemborosan" or $data_prioritas[$ip]=="Menurunkan efisiensi")
	{
		$warna="wo_yellow";
	}else{$warna="wo_green";}
	if($data_prioritas[$ip]==$result_a[0]['WO_LAMPIRAN_PRIORITAS'])
	{
		$cek_prioritas.='
			<tr class="listprioritas">
				<td width="70%" align="left" valign="top" style="border-bottom:1px solid #ccc;">'.$result_a[0]['WO_LAMPIRAN_PRIORITAS'].'</td>
				<td width="2%">&nbsp;</td>
				<td width="10%" valign="top" class="'.$warna.' table-bordered">
					<input type="checkbox" class="form-check stkprioritas stkprioritas'.$NOTJ.'" name="WO_LAMPIRAN_PRIORITAS" checked="checked" onClick=ubahstkprioritas('.$NOTJ.') value="'.$result_a[0]['WO_LAMPIRAN_PRIORITAS'].'">
				</td>
			</tr>';	
			
	}else
	{
		$cek_prioritas.='								
					<tr class="listprioritas">
						<td width="70%" align="left" valign="top" style="border-bottom:1px solid #ccc;">'.$data_prioritas[$ip].'</td>
						<td width="2%">&nbsp;</td>
						<td width="10%" valign="top" class="'.$warna.' table-bordered">
							<input type="checkbox" class="form-check stkprioritas stkprioritas'.$NOTJ.'" name="WO_LAMPIRAN_PRIORITAS" onClick=ubahstkprioritas('.$NOTJ.') value="'.$data_prioritas[$ip].'" disabled>
						</td>
					</tr>
					';
	}
	$NOTJ++;
}

$prioritas_items=$cek_prioritas;
//END PRIORITAS


if(empty($result)){
	$this->callback['respon']['pesan']="gagal";
	$this->callback['respon']['text_msg']="Data kosong".$filter_a;//$input['WO_MASTER_NOMOR']." -".$input['WO_MASTER_ID'];
	$this->callback['result']=$result;
}else{
	$this->callback['respon']['pesan']="sukses";
	$this->callback['respon']['text_msg']="OK".print_r($result,true);
	$this->callback['result']=$result;
	$this->callback['result']['tujuan']=$tujuan_items;
	$this->callback['result']['prioritas']=$prioritas_items;
}

return;


