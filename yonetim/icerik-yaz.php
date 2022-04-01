<?php
	
	if($_POST)
	{
		session_start();
		$icerik_baslik = trim($_POST["icerik_baslik"]);
		$aciklama_yazisi = trim($_POST["aciklama_yazisi"]);
		$icerik_yazisi = trim($_POST["icerik_yazisi"]);
		$kategori = $_POST["kategori"];
		$tarih = date('Y-m-d');
		
		$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
		
		if($icerik_baslik == "" OR $aciklama_yazisi == "" OR $icerik_yazisi == "")
		{
			echo "Bütün alanları doldurun";
			header("Refresh: 3; url=$url");
		}
		else
		{
			$hata = $_FILES["dosya"]["error"];
			if($hata != 0)
			{
				echo "DOSYA YÜKLENİRKEN HATA, ANASAYFAYA DÖNÜYOR";
			}
			else
			{
				$dosya_adi = $_FILES["dosya"]["name"];
				$dosya_tipi = $_FILES["dosya"]["type"];
				$dosya_boyutu = $_FILES["dosya"]["size"];
				
				$explode_yapilan = explode(".",$dosya_adi);
				$uzanti_no = count($explode_yapilan)-1;
				$dosya_uzantisi = $explode_yapilan[$uzanti_no];
				
				$tmp_name = $_FILES["dosya"]["tmp_name"];
				
				if(($dosya_tipi == "image/jpeg" && ($dosya_uzantisi == "jpg" || $dosya_uzantisi == "jpeg")) || ($dosya_tipi == "image/png" && $dosya_uzantisi == "png"))
				{
					if($dosya_boyutu > 1024*1024*5)
					{
						echo "En fazla 5MB olmalı, çok gönderdin";
					}
					else
					{
						$yeni_dosya_adi = rand(0,999999999).rand(0,999999999).rand(0,999999999).".".$dosya_uzantisi;
						$dosya_yolu = "../img/makale_resimler/$yeni_dosya_adi";
						$dosyayi_tasi = move_uploaded_file($tmp_name, $dosya_yolu);
						if(!$dosyayi_tasi)
						{
							echo "Dosya Geçici Dizinden Taşınırken Sorun Oldu";
							header("Refresh: 3; url=$url");
						}
						else
						{
							require_once("../vt-baglanti.php");
							
							$sorgu = $db->prepare("INSERT INTO icerikler SET
							yayin_durumu = ?,
							yazar_id = ?,
							tarih = ?,
							kategori_ad = ?,
							baslik = ?,
							aciklama_yazisi = ?,
							kapak_resmi = ?,
							icerik_yazi = ?");
							
							$sorgu_isle = $sorgu->execute(array(
								1,$_SESSION["uye_id"],$tarih,$kategori,$icerik_baslik,$aciklama_yazisi,$yeni_dosya_adi,$icerik_yazisi
							));
							
							if($sorgu_isle)
							{
								echo "İçerik gönderimi başarılı, açtığınız içeriğe gidiyorum";
								$last_id = $db->lastInsertId();
								header("Refresh: 3; url=../makale/konu.php?id=$last_id");
							}
							else
							{
								echo "Bir şeyler ters gitti";
								header("Refresh: 3; url=$url");
							}
						}
					}
				}
				else
				{
					echo "Yüklenilen Resim Sadece JPG veya PNG türünde olmalı";
					header("Refresh: 3; url=$url");
				}
			}
		}
		
	}
	
?>