<?php
case 'hasil_tes_keseluruhan_443':
			
				$tabel="recruitment_participants";
				$dimana_default="where PESERTA_ID='".$data_array['PESERTA_ID']."' AND RECORD_STATUS='A'";

				$db=new db();
				$db->database=$cf['db_nama'];
				$db->tabel=$tabel;
				$db->kolom="*";
				$db->dimana=$dimana_default;
				$refs=$db->data();
				$no=$posisi+1;
				foreach($refs as $r)
				{	
					//lowongankerja
					$tabel_ambil_lowongankerja="recruitment_participants_lowongankerja a, recruitment_lowongankerja b";
					$dimana_default_ambil_lowongankerja="where a.LOWONGANKERJA_ID=b.LOWONGANKERJA_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_ambil_lowongankerja;
					$db->kolom="b.LOWONGANKERJA_NAMA";
					$db->dimana=$dimana_default_ambil_lowongankerja;
					//$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					
					$refs_ambil_lowongankerja=$db->data();
					if(empty($refs_ambil_lowongankerja))
					{
						$LOWONGANKERJA_NAMA="-";
					}else
					{
						$LOWONGANKERJA_NAMA=$refs_ambil_lowongankerja[0]['LOWONGANKERJA_NAMA'];
					}
					//END lowongankerja 
					
					//pendidikan
					$tabel_pendidikanformal="recruitment_pendidikanformal a, recruitment_tingkatpendidikan b";
					$dimana_default_pendidikanformal="where a.TINGKATPENDIDIKAN_ID=b.TINGKATPENDIDIKAN_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_pendidikanformal;
					$db->kolom="MAX(a.TINGKATPENDIDIKAN_ID) AS TINGKATPENDIDIKAN_ID, b.TINGKATPENDIDIKAN_NAMA, a.PENDIDIKAN_FORMAL_JURUSAN";
					$db->dimana=$dimana_default_pendidikanformal;
					$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					$refs_pendidikanformal=$db->data();
					
					if(empty($refs_pendidikanformal))
					{
						$TINGKATPENDIDIKAN_NAMA="-";
					}else
					{
						$TINGKATPENDIDIKAN_NAMA=$refs_pendidikanformal[0]['TINGKATPENDIDIKAN_NAMA']."-".$refs_pendidikanformal[0]['PENDIDIKAN_FORMAL_JURUSAN'];
					}
					//END pendidikan 
					
					
					//mengambil info dari recruitment_topiksoal
					$tabel_topiksoal= "recruitment_topiksoal";
					$dimana_default_topiksoal="where PESERTA_ID='$r[PESERTA_ID]' AND RECORD_STATUS='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_topiksoal;
					$db->kolom="TOPIKSOAL_ID,TOPIKSOAL_JUDUL,TOPIKSOAL_WAKTUP,TOPIKSOAL_BAGIAN,TOPIKSOAL_INFO";
					$db->dimana=$dimana_default_topiksoal;
					$refs_topiksoal=$db->data();
					
							$topiksoal_id=$r['TOPIKSOAL_ID'];
							if($topiksoal_id=="TS001" or $topiksoal_id=="TS009")
								{
									$topikjudul="ROTIBD HITUNG";	
								}
							elseif($topiksoal_id=="TS002" or $topiksoal_id=="TS010")
								{
									$topikjudul="ROTIBD PERBENDAHARAAN";	
								}
							elseif($topiksoal_id=="TS003" or $topiksoal_id=="TS011")
								{
									$topikjudul="ROTIBD PENGETAHUAN UMUM";	
								}
							elseif($topiksoal_id=="TS004" or $topiksoal_id=="TS012")
								{
									$topikjudul="ROTIBD SPASIAL";	
								}
							elseif($topiksoal_id=="TS005" or $topiksoal_id=="TS013")
								{
									$topikjudul="ROTIBD ANALOGI";	
								}
							elseif($topiksoal_id=="TS006" or $topiksoal_id=="TS014")
								{
									$topikjudul="ROTIBD PEMAHAMAN";	
								}
							elseif($topiksoal_id=="TS007" or $topiksoal_id=="TS015")
								{
									$topikjudul="ROTIBD PENALARAN";	
								}
							elseif($topiksoal_id=="TS008" or $topiksoal_id=="TS016")
								{
									$topikjudul="ROTIBD PERCEPTUAL SPEED";	
								}
							else
								{
									$topikjudul="";	
								}
					
					
					
					
					//mengambil info dari recruitment_jawab_tesintum
					$tesintum_subbagian			=$r['tesintum_subbagian'];
					$tesintum_tingkatan			=$r['tesintum_tingkatan'];
					$tabel_jawab= "recruitment_jawab_tesintum a, recruitment_soal_tesintum b";
					$dimana_default_jawab="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_tesintum_status='A' AND a.tesintum_bagian='$topikjudul' and a.tesintum_subbagian='$tesintum_subbagian' and a.tesintum_tingkatan='$tesintum_tingkatan' AND b.tesintum_no=a.tesintum_no AND b.tesintum_bagian='$topikjudul' and b.tesintum_subbagian='$tesintum_subbagian' and b.tesintum_tingkatan='$tesintum_tingkatan'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab;
					$db->kolom="a.*,b.tesintum_kunci";
					$db->dimana=$dimana_default_jawab;
					$db->urut="ORDER BY tesintum_no ASC";
					$refs_jawab=$db->data();
						
					
					
					//$r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime(decimal_waktu($r['USER_INDEX']))));
				$r['LOWONGANKERJA_NAMA']		=$LOWONGANKERJA_NAMA;
				$r['TINGKATPENDIDIKAN_NAMA']	=$TINGKATPENDIDIKAN_NAMA;
				$r['TOPIK_JUDUL']				=$topikjudul;
				$r['Topik_soal']=$refs_topiksoal;
				$r['Participants']=$refs_participants;
				$r['Jawab']=$refs_jawab;
				$r['NO']=$no;
				$refsee[]=$r;	
				$no++;
				}//--end foreach
				
				
				if(empty($refs)){
					$pesan="gagal";
					$text_msg="Data Tidak ada";
				}else{
					$pesan="sukses";
					$text_msg="Load..";
				}
				
		break;
		//----------------------------------------------------------------------//
		
		case 'nilai_tes_disc_443':
			
				$tabel="recruitment_participantstest";
				$dimana_default="where participantstest_id='".$data_array['participantstest_id']."' AND participantstest_status='A'";

				$db=new db();
				$db->database=$cf['db_nama'];
				$db->tabel=$tabel;
				$db->kolom="*";
				$db->dimana=$dimana_default;
				$refs=$db->data();
				$no=$posisi+1;
				foreach($refs as $r)
				{	
					//mengambil info dari recruitment_topiksoal	
					$tabel_topiksoal= "recruitment_topiksoal";
					$dimana_default_topiksoal="where TOPIKSOAL_ID='$r[TOPIKSOAL_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_topiksoal;
					$db->kolom="TOPIKSOAL_ID,TOPIKSOAL_JUDUL,TOPIKSOAL_WAKTUP,TOPIKSOAL_BAGIAN,TOPIKSOAL_INFO";
					$db->dimana=$dimana_default_topiksoal;
					$refs_topiksoal=$db->data();
					$topikjudul="DISC";	
					
					
					//mengambil info dari recruitment_participants
					$tabel_participants= "recruitment_participants";
					$dimana_default_participants="where PESERTA_ID='$r[PESERTA_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_participants;
					$db->kolom="*";
					$db->dimana=$dimana_default_participants;
					$refs_participants=$db->data();
					
					//lowongankerja
					$tabel_ambil_lowongankerja="recruitment_participants_lowongankerja a, recruitment_lowongankerja b";
					$dimana_default_ambil_lowongankerja="where a.LOWONGANKERJA_ID=b.LOWONGANKERJA_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_ambil_lowongankerja;
					$db->kolom="b.LOWONGANKERJA_NAMA";
					$db->dimana=$dimana_default_ambil_lowongankerja;
					//$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					
					$refs_ambil_lowongankerja=$db->data();
					if(empty($refs_ambil_lowongankerja))
					{
						$LOWONGANKERJA_NAMA="-";
					}else
					{
						$LOWONGANKERJA_NAMA=$refs_ambil_lowongankerja[0]['LOWONGANKERJA_NAMA'];
					}
					//END lowongankerja 
					
					//pendidikan
					$tabel_pendidikanformal="recruitment_pendidikanformal a, recruitment_tingkatpendidikan b";
					$dimana_default_pendidikanformal="where a.TINGKATPENDIDIKAN_ID=b.TINGKATPENDIDIKAN_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_pendidikanformal;
					$db->kolom="MAX(a.TINGKATPENDIDIKAN_ID) AS TINGKATPENDIDIKAN_ID, b.TINGKATPENDIDIKAN_NAMA, a.PENDIDIKAN_FORMAL_JURUSAN";
					$db->dimana=$dimana_default_pendidikanformal;
					$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					$refs_pendidikanformal=$db->data();
					
					if(empty($refs_pendidikanformal))
					{
						$TINGKATPENDIDIKAN_NAMA="-";
					}else
					{
						$TINGKATPENDIDIKAN_NAMA=$refs_pendidikanformal[0]['TINGKATPENDIDIKAN_NAMA']."-".$refs_pendidikanformal[0]['PENDIDIKAN_FORMAL_JURUSAN'];
					}
					//END pendidikan 
					
					//mengambil info dari recruitment_jawab_disc
					$tabel_jawab= "recruitment_jawab_disc a";
					$dimana_default_jawab="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_disc_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab;
					$db->urut="ORDER BY disc_no ASC limit 12";
					$refs_jawab=$db->data();
					
					$tabel_jawab_2= "recruitment_jawab_disc b";
					$dimana_default_jawab_2="where b.PESERTA_ID='$r[PESERTA_ID]' AND b.jawab_disc_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_2;
					$db->kolom="b.*";
					$db->dimana=$dimana_default_jawab_2;
					$db->urut="ORDER BY disc_no ASC limit 12 offset 12";
					$refs_jawab_2=$db->data();
						
					
					
					//$r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime(decimal_waktu($r['USER_INDEX']))));
				$r['LOWONGANKERJA_NAMA']		=$LOWONGANKERJA_NAMA;
				$r['TINGKATPENDIDIKAN_NAMA']	=$TINGKATPENDIDIKAN_NAMA;
				$r['TOPIK_JUDUL']				=$topikjudul;
				$r['Topik_soal']				=$refs_topiksoal;
				$r['Participants']				=$refs_participants;
				$r['Jawab']						=$refs_jawab;
				$r['Jawab_2']					=$refs_jawab_2;
				$r['NO']=$no;
				$refsee[]=$r;	
				$no++;
				}//--end foreach
				
				
				if(empty($refs)){
					$pesan="gagal";
					$text_msg="Data Tidak ada";
				}else{
					$pesan="sukses";
					$text_msg="Load..";
				}
				
		break;
		//----------------------------------------------------------------------//
		
		case 'nilai_tes_papi_443':
			
				$tabel="recruitment_participantstest";
				$dimana_default="where participantstest_id='".$data_array['participantstest_id']."' AND participantstest_status='A'";

				$db=new db();
				$db->database=$cf['db_nama'];
				$db->tabel=$tabel;
				$db->kolom="*";
				$db->dimana=$dimana_default;
				$refs=$db->data();
				$no=$posisi+1;
				foreach($refs as $r)
				{	
					//mengambil info dari recruitment_topiksoal	
					$tabel_topiksoal= "recruitment_topiksoal";
					$dimana_default_topiksoal="where TOPIKSOAL_ID='$r[TOPIKSOAL_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_topiksoal;
					$db->kolom="TOPIKSOAL_ID,TOPIKSOAL_JUDUL,TOPIKSOAL_WAKTUP,TOPIKSOAL_BAGIAN,TOPIKSOAL_INFO";
					$db->dimana=$dimana_default_topiksoal;
					$refs_topiksoal=$db->data();
					$topikjudul="DISC";	
					
					
					//mengambil info dari recruitment_participants
					$tabel_participants= "recruitment_participants";
					$dimana_default_participants="where PESERTA_ID='$r[PESERTA_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_participants;
					$db->kolom="*";
					$db->dimana=$dimana_default_participants;
					$refs_participants=$db->data();
					
					//lowongankerja
					$tabel_ambil_lowongankerja="recruitment_participants_lowongankerja a, recruitment_lowongankerja b";
					$dimana_default_ambil_lowongankerja="where a.LOWONGANKERJA_ID=b.LOWONGANKERJA_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_ambil_lowongankerja;
					$db->kolom="b.LOWONGANKERJA_NAMA";
					$db->dimana=$dimana_default_ambil_lowongankerja;
					//$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					
					$refs_ambil_lowongankerja=$db->data();
					if(empty($refs_ambil_lowongankerja))
					{
						$LOWONGANKERJA_NAMA="-";
					}else
					{
						$LOWONGANKERJA_NAMA=$refs_ambil_lowongankerja[0]['LOWONGANKERJA_NAMA'];
					}
					//END lowongankerja 
					
					//pendidikan
					$tabel_pendidikanformal="recruitment_pendidikanformal a, recruitment_tingkatpendidikan b";
					$dimana_default_pendidikanformal="where a.TINGKATPENDIDIKAN_ID=b.TINGKATPENDIDIKAN_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_pendidikanformal;
					$db->kolom="MAX(a.TINGKATPENDIDIKAN_ID) AS TINGKATPENDIDIKAN_ID, b.TINGKATPENDIDIKAN_NAMA, a.PENDIDIKAN_FORMAL_JURUSAN";
					$db->dimana=$dimana_default_pendidikanformal;
					$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					$refs_pendidikanformal=$db->data();
					
					if(empty($refs_pendidikanformal))
					{
						$TINGKATPENDIDIKAN_NAMA="-";
					}else
					{
						$TINGKATPENDIDIKAN_NAMA=$refs_pendidikanformal[0]['TINGKATPENDIDIKAN_NAMA']."-".$refs_pendidikanformal[0]['PENDIDIKAN_FORMAL_JURUSAN'];
					}
					//END pendidikan 
					
					//mengambil info dari recruitment_jawab_papi
					$tabel_jawab= "recruitment_jawab_papi a";
					$dimana_default_jawab="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_papi_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab;
					$db->urut="ORDER BY papi_no ASC limit 30";
					$refs_jawab=$db->data();
					
					$tabel_jawab_2= "recruitment_jawab_papi a";
					$dimana_default_jawab_2="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_papi_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_2;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_2;
					$db->urut="ORDER BY papi_no ASC limit 30 offset 30";
					$refs_jawab_2=$db->data();
					
					$tabel_jawab_3= "recruitment_jawab_papi a";
					$dimana_default_jawab_3="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_papi_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_3;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_3;
					$db->urut="ORDER BY papi_no ASC limit 30 offset 60";
					$refs_jawab_3=$db->data();
						
					$tabel_TOTAL_jawab				="recruitment_jawab_papi a";
					$dimana_default_TOTAL_jawab		="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_papi_status='A'";
					$db								=new db();
					$db->database					=$cf['db_nama'];
					$db->tabel						=$tabel_TOTAL_jawab;
					$db->kolom						="a.*";
					$db->dimana						=$dimana_default_TOTAL_jawab;
					$db->urut						="ORDER BY papi_no ASC";
					$refs_TOTAL_jawab				=$db->data();
						
					
					
					
					//$r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime(decimal_waktu($r['USER_INDEX']))));
				$r['LOWONGANKERJA_NAMA']		=$LOWONGANKERJA_NAMA;
				$r['TINGKATPENDIDIKAN_NAMA']	=$TINGKATPENDIDIKAN_NAMA;
				$r['TOPIK_JUDUL']				=$topikjudul;
				$r['Topik_soal']				=$refs_topiksoal;
				$r['Participants']				=$refs_participants;
				$r['Jawab']						=$refs_jawab;
				$r['Jawab_2']					=$refs_jawab_2;
				$r['Jawab_3']					=$refs_jawab_3;
				$r['TOTAL_Jawab']				=$refs_TOTAL_jawab;
				$r['NO']=$no;
				$refsee[]=$r;	
				$no++;
				}//--end foreach
				
				
				if(empty($refs)){
					$pesan="gagal";
					$text_msg="Data Tidak ada";
				}else{
					$pesan="sukses";
					$text_msg="Load..";
				}
				
		break;
		//----------------------------------------------------------------------//
		
		
		case 'nilai_tes_belbin_443':
			
				$tabel="recruitment_participantstest";
				$dimana_default="where participantstest_id='".$data_array['participantstest_id']."' AND participantstest_status='A'";

				$db=new db();
				$db->database=$cf['db_nama'];
				$db->tabel=$tabel;
				$db->kolom="*";
				$db->dimana=$dimana_default;
				$refs=$db->data();
				$no=$posisi+1;
				foreach($refs as $r)
				{	
					//mengambil info dari recruitment_topiksoal	
					$tabel_topiksoal= "recruitment_topiksoal";
					$dimana_default_topiksoal="where TOPIKSOAL_ID='$r[TOPIKSOAL_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_topiksoal;
					$db->kolom="TOPIKSOAL_ID,TOPIKSOAL_JUDUL,TOPIKSOAL_WAKTUP,TOPIKSOAL_BAGIAN,TOPIKSOAL_INFO";
					$db->dimana=$dimana_default_topiksoal;
					$refs_topiksoal=$db->data();
					$topikjudul="BELBIN INVENTORY";	
					
					
					//mengambil info dari recruitment_participants
					$tabel_participants= "recruitment_participants";
					$dimana_default_participants="where PESERTA_ID='$r[PESERTA_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_participants;
					$db->kolom="*";
					$db->dimana=$dimana_default_participants;
					$refs_participants=$db->data();
					
					//lowongankerja
					$tabel_ambil_lowongankerja="recruitment_participants_lowongankerja a, recruitment_lowongankerja b";
					$dimana_default_ambil_lowongankerja="where a.LOWONGANKERJA_ID=b.LOWONGANKERJA_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_ambil_lowongankerja;
					$db->kolom="b.LOWONGANKERJA_NAMA";
					$db->dimana=$dimana_default_ambil_lowongankerja;
					//$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					
					$refs_ambil_lowongankerja=$db->data();
					if(empty($refs_ambil_lowongankerja))
					{
						$LOWONGANKERJA_NAMA="-";
					}else
					{
						$LOWONGANKERJA_NAMA=$refs_ambil_lowongankerja[0]['LOWONGANKERJA_NAMA'];
					}
					//END lowongankerja 
					
					//pendidikan
					$tabel_pendidikanformal="recruitment_pendidikanformal a, recruitment_tingkatpendidikan b";
					$dimana_default_pendidikanformal="where a.TINGKATPENDIDIKAN_ID=b.TINGKATPENDIDIKAN_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_pendidikanformal;
					$db->kolom="MAX(a.TINGKATPENDIDIKAN_ID) AS TINGKATPENDIDIKAN_ID, b.TINGKATPENDIDIKAN_NAMA, a.PENDIDIKAN_FORMAL_JURUSAN";
					$db->dimana=$dimana_default_pendidikanformal;
					$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					$refs_pendidikanformal=$db->data();
					
					if(empty($refs_pendidikanformal))
					{
						$TINGKATPENDIDIKAN_NAMA="-";
					}else
					{
						$TINGKATPENDIDIKAN_NAMA=$refs_pendidikanformal[0]['TINGKATPENDIDIKAN_NAMA']."-".$refs_pendidikanformal[0]['PENDIDIKAN_FORMAL_JURUSAN'];
					}
					//END pendidikan 
					
					//mengambil info dari recruitment_jawab_belbin
					$tabel_jawab= "recruitment_jawab_belbin a";
					$dimana_default_jawab="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A' and belbin_section='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_jawab=$db->data();
					
					$tabel_jawab_2= "recruitment_jawab_belbin a";
					$dimana_default_jawab_2="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A' and belbin_section='B'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_2;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_2;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_jawab_2=$db->data();
					
					$tabel_jawab_3= "recruitment_jawab_belbin a";
					$dimana_default_jawab_3="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A' and belbin_section='C'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_3;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_3;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_jawab_3=$db->data();
					
					$tabel_jawab_4= "recruitment_jawab_belbin a";
					$dimana_default_jawab_4="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A' and belbin_section='D'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_4;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_4;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_jawab_4=$db->data();	
					
					$tabel_jawab_5= "recruitment_jawab_belbin a";
					$dimana_default_jawab_5="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A' and belbin_section='E'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_5;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_5;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_jawab_5=$db->data();
					
					$tabel_jawab_6= "recruitment_jawab_belbin a";
					$dimana_default_jawab_6="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A' and belbin_section='F'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_6;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_6;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_jawab_6=$db->data();
					
					$tabel_jawab_7= "recruitment_jawab_belbin a";
					$dimana_default_jawab_7="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A' and belbin_section='G'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_7;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_jawab_7;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_jawab_7=$db->data();
					
					$tabel_TOTAL_Jawab= "recruitment_jawab_belbin a";
					$dimana_default_TOTAL_Jawab="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_TOTAL_Jawab;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_TOTAL_Jawab;
					$db->urut="ORDER BY belbin_no ASC";
					$refs_TOTAL_Jawab=$db->data();
					
					
					$tabel_KUNCI= "recruitment_jawab_belbin a";
					$dimana_default_KUNCI="where a.PESERTA_ID='$r[PESERTA_ID]' AND a.jawab_belbin_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_KUNCI;
					$db->kolom="a.*";
					$db->dimana=$dimana_default_KUNCI;
					$db->urut="ORDER BY belbin_section ASC,belbin_no ASC";
					$refs_KUNCI=$db->data();
					
					
					//$r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime(decimal_waktu($r['USER_INDEX']))));
				$r['LOWONGANKERJA_NAMA']		=$LOWONGANKERJA_NAMA;
				$r['TINGKATPENDIDIKAN_NAMA']	=$TINGKATPENDIDIKAN_NAMA;
				$r['TOPIK_JUDUL']				=$topikjudul;
				$r['Topik_soal']				=$refs_topiksoal;
				$r['Participants']				=$refs_participants;
				$r['Jawab_1']					=$refs_jawab;
				$r['Jawab_2']					=$refs_jawab_2;
				$r['Jawab_3']					=$refs_jawab_3;
				$r['Jawab_4']					=$refs_jawab_4;
				$r['Jawab_5']					=$refs_jawab_5;
				$r['Jawab_6']					=$refs_jawab_6;
				$r['Jawab_7']					=$refs_jawab_7;
				$r['TOTAL_Jawab']				=$refs_TOTAL_Jawab;
				$r['KUNCI']						=$refs_KUNCI;
				$r['NO']=$no;
				$refsee[]=$r;	
				$no++;
				}//--end foreach
				
				
				if(empty($refs)){
					$pesan="gagal";
					$text_msg="Data Tidak ada";
				}else{
					$pesan="sukses";
					$text_msg="Load..";
				}
				
		break;
		//----------------------------------------------------------------------//
		
		
		
		case 'nilai_tes_mbti_443':
			
				$tabel="recruitment_participantstest";
				$dimana_default="where participantstest_id='".$data_array['participantstest_id']."' AND participantstest_status='A'";

				$db=new db();
				$db->database=$cf['db_nama'];
				$db->tabel=$tabel;
				$db->kolom="*";
				$db->dimana=$dimana_default;
				$refs=$db->data();
				$no=$posisi+1;
				foreach($refs as $r)
				{	
					//mengambil info dari recruitment_topiksoal	
					$tabel_topiksoal= "recruitment_topiksoal";
					$dimana_default_topiksoal="where TOPIKSOAL_ID='$r[TOPIKSOAL_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_topiksoal;
					$db->kolom="TOPIKSOAL_ID,TOPIKSOAL_JUDUL,TOPIKSOAL_WAKTUP,TOPIKSOAL_BAGIAN,TOPIKSOAL_INFO";
					$db->dimana=$dimana_default_topiksoal;
					$refs_topiksoal=$db->data();
					$topikjudul="MBTI";	
					
					
					//mengambil info dari recruitment_participants
					$tabel_participants= "recruitment_participants";
					$dimana_default_participants="where PESERTA_ID='$r[PESERTA_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_participants;
					$db->kolom="*";
					$db->dimana=$dimana_default_participants;
					$refs_participants=$db->data();
					
					//lowongankerja
					$tabel_ambil_lowongankerja="recruitment_participants_lowongankerja a, recruitment_lowongankerja b";
					$dimana_default_ambil_lowongankerja="where a.LOWONGANKERJA_ID=b.LOWONGANKERJA_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_ambil_lowongankerja;
					$db->kolom="b.LOWONGANKERJA_NAMA";
					$db->dimana=$dimana_default_ambil_lowongankerja;
					//$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					
					$refs_ambil_lowongankerja=$db->data();
					if(empty($refs_ambil_lowongankerja))
					{
						$LOWONGANKERJA_NAMA="-";
					}else
					{
						$LOWONGANKERJA_NAMA=$refs_ambil_lowongankerja[0]['LOWONGANKERJA_NAMA'];
					}
					//END lowongankerja 
					
					//pendidikan
					$tabel_pendidikanformal="recruitment_pendidikanformal a, recruitment_tingkatpendidikan b";
					$dimana_default_pendidikanformal="where a.TINGKATPENDIDIKAN_ID=b.TINGKATPENDIDIKAN_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_pendidikanformal;
					$db->kolom="MAX(a.TINGKATPENDIDIKAN_ID) AS TINGKATPENDIDIKAN_ID, b.TINGKATPENDIDIKAN_NAMA, a.PENDIDIKAN_FORMAL_JURUSAN";
					$db->dimana=$dimana_default_pendidikanformal;
					$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					$refs_pendidikanformal=$db->data();
					
					if(empty($refs_pendidikanformal))
					{
						$TINGKATPENDIDIKAN_NAMA="-";
					}else
					{
						$TINGKATPENDIDIKAN_NAMA=$refs_pendidikanformal[0]['TINGKATPENDIDIKAN_NAMA']."-".$refs_pendidikanformal[0]['PENDIDIKAN_FORMAL_JURUSAN'];
					}
					//END pendidikan 
					
					//mengambil info dari recruitment_jawab_mbti
					$tabel_jawab= "recruitment_jawab_mbti";
					$dimana_default_jawab="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='001' or mbti_no='005' or mbti_no='009' or mbti_no='013' or mbti_no='017' or mbti_no='021'
					 or mbti_no='025' or mbti_no='029' or mbti_no='033' or mbti_no='037' or mbti_no='041' or mbti_no='045'
					 or mbti_no='049' or mbti_no='053' or mbti_no='057')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab=$db->data();
					
					$tabel_jawab_2= "recruitment_jawab_mbti";
					$dimana_default_jawab_2="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='002' or mbti_no='006' or mbti_no='010' or mbti_no='014' or mbti_no='018' or mbti_no='022'
					 or mbti_no='026' or mbti_no='030' or mbti_no='034' or mbti_no='038' or mbti_no='042' or mbti_no='046'
					 or mbti_no='050' or mbti_no='054' or mbti_no='058')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_2;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_2;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_2=$db->data();
					
					$tabel_jawab_3= "recruitment_jawab_mbti";
					$dimana_default_jawab_3="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='003' or mbti_no='007' or mbti_no='011' or mbti_no='015' or mbti_no='019' or mbti_no='023'
					 or mbti_no='027' or mbti_no='031' or mbti_no='035' or mbti_no='039' or mbti_no='043' or mbti_no='047'
					 or mbti_no='051' or mbti_no='055' or mbti_no='059')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_3;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_3;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_3=$db->data();
					
					$tabel_jawab_4= "recruitment_jawab_mbti";
					$dimana_default_jawab_4="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='004' or mbti_no='008' or mbti_no='012' or mbti_no='016' or mbti_no='020' or mbti_no='024'
					 or mbti_no='028' or mbti_no='032' or mbti_no='036' or mbti_no='040' or mbti_no='044' or mbti_no='048'
					 or mbti_no='052' or mbti_no='056' or mbti_no='060')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_4;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_4;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_4=$db->data();	
					
					$tabel_jawab_5= "recruitment_jawab_mbti";
					$dimana_default_jawab_5="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='061' or mbti_no='065' or mbti_no='069' or mbti_no='073' or mbti_no='077' or mbti_no='081'
					 or mbti_no='085' or mbti_no='089' or mbti_no='093')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_5;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_5;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_5=$db->data();
					
					$tabel_jawab_6= "recruitment_jawab_mbti";
					$dimana_default_jawab_6="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='062' or mbti_no='066' or mbti_no='070' or mbti_no='074' or mbti_no='078' or mbti_no='082'
					 or mbti_no='086' or mbti_no='090' or mbti_no='094')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_6;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_6;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_6=$db->data();
					
					$tabel_jawab_7= "recruitment_jawab_mbti";
					$dimana_default_jawab_7="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='063' or mbti_no='067' or mbti_no='071' or mbti_no='075' or mbti_no='079' or mbti_no='083'
					 or mbti_no='087' or mbti_no='091' or mbti_no='095')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_7;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_7;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_7=$db->data();
					
					$tabel_jawab_8= "recruitment_jawab_mbti";
					$dimana_default_jawab_8="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and (mbti_no='064' or mbti_no='068' or mbti_no='072' or mbti_no='076' or mbti_no='080' or mbti_no='084'
					 or mbti_no='088' or mbti_no='092' or mbti_no='096')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_8;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_8;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_8=$db->data();
					
					$tabel_jawab_9= "recruitment_jawab_mbti";
					$dimana_default_jawab_9="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and mbti_no='097'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_9;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_9;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_9=$db->data();
					
					$tabel_jawab_10= "recruitment_jawab_mbti";
					$dimana_default_jawab_10="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and mbti_no='098'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_10;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_10;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_10=$db->data();
					
					$tabel_jawab_11= "recruitment_jawab_mbti";
					$dimana_default_jawab_11="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and mbti_no='099'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_11;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_11;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_11=$db->data();
					
					$tabel_jawab_12= "recruitment_jawab_mbti";
					$dimana_default_jawab_12="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_mbti_status='A' and mbti_no='100'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_12;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_12;
					$db->urut="ORDER BY mbti_no ASC";
					$refs_jawab_12=$db->data();
					
					
					//$r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime(decimal_waktu($r['USER_INDEX']))));
				$r['LOWONGANKERJA_NAMA']		=$LOWONGANKERJA_NAMA;
				$r['TINGKATPENDIDIKAN_NAMA']	=$TINGKATPENDIDIKAN_NAMA;
				$r['TOPIK_JUDUL']				=$topikjudul;
				$r['Topik_soal']				=$refs_topiksoal;
				$r['Participants']				=$refs_participants;
				$r['Jawab_1']					=$refs_jawab;
				$r['Jawab_2']					=$refs_jawab_2;
				$r['Jawab_3']					=$refs_jawab_3;
				$r['Jawab_4']					=$refs_jawab_4;
				$r['Jawab_5']					=$refs_jawab_5;
				$r['Jawab_6']					=$refs_jawab_6;
				$r['Jawab_7']					=$refs_jawab_7;
				$r['Jawab_8']					=$refs_jawab_8;
				$r['Jawab_9']					=$refs_jawab_9;
				$r['Jawab_10']					=$refs_jawab_10;
				$r['Jawab_11']					=$refs_jawab_11;
				$r['Jawab_12']					=$refs_jawab_12;
				
				$r['NO']=$no;
				$refsee[]=$r;	
				$no++;
				}//--end foreach
				
				
				if(empty($refs)){
					$pesan="gagal";
					$text_msg="Data Tidak ada";
				}else{
					$pesan="sukses";
					$text_msg="Load..";
				}
				
		break;
		//----------------------------------------------------------------------//
		
		case 'nilai_tes_firob_443':
			
				$tabel="recruitment_participantstest";
				$dimana_default="where participantstest_id='".$data_array['participantstest_id']."' AND participantstest_status='A'";

				$db=new db();
				$db->database=$cf['db_nama'];
				$db->tabel=$tabel;
				$db->kolom="*";
				$db->dimana=$dimana_default;
				$refs=$db->data();
				$no=$posisi+1;
				foreach($refs as $r)
				{	
					//mengambil info dari recruitment_topiksoal	
					$tabel_topiksoal= "recruitment_topiksoal";
					$dimana_default_topiksoal="where TOPIKSOAL_ID='$r[TOPIKSOAL_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_topiksoal;
					$db->kolom="TOPIKSOAL_ID,TOPIKSOAL_JUDUL,TOPIKSOAL_WAKTUP,TOPIKSOAL_BAGIAN,TOPIKSOAL_INFO";
					$db->dimana=$dimana_default_topiksoal;
					$refs_topiksoal=$db->data();
					$topikjudul="FIRO-B";	
					
					
					//mengambil info dari recruitment_participants
					$tabel_participants= "recruitment_participants";
					$dimana_default_participants="where PESERTA_ID='$r[PESERTA_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_participants;
					$db->kolom="*";
					$db->dimana=$dimana_default_participants;
					$refs_participants=$db->data();
					
					//lowongankerja
					$tabel_ambil_lowongankerja="recruitment_participants_lowongankerja a, recruitment_lowongankerja b";
					$dimana_default_ambil_lowongankerja="where a.LOWONGANKERJA_ID=b.LOWONGANKERJA_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_ambil_lowongankerja;
					$db->kolom="b.LOWONGANKERJA_NAMA";
					$db->dimana=$dimana_default_ambil_lowongankerja;
					//$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					
					$refs_ambil_lowongankerja=$db->data();
					if(empty($refs_ambil_lowongankerja))
					{
						$LOWONGANKERJA_NAMA="-";
					}else
					{
						$LOWONGANKERJA_NAMA=$refs_ambil_lowongankerja[0]['LOWONGANKERJA_NAMA'];
					}
					//END lowongankerja 
					
					//pendidikan
					$tabel_pendidikanformal="recruitment_pendidikanformal a, recruitment_tingkatpendidikan b";
					$dimana_default_pendidikanformal="where a.TINGKATPENDIDIKAN_ID=b.TINGKATPENDIDIKAN_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_pendidikanformal;
					$db->kolom="MAX(a.TINGKATPENDIDIKAN_ID) AS TINGKATPENDIDIKAN_ID, b.TINGKATPENDIDIKAN_NAMA, a.PENDIDIKAN_FORMAL_JURUSAN";
					$db->dimana=$dimana_default_pendidikanformal;
					$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					$refs_pendidikanformal=$db->data();
					
					if(empty($refs_pendidikanformal))
					{
						$TINGKATPENDIDIKAN_NAMA="-";
					}else
					{
						$TINGKATPENDIDIKAN_NAMA=$refs_pendidikanformal[0]['TINGKATPENDIDIKAN_NAMA']."-".$refs_pendidikanformal[0]['PENDIDIKAN_FORMAL_JURUSAN'];
					}
					//END pendidikan 
					
					//mengambil info dari recruitment_jawab_firob
					$tabel_jawab= "recruitment_jawab_firob";
					$dimana_default_jawab="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_firob_status='A' and (firob_no='1' or firob_no='3' or firob_no='5' or firob_no='7' or firob_no='9' or firob_no='11'
					 or firob_no='13' or firob_no='15' or firob_no='16')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab;
					$db->urut="ORDER BY firob_no ASC";
					$refs_jawab=$db->data();
					
					$tabel_jawab_2= "recruitment_jawab_firob";
					$dimana_default_jawab_2="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_firob_status='A' and (firob_no='28' or firob_no='31' or firob_no='34' or firob_no='37' or firob_no='39' or firob_no='42'
					 or firob_no='45' or firob_no='48' or firob_no='51')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_2;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_2;
					$db->urut="ORDER BY firob_no ASC";
					$refs_jawab_2=$db->data();
					
					$tabel_jawab_3= "recruitment_jawab_firob";
					$dimana_default_jawab_3="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_firob_status='A' and (firob_no='30' or firob_no='33' or firob_no='36' or firob_no='41' or firob_no='44' or firob_no='47'
					 or firob_no='50' or firob_no='53' or firob_no='54')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_3;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_3;
					$db->urut="ORDER BY firob_no ASC";
					$refs_jawab_3=$db->data();
					
					$tabel_jawab_4= "recruitment_jawab_firob";
					$dimana_default_jawab_4="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_firob_status='A' and (firob_no='2' or firob_no='6' or firob_no='10' or firob_no='14' or firob_no='18' or firob_no='20'
					 or firob_no='22' or firob_no='24' or firob_no='26')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_4;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_4;
					$db->urut="ORDER BY firob_no ASC";
					$refs_jawab_4=$db->data();
					
					
					$tabel_jawab_5= "recruitment_jawab_firob";
					$dimana_default_jawab_5="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_firob_status='A' and (firob_no='4' or firob_no='8' or firob_no='12' or firob_no='17' or firob_no='19' or firob_no='21'
					 or firob_no='23' or firob_no='25' or firob_no='27')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_5;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_5;
					$db->urut="ORDER BY firob_no ASC";
					$refs_jawab_5=$db->data();
					
					
					$tabel_jawab_6= "recruitment_jawab_firob";
					$dimana_default_jawab_6="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_firob_status='A' and (firob_no='29' or firob_no='32' or firob_no='35' or firob_no='38' or firob_no='40' or firob_no='43'
					 or firob_no='46' or firob_no='49' or firob_no='52')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_6;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_6;
					$db->urut="ORDER BY firob_no ASC";
					$refs_jawab_6=$db->data();
					
					
					//$r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime(decimal_waktu($r['USER_INDEX']))));
				$r['LOWONGANKERJA_NAMA']		=$LOWONGANKERJA_NAMA;
				$r['TINGKATPENDIDIKAN_NAMA']	=$TINGKATPENDIDIKAN_NAMA;
				$r['TOPIK_JUDUL']				=$topikjudul;
				$r['Topik_soal']				=$refs_topiksoal;
				$r['Participants']				=$refs_participants;
				$r['Jawab_1']					=$refs_jawab;
				$r['Jawab_2']					=$refs_jawab_2;
				$r['Jawab_3']					=$refs_jawab_3;
				$r['Jawab_4']					=$refs_jawab_4;
				$r['Jawab_5']					=$refs_jawab_5;
				$r['Jawab_6']					=$refs_jawab_6;
				
				$r['NO']=$no;
				$refsee[]=$r;	
				$no++;
				}//--end foreach
				
				
				if(empty($refs)){
					$pesan="gagal";
					$text_msg="Data Tidak ada";
				}else{
					$pesan="sukses";
					$text_msg="Load..";
				}
				
		break;
		//----------------------------------------------------------------------//
		
		
		case 'nilai_tes_sds_443':
			
				$tabel="recruitment_participantstest";
				$dimana_default="where participantstest_id='".$data_array['participantstest_id']."' AND participantstest_status='A'";

				$db=new db();
				$db->database=$cf['db_nama'];
				$db->tabel=$tabel;
				$db->kolom="*";
				$db->dimana=$dimana_default;
				$refs=$db->data();
				$no=$posisi+1;
				foreach($refs as $r)
				{	
					//mengambil info dari recruitment_topiksoal	
					$tabel_topiksoal= "recruitment_topiksoal";
					$dimana_default_topiksoal="where TOPIKSOAL_ID='$r[TOPIKSOAL_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_topiksoal;
					$db->kolom="TOPIKSOAL_ID,TOPIKSOAL_JUDUL,TOPIKSOAL_WAKTUP,TOPIKSOAL_BAGIAN,TOPIKSOAL_INFO";
					$db->dimana=$dimana_default_topiksoal;
					$refs_topiksoal=$db->data();
					$topikjudul="SDS Asessment Booklet";	
					
					
					//mengambil info dari recruitment_participants
					$tabel_participants= "recruitment_participants";
					$dimana_default_participants="where PESERTA_ID='$r[PESERTA_ID]' AND (RECORD_STATUS='A' OR RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_participants;
					$db->kolom="*";
					$db->dimana=$dimana_default_participants;
					$refs_participants=$db->data();
					
					//lowongankerja
					$tabel_ambil_lowongankerja="recruitment_participants_lowongankerja a, recruitment_lowongankerja b";
					$dimana_default_ambil_lowongankerja="where a.LOWONGANKERJA_ID=b.LOWONGANKERJA_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_ambil_lowongankerja;
					$db->kolom="b.LOWONGANKERJA_NAMA";
					$db->dimana=$dimana_default_ambil_lowongankerja;
					//$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					
					$refs_ambil_lowongankerja=$db->data();
					if(empty($refs_ambil_lowongankerja))
					{
						$LOWONGANKERJA_NAMA="-";
					}else
					{
						$LOWONGANKERJA_NAMA=$refs_ambil_lowongankerja[0]['LOWONGANKERJA_NAMA'];
					}
					//END lowongankerja 
					
					//pendidikan
					$tabel_pendidikanformal="recruitment_pendidikanformal a, recruitment_tingkatpendidikan b";
					$dimana_default_pendidikanformal="where a.TINGKATPENDIDIKAN_ID=b.TINGKATPENDIDIKAN_ID and a.PESERTA_ID='$r[PESERTA_ID]' AND  (a.RECORD_STATUS='A' OR a.RECORD_STATUS='N')";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_pendidikanformal;
					$db->kolom="MAX(a.TINGKATPENDIDIKAN_ID) AS TINGKATPENDIDIKAN_ID, b.TINGKATPENDIDIKAN_NAMA, a.PENDIDIKAN_FORMAL_JURUSAN";
					$db->dimana=$dimana_default_pendidikanformal;
					$db->urut="ORDER BY b.TINGKATPENDIDIKAN_ID DESC";
					$refs_pendidikanformal=$db->data();
					
					if(empty($refs_pendidikanformal))
					{
						$TINGKATPENDIDIKAN_NAMA="-";
					}else
					{
						$TINGKATPENDIDIKAN_NAMA=$refs_pendidikanformal[0]['TINGKATPENDIDIKAN_NAMA']."-".$refs_pendidikanformal[0]['PENDIDIKAN_FORMAL_JURUSAN'];
					}
					//END pendidikan 
					
					//mengambil info dari recruitment_jawab_firob
					$tabel_cita= "recruitment_kerja_sds";
					$dimana_default_cita="where PESERTA_ID='$r[PESERTA_ID]'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_cita;
					$db->kolom="*";
					$db->dimana=$dimana_default_cita;
					//$db->urut="ORDER BY firob_no ASC";
					$refs_cita=$db->data();
					
					
					$tabel_jawab= "recruitment_jawab_sds";
					$dimana_default_jawab="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='AKTIVITAS' and sds_subbagian='R' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab;
					$refs_jawab=$db->data();
					$JUMLAH_JAWAB_1=count($refs_jawab);
					
					$tabel_jawab_2= "recruitment_jawab_sds";
					$dimana_default_jawab_2="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='AKTIVITAS' and sds_subbagian='I' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_2;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_2;
					$refs_jawab_2=$db->data();
					$JUMLAH_JAWAB_2=count($refs_jawab_2);
					
					$tabel_jawab_3= "recruitment_jawab_sds";
					$dimana_default_jawab_3="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='AKTIVITAS' and sds_subbagian='A' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_3;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_3;
					$refs_jawab_3=$db->data();
					$JUMLAH_JAWAB_3=count($refs_jawab_3);
					
					$tabel_jawab_4= "recruitment_jawab_sds";
					$dimana_default_jawab_4="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='AKTIVITAS' and sds_subbagian='S' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_4;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_4;
					$refs_jawab_4=$db->data();
					$JUMLAH_JAWAB_4=count($refs_jawab_4);
					
					$tabel_jawab_5= "recruitment_jawab_sds";
					$dimana_default_jawab_5="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='AKTIVITAS' and sds_subbagian='E' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_5;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_5;
					$refs_jawab_5=$db->data();
					$JUMLAH_JAWAB_5=count($refs_jawab_5);
					
					$tabel_jawab_6= "recruitment_jawab_sds";
					$dimana_default_jawab_6="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='AKTIVITAS' and sds_subbagian='C' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_6;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_6;
					$refs_jawab_6=$db->data();
					$JUMLAH_JAWAB_6=count($refs_jawab_6);
					
					$tabel_jawab_7= "recruitment_jawab_sds";
					$dimana_default_jawab_7="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='KOMPETENSI' and sds_subbagian='R' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_7;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_7;
					$refs_jawab_7=$db->data();
					$JUMLAH_JAWAB_7=count($refs_jawab_7);
					
					$tabel_jawab_8= "recruitment_jawab_sds";
					$dimana_default_jawab_8="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='KOMPETENSI' and sds_subbagian='I' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_8;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_8;
					$refs_jawab_8=$db->data();
					$JUMLAH_JAWAB_8=count($refs_jawab_8);
					
					$tabel_jawab_9= "recruitment_jawab_sds";
					$dimana_default_jawab_9="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='KOMPETENSI' and sds_subbagian='A' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_9;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_9;
					$refs_jawab_9=$db->data();
					$JUMLAH_JAWAB_9=count($refs_jawab_9);
					
					$tabel_jawab_10= "recruitment_jawab_sds";
					$dimana_default_jawab_10="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='KOMPETENSI' and sds_subbagian='S' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_10;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_10;
					$refs_jawab_10=$db->data();
					$JUMLAH_JAWAB_10=count($refs_jawab_10);
					
					$tabel_jawab_11= "recruitment_jawab_sds";
					$dimana_default_jawab_11="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='KOMPETENSI' and sds_subbagian='E' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_11;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_11;
					$refs_jawab_11=$db->data();
					$JUMLAH_JAWAB_11=count($refs_jawab_11);
					
					$tabel_jawab_12= "recruitment_jawab_sds";
					$dimana_default_jawab_12="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='KOMPETENSI' and sds_subbagian='C' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_12;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_12;
					$refs_jawab_12=$db->data();
					$JUMLAH_JAWAB_12=count($refs_jawab_12);
					
					$tabel_jawab_13= "recruitment_jawab_sds";
					$dimana_default_jawab_13="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='PEKERJAAN' and sds_subbagian='R' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_13;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_13;
					$refs_jawab_13=$db->data();
					$JUMLAH_JAWAB_13=count($refs_jawab_13);
					
					$tabel_jawab_14= "recruitment_jawab_sds";
					$dimana_default_jawab_14="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='PEKERJAAN' and sds_subbagian='I' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_14;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_14;
					$refs_jawab_14=$db->data();
					$JUMLAH_JAWAB_14=count($refs_jawab_14);
					
					$tabel_jawab_15= "recruitment_jawab_sds";
					$dimana_default_jawab_15="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='PEKERJAAN' and sds_subbagian='A' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_15;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_15;
					$refs_jawab_15=$db->data();
					$JUMLAH_JAWAB_15=count($refs_jawab_15);
					
					$tabel_jawab_16= "recruitment_jawab_sds";
					$dimana_default_jawab_16="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='PEKERJAAN' and sds_subbagian='S' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_16;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_16;
					$refs_jawab_16=$db->data();
					$JUMLAH_JAWAB_16=count($refs_jawab_16);
					
					$tabel_jawab_17= "recruitment_jawab_sds";
					$dimana_default_jawab_17="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='PEKERJAAN' and sds_subbagian='E' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_17;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_17;
					$refs_jawab_17=$db->data();
					$JUMLAH_JAWAB_17=count($refs_jawab_17);
					
					$tabel_jawab_18= "recruitment_jawab_sds";
					$dimana_default_jawab_18="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_status='A' and sds_bagian='PEKERJAAN' and sds_subbagian='C' and jawab_sds_pil='L'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_18;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_18;
					$refs_jawab_18=$db->data();
					$JUMLAH_JAWAB_18=count($refs_jawab_18);
					
					$tabel_jawab_19= "recruitment_jawab_sds_menilaidiri";
					$dimana_default_jawab_19="where PESERTA_ID='$r[PESERTA_ID]' AND jawab_sds_menilaidiri_status='A'";
					$db=new db();
					$db->database=$cf['db_nama'];
					$db->tabel=$tabel_jawab_19;
					$db->kolom="*";
					$db->dimana=$dimana_default_jawab_19;
					//$db->urut="ORDER BY firob_no ASC";
					$refs_jawab_19=$db->data();
					
					
					//$r['TANGGAL']=tanggal_format(Date("Y-m-d",strtotime(decimal_waktu($r['USER_INDEX']))));
				$r['LOWONGANKERJA_NAMA']		=$LOWONGANKERJA_NAMA;
				$r['TINGKATPENDIDIKAN_NAMA']	=$TINGKATPENDIDIKAN_NAMA;
				$r['TOPIK_JUDUL']				=$topikjudul;
				$r['Topik_soal']				=$refs_topiksoal;
				$r['Participants']				=$refs_participants;
				
				$r['JUMLAH_JAWAB_1']			=$JUMLAH_JAWAB_1;
				$r['JUMLAH_JAWAB_2']			=$JUMLAH_JAWAB_2;
				$r['JUMLAH_JAWAB_3']			=$JUMLAH_JAWAB_3;
				$r['JUMLAH_JAWAB_4']			=$JUMLAH_JAWAB_4;
				$r['JUMLAH_JAWAB_5']			=$JUMLAH_JAWAB_5;
				$r['JUMLAH_JAWAB_6']			=$JUMLAH_JAWAB_6;
				$r['JUMLAH_JAWAB_7']			=$JUMLAH_JAWAB_7;
				$r['JUMLAH_JAWAB_8']			=$JUMLAH_JAWAB_8;
				$r['JUMLAH_JAWAB_9']			=$JUMLAH_JAWAB_9;
				$r['JUMLAH_JAWAB_10']			=$JUMLAH_JAWAB_10;
				$r['JUMLAH_JAWAB_11']			=$JUMLAH_JAWAB_11;
				$r['JUMLAH_JAWAB_12']			=$JUMLAH_JAWAB_12;
				$r['JUMLAH_JAWAB_13']			=$JUMLAH_JAWAB_13;
				$r['JUMLAH_JAWAB_14']			=$JUMLAH_JAWAB_14;
				$r['JUMLAH_JAWAB_15']			=$JUMLAH_JAWAB_15;
				$r['JUMLAH_JAWAB_16']			=$JUMLAH_JAWAB_16;
				$r['JUMLAH_JAWAB_17']			=$JUMLAH_JAWAB_17;
				$r['JUMLAH_JAWAB_18']			=$JUMLAH_JAWAB_18;
				
				$r['Jawab_19']					=$refs_jawab_19;
				$r['Cita']						=$refs_cita;
				
				$r['NO']=$no;
				$refsee[]=$r;	
				$no++;
				}//--end foreach
				
				
				if(empty($refs)){
					$pesan="gagal";
					$text_msg="Data Tidak ada";
				 }else{
					$pesan="sukses";
					$text_msg="Load..";
				}
				
		break;
		//----------------------------------------------------------------------//
