<?php
     function QueryDatabase($d3,$cf,$data_invoice)
     {
		$data=array(
			'SPPD_INDEX'=>"$d3",
		);

		$cr_data=array(
			'case'=>"data_preview_443",
			'batas'=>1,
			'halaman'=>1,
			'user_privileges_data'=>$_COOKIE['data_http'],
			'data'=>$data,
		);
		
		$SW=new SWITCH_DATA();
		$SW->data_location="local"; //local,external
		$SW->cr_data=$cr_data;
		$SW->CLS=new sppd_master(); //nama class -> khusus untuk local data.
		$SW->ref="sppd_master"; //nama file --> khusus untuk external data
		$da=$SW->output(); 
		
		
		foreach($da['refs'] as $row){
			$callback['sppd'][]=$row;
		}

		foreach($da['refs'][0]['approved'] as $row_approved)
		{
			$callback['approved'][]=$row_approved;	
		}
		
		foreach($da['refs'][0]['pengikut'] as $row_pengikut)
		{
			$callback['pengikut'][]=$row_pengikut;	
		}
		
		return $callback;
	 }
//---CLASS PERTAMA--//
class FPDF_AutoWrapTable extends PDFTable 
{
		
       
    function __construct($data = array(), $options = array()) {
    parent::__construct();
    $this->data = $data;
    $this->options = $options;
    }
    
    public function rptDetailData () 
    {
	    $border = 0;
	    $this->AddPage();
	    $this->SetAutoPageBreak(true,60);
	    $this->AliasNbPages();
	    $left = 0;
	    
	    	$tgl_requested=$this->data['approved'][0]['SPPD_APPROVED_REQUEST_OLEH_TANGGAL'];
	    	if($tgl_requested=="0000-00-00 00:00:00")
	    		{
					$tgl_requested2="";
				}else
				{
					$tgl_requested2=tanggal_format(Date("Y-m-d",strtotime($this->data['approved'][0]['SPPD_APPROVED_REQUEST_OLEH_TANGGAL'])));	
				}
			$tgl_checked=$this->data['approved'][0]['SPPD_APPROVED_ACKNOEWLEDGED_OLEH_TANGGAL'];
	    	if($tgl_checked=="0000-00-00 00:00:00")
	    		{
					$tgl_checked2="";
				}else
				{
					$tgl_checked2=tanggal_format(Date("Y-m-d",strtotime($this->data['approved'][0]['SPPD_APPROVED_ACKNOEWLEDGED_OLEH_TANGGAL'])));	
				}
			$tgl_approved=$this->data['approved'][0]['SPPD_APPROVED_OLEH_TANGGAL'];
	    	if($tgl_approved=="0000-00-00 00:00:00")
	    		{
					$tgl_approved2="";
				}else
				{
					$tgl_approved2=tanggal_format(Date("Y-m-d",strtotime($this->data['approved'][0]['SPPD_APPROVED_OLEH_TANGGAL'])));	
				}
	    //---HTML -------//
	    $table1 = "
				<table border=1 align=left  width=535>
				  <tr>
				    <td rowspan=4 border=1011 width=10>1.</td>
				    <td rowspan=4 border=1110 width=130>".$this->options['cf']['sppd_config']['pimpinan_perintah']."</td>
				    <td border=0001 width=65 paddingCell>Nama</td>
				    <td border=0000 width=5>:</td>
				    <td border=0100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_OLEH_NAMA']."</td>
				  </tr>
				  
				  <tr>
				  	<td border=0001 width=65 paddingCell>NIK</td>
				    <td border=0000 width=5>:</td>
				    <td border=0100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_OLEH_NIK']."</td>
				  </tr>
				  
				  <tr>
				  	<td border=0001 width=65 paddingCell>Departemen</td>
				    <td border=0000 width=5>:</td>
				    <td border=0100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_OLEH_DEPARTEMEN']."</td>
				  </tr>
				  
				  <tr>
				  	<td border=0001 width=65 paddingCell>Jabatan</td>
				    <td border=0000 width=5>:</td>
				    <td border=0100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_OLEH_JABATAN']."</td>
				  </tr>
				</table>
				";
			$table2 = "
				<table border=1 align=left  width=535>
				  <tr>
				    <td rowspan=5 border=1011 width=10>2.</td>
				    <td rowspan=5 border=1110 width=130>Karyawan yang diberi perintah <font style=bold>/PIC dinas luar</td>
				    <td border=1001 width=65>Nama</td>
				    <td border=1000 width=5>:</td>
				    <td border=1100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_KE_NAMA']."</td>
				  </tr>
				  
				  <tr>
				  	<td border=0001 width=65>NIK</td>
				    <td border=0000 width=5>:</td>
				    <td border=0100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_KE_NIK']."</td>
				  </tr>
				  
				  <tr>
				  	<td border=0001 width=65>Departemen</td>
				    <td border=0000 width=5>:</td>
				    <td border=0100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_KE_DEPARTEMEN']."</td>
				  </tr>
				  
				  <tr>
				  	<td border=0001 width=65>Jabatan</td>
				    <td border=0000 width=5>:</td>
				    <td border=0100 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_KE_JABATAN']."</td>
				  </tr>
				  
				  <tr>
				  	<td border=0011 width=65>No. HP</td>
				    <td border=0010 width=5>:</td>
				    <td border=0110 width=324>".$this->data['sppd'][0]['SPPD_PERINTAH_KE_HP']."</td>
				  </tr>
				</table>
				";
	    
	    //END HTML -----------------------------------//
	    
	    
	    //---HTML -------//
	    $table3 = "
				<table border=1 align=left  width=535>
				  <tr>
				    <td border=1011 width=10>3.</td>
				    <td border=1110 width=129>Maksud dan tujuan Perjalanan Dinas</td>
				    <td border=1110 width=394>".$this->data['sppd'][0]['SPPD_TUJUAN_MAKSUD']."</td>
				  </tr>
				  
				  
				  <tr>
				    <td border=1011 width=10>4.</td>
				    <td border=1110 width=129>Tempat tujuan Perjalanan Dinas</td>
				    <td border=1110 width=394>".$this->data['sppd'][0]['SPPD_TUJUAN_TEMPAT']."</td>
				  </tr>
				</table>
				";
			
			$table4 = "
				<table border=1 align=left  width=535>
				  <tr>
				    <td border=1001 width=10>5.</td>
				    <td border=1000 width=129 colspan=2>Perencanaan Perjalanan Dinas</td>
				    <td border=1101 width=394></td>
				  </tr>
				  
				  <tr>
				    <td border=0001 width=10></td>
				    <td border=0000 width=11>a.</td>
				    <td border=0100 width=118>Lamanya Perjalanan<br>Dinas</td>
				    <td border=0100 width=394>".$this->data['sppd'][0]['SPPD_LAMA']."</td>
				  </tr>
				  
				  <tr>
				    <td border=0001 width=10></td>
				    <td border=0000 width=11>b.</td>
				    <td border=0100 width=118>Tanggal Berangkat</td>
				    <td border=0100 width=394>".tanggal_format(Date("Y-m-d",strtotime($this->data['sppd'][0]['SPPD_TANGGAL_BERANGKAT'])))."</td>
				  </tr>
				  
				  
				  <tr>
				    <td border=0011 width=10></td>
				    <td border=0010 width=11>c.</td>
				    <td border=0110 width=118>Tanggal Pulang</td>
				    <td border=0110 width=394>".tanggal_format(Date("Y-m-d",strtotime($this->data['sppd'][0]['SPPD_TANGGAL_PULANG'])))."</td>
				  </tr>
				</table>
				";		
			
			$table5 = "
				<table border=1 align=left  width=535>
				  <tr>
				    <td border=1011 width=10>6.</td>
				    <td border=1110 width=130>Fasilitas </td>
				    <td border=1110 width=394>".stripslashes($this->data['sppd'][0]['SPPD_FASILITAS'])."</td>
				  </tr>
				  
				";
				
			//PENGIKUT---//
			    	$nopengikut=1;
					foreach ($this->data['pengikut'] as $baris) 
			    	{
						$barishtml[]="
							<tr>
								<td width=101>$baris[SPPD_PENGIKUT_NAMA]</td>
								<td width=15>$baris[SPPD_PENGIKUT_NIK]</td>
								<td width=70>$baris[SPPD_PENGIKUT_JABATAN]</td>
								<td width=20>$baris[SPPD_PENGIKUT_HP]</td>
								<td width=55>$baris[SPPD_PENGIKUT_TTD]</td>
								<td width=69>$baris[SPPD_PENGIKUT_PIMPINAN_NIK]</td>
								</tr>";
						$nopengikut++;
					}
					$jumlahRowspan=count($barishtml)+1;
					for($ipengikut=0;$ipengikut<=count($barishtml);$ipengikut++){
						$barishtml2 .=$barishtml[$ipengikut];
					}
					
					$tablePengikut="<table border=1 align=left width=535>
					            <tr>
								    <td width=11 rowspan=$jumlahRowspan border=1011>7.</td>
								    <td width=130 rowspan=$jumlahRowspan border=1110>Pengikut Perjanan Dinas</td>
								    <td width=101 align=center valign=middle>Nama</td>
								    <td width=15 align=center valign=middle>NIK</td>
								    <td width=70 align=center valign=middle>Jabatan</td>
								    <td width=20 align=center valign=middle>No.HP Aktif</td>
								    <td width=55 align=center valign=middle>T. Tangan Peserta</td>
								    <td width=69 align=center valign=middle>T. Tangan Pimpinan Dept.</td>
							  	</tr>$barishtml2";
			    //END PENGIKUT--------------------------------//	
			
				
			$table8 = "
				<table border=1 align=left  width=535>
				  <tr>
				    <td border=1011 width=10>8.</td>
				    <td border=1110 width=130>Keterangan Lain-lain </td>
				    <td border=1110 width=394>".stripslashes($this->data['sppd'][0]['SPPD_KETERANGAN'])."</td>
				  </tr>
				  
				  <tr>
				    <td border=1011 width=10>9.</td>
				    <td border=1110 width=524 colspan=2>Persetujuan dan tanda tangan </td>
				  </tr>
				  
				";
			$table9 = "
				<table border=1 width=535>
				  <tr>
				    <td colspan=3 align=center>
				    	<font style=bold>Requested and Checkked by:
				    </td>
				    <td colspan=3 align=center>
				    	<font style=bold>Acknowledged by:
				    </td>
				    <td colspan=3 align=center>
				    	<font style=bold>Approved by:
				    </td>
				  </tr>
				  <tr>
				    <td colspan=3 height=40>
				    	&nbsp;
				    </td>
				    <td colspan=3 height=40>
				    	&nbsp;
				    </td>
				    <td colspan=3 height=40>
				    	&nbsp;
				    </td>
				  </tr>
				  
				  
				  <tr>
				    <td border=1001 width=40>
				    	Name
				    </td>
				    <td border=1000 width=5>:</td>
				    <td border=1100 width=133>
				    	".$this->data['approved'][0]['SPPD_APPROVED_REQUEST_OLEH_NAMA']."
				    </td>
				    
				    <td border=1001 width=40>
				    	Name
				    </td>
				    <td border=1000 width=5>:</td>
				    <td border=1100 width=133>
				    	".$this->data['approved'][0]['SPPD_APPROVED_ACKNOEWLEDGED_OLEH_NAMA']."
				    </td>
				    
				    <td border=1001 width=40>
				    	Name
				    </td>
				    <td border=1000 width=5>:</td>
				    <td border=1100 width=133>
				    	".$this->data['approved'][0]['SPPD_APPROVED_OLEH_NAMA']."
				    </td>
				  </tr>
				  
				  <tr>
				    <td border=0001 width=40>
				    	Position
				    </td>
				    <td border=0 width=5>:</td>
				    <td border=0100 width=133>
				    	".$this->data['approved'][0]['SPPD_APPROVED_REQUEST_OLEH_JABATAN']."
				    </td>
				    
				    <td border=0001 width=40>
				    	Position
				    </td>
				    <td border=0 width=5>:</td>
				    <td border=0100 width=133>
				    	".$this->data['approved'][0]['SPPD_APPROVED_ACKNOEWLEDGED_OLEH_JABATAN']."
				    </td>
				    
				    <td border=0001 width=40>
				    	Position
				    </td>
				    <td border=0 width=5>:</td>
				    <td border=0100 width=133>
				    	".$this->data['approved'][0]['SPPD_APPROVED_OLEH_JABATAN']."
				    </td>
				  </tr>
				  
				  <tr>
				    <td border=0011 width=40>
				    	Date
				    </td>
				    <td border=0010 width=5>:</td>
				    <td border=0110 width=133>
				    	$tgl_requested2
				    </td>
				    
				    <td border=0011 width=40>
				    	Date
				    </td>
				    <td border=0010 width=5>:</td>
				    <td border=0110 width=133>
				    	$tgl_checked2
				    </td>
				    
				    <td border=0011 width=40>
				    	Date
				    </td>
				    <td border=0010 width=5>:</td>
				    <td border=0110 width=133>
				    	$tgl_approved2
				    </td>
				  </tr>
				</table>
				";
    
	    //END HTML -----------------------------------//
	    
	    $this->htmltable($table1);
	    $this->htmltable($table2);
	    $this->htmltable($table3);
	    $this->htmltable($table4);
	    $this->htmltable($table5);
	    $this->htmltable($tablePengikut);
	    $this->htmltable($table8);
	    $this->htmltable($table9);
    
    }
    
    public function printPDF () 
    {
		if ($this->options['paper_size'] == "F4") {
		$aaa = 8.3 * 72; //1 inch = 72 pt
		$bbb = 13.0 * 72;
		$this->FPDF($this->options['orientation'], "pt", array($aaa,$bbb));
		} else {
		$this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
		}
		 
		$this->SetAutoPageBreak(false);
		$this->AliasNbPages();
		$this->SetFont("helvetica", "", 10);
		//$this->AddPage();
		 
		$this->rptDetailData();
		
		 
		$this->Output($this->options['filename'],$this->options['destinationfile']);
		}
		 
		private $widths;
		private $aligns;
		 
		function SetWidths($w)
		{
		//Set the array of column widths
		$this->widths=$w;
		}
		 
		function SetAligns($aaa)
		{
		//Set the array of column alignments
		$this->aligns=$aaa;
		}
		 
		 
		function Row($data)
		{
			//Calculate the height of the row
			$nb=0;
			for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=15*$nb;
			//Issue a page break first if needed
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++)
			{
				$w=$this->widths[$i];
				$aaa=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
				//Save the current position
				$x=$this->GetX();
				$y=$this->GetY();
				//Draw the border
				$this->Rect($x,$y,$w,$h);
				//Print the text
				$this->MultiCell($w,15,$data[$i],0,$aaa);
				//Put the position to the right of the cell
				$this->SetXY($x+$w,$y);
			}
			//Go to the next line
			$this->Ln($h);
		}
		 
		function CheckPageBreak($h)
		{
			//If the height h would cause an overflow, add a new page immediately
			if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
		}
		 
		function NbLines($w,$txt)
		{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb)
			{
			$c=$s[$i];
			if($c=="\n")
			{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
			}
			if($c==' ')
			$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
			if($sep==-1)
			{
			if($i==$j)
			$i++;
			}
			else
			$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			}
			else
			$i++;
		}
		return $nl;
		}
		
		//HEADER
		function Header()
		{
		    $h = 14;
		    $left = 0;
		    $top = 0;
		    //$this->SetFillColor(222,235,255);
		    $this->SetFillColor(255);
		    $left = $this->GetX();
		    $this->Cell(47,40,$this->Image("".$this->options['cf']['sppd_config']['logo']."",30,30,43),1,0);
		    	$this->SetX($left += 47); $this->Cell(307, $h, $this->options['cf']['sppd_config']['judul_perusahaan'], 1, 0, 'C',true);
		    		$this->SetX($left += 307); 
		    			$this->Cell(70, $h,$this->options['cf']['sppd_config']['section'],'LTB' ,0,'L',0);
		    		$this->SetX($left += 70); //$this->Cell(10, $h, ':', 1,0,1); 
		    			$this->Cell(10,$h,':','TB',0,'L',0);
		    		$this->SetX($left += 10); //$this->Cell(100, $h, ':', 1,0,1);
		    			$this->Cell(101,$h,'','TBR',0,'L',0);
   
   
		   $this->Ln(14); 	
		   		$judul_perusahaan	=$this->options['cf']['sppd_config']['judul_surat']	;
		   		$judul_surat		=$this->data['sppd'][0]['SPPD_NOMOR']	;
		    	$this->SetX(75.2);$this->MultiCell(307,13,"$judul_perusahaan\n$judul_surat", 1,'C',1,true);
		    	
		    	$left = $this->GetX();
		    		$this->SetY(42.2);
		    		$this->SetX($left += 354);$this->Cell(70, 13,$this->options['cf']['sppd_config']['revision'],'LTB',0,'L',0);
		    		$this->SetX($left += 70); $this->Cell(10,13,':','TB',0,'L',0);
		    		$this->SetX($left += 10); $this->Cell(101,13,'00','TBR',0,'L',0);
		    		
		    		$this->Ln(13.1);
		    		$this->SetX(62.3);
		    	$left = $this->GetX();
		    		
		    		$this->SetX($left += 320);$this->Cell(70, 13,$this->options['cf']['sppd_config']['page'] ,'LBT',0,'L',0);
		    		$this->SetX($left += 70); $this->Cell(10, 13, ':','TB', 0,'L',0);
		    		$this->SetX($left += 10); $this->Cell(101, 13, $this->PageNo().' Of {nb}','TBR', 0,'L',0);
		    
		    
		    $this->Ln(13); 
		    	$this->SetX(28.3);$this->Cell(535,12,"", 1,'C',1,true);
		    $this->Ln();
    //---------------------------------------------------------------------//
		}
		
		//Page footer
		/*function Footer()
		{
			//atur posisi 1.5 cm dari bawah
			$this->SetY(-15);
			//Arial italic 9
			$this->SetFont('Arial','I',9);
			//nomor halaman
			$this->Cell(0,10,'Halaman '.$this->PageNo().'',0,0,'R');
			
		}*/
    } //end of class
     
    
     
	$data=QueryDatabase($d3,$cf,$data_invoice,$user_data);  
    
    //pilihan
    $options = array(
    'filename' => 'SPPD-'.$d3.".pdf", //nama file penyimpanan, kosongkan jika output ke browser
    'destinationfile' => 'I', //I=inline browser (default), F=local file, D=download
    'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
    'orientation'=>'P', //orientation: P=portrait, L=landscape
    'cf'=>$cf
    );
     
    $tabel = new FPDF_AutoWrapTable($data, $options,$table1);
    
    $tabel->printPDF();

//END CLASS PERTAMA---------------------------------------------------------//

	

/*$p = new PDFTable();
$p->AddPage();
$p->setfont('times','',12);
$p->htmltable($table1);
$p->htmltable($table2);
$p->htmltable($table3);
$p->output();*/
    
    ?>

