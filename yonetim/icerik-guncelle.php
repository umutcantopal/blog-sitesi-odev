<?php
	if($_POST)
	{
		require_once("../vt-baglanti.php");
		$icerik_id = $_POST["icerik_id"];
		$icerik_baslik = $_POST["icerik_baslik"];
		$aciklama_yazisi = $_POST["aciklama_yazisi"];
		$icerik_yazisi = $_POST["icerik_yazisi"];
		$kategori = $_POST["kategori"];
		$gizlilik = $_POST["gizlilik"];
		
		$degisiklik = 0;
		//resim ayarlanmadı!!
		
		$sorgu = $db->query("SELECT * FROM icerikler WHERE icerik_id = $icerik_id")->fetch(PDO::FETCH_ASSOC);
		
		//dosya yükleme
		if($_FILES["dosya"]["name"])
		{
			if($_FILES["dosya"]["error"] == 0)
			{
				$dosya_adi = $_FILES["dosya"]["name"];
				$dosya_tipi = $_FILES["dosya"]["type"];
				$dosya_boyutu = $_FILES["dosya"]["size"];
				
				$explode_yapilan = explode(".",$dosya_adi);
				$uzanti_no = count($explode_yapilan)-1;
				$dosya_uzantisi = $explode_yapilan[$uzanti_no];
				$tmp_name = $_FILES["dosya"]["tmp_name"];
				
				$eski_resim_yolu = "../img/makale_resimler/".$sorgu["kapak_resmi"];
				
				if(($dosya_tipi == "image/jpeg" && ($dosya_uzantisi == "jpg" || $dosya_uzantisi == "jpeg")) || ($dosya_tipi == "image/png" && $dosya_uzantisi == "png"))
				{
					if($dosya_boyutu > 1024*1024*5)
					{
						echo "Resim güncellenemedi. En fazla 5MB boyutunda olmalı.";
					}
					else
					{
						$yeni_dosya_adi = rand(0,999999999).rand(0,999999999).rand(0,999999999).".".$dosya_uzantisi;
						$dosya_yolu = "../img/makale_resimler/$yeni_dosya_adi";
						$dosyayi_tasi = move_uploaded_file($tmp_name, $dosya_yolu);
						if(!$dosyayi_tasi)
						{
							echo "Dosya Geçici Dizinden Taşınırken Sorun Oldu";
						}
						else
						{
							$dosya_sorgu = $db->prepare("UPDATE icerikler SET kapak_resmi = ? WHERE icerik_id = ?");
							$dosya_sorgu->execute(array(
								$yeni_dosya_adi, $icerik_id
							));
							unlink($eski_resim_yolu);
							$degisiklik = $degisiklik + 1;
						}
					}
				}
				else
				{
					echo "Yüklenilen Resim Sadece JPG veya PNG türünde olmalı. Resim Güncellenmedi.";
				}
			}
		}
		//dosya yükleme
		
		if($icerik_baslik != $sorgu["baslik"])
		{
			$baslik_sorgu = $db->prepare("UPDATE icerikler SET baslik = ? WHERE icerik_id = ?");
			$baslik_sorgu->execute(array(
				$icerik_baslik, $icerik_id
			));
			
			if($baslik_sorgu)
			{
				$degisiklik = $degisiklik + 1;
			}
		}
		if($aciklama_yazisi != $sorgu["aciklama_yazisi"])
		{
			$aciklama_yazisi_sorgu = $db->prepare("UPDATE icerikler SET aciklama_yazisi = ? WHERE icerik_id = ?");
			$aciklama_yazisi_sorgu->execute(array(
				$aciklama_yazisi, $icerik_id
			));
			if($aciklama_yazisi_sorgu)
			{
				$degisiklik = $degisiklik + 1;
			}
		}
		if($icerik_yazisi != $sorgu["icerik_yazi"])
		{
			$icerik_yazisi_sorgu = $db->prepare("UPDATE icerikler SET icerik_yazi = ? WHERE icerik_id = ?");
			$icerik_yazisi_sorgu->execute(array(
				$icerik_yazisi, $icerik_id
			));
			if($icerik_yazisi_sorgu)
			{
				$degisiklik = $degisiklik + 1;
			}
		}
		if($kategori != $sorgu["kategori_ad"])
		{
			$kategori_sorgu = $db->prepare("UPDATE icerikler SET kategori_ad = ? WHERE icerik_id = ?");
			$kategori_sorgu->execute(array(
				$kategori, $icerik_id
			));
			if($kategori_sorgu)
			{
				$degisiklik = $degisiklik + 1;
			}
		}
		if($gizlilik != $sorgu["yayin_durumu"])
		{
			if($sorgu["yayin_durumu"] == 1)
			{
				$yayin_durumu_sorgu = $db->prepare("UPDATE icerikler SET yayin_durumu = ? WHERE icerik_id = ?");
				$yayin_durumu_sorgu->execute(array(
					0,$icerik_id
				));
				
				if($yayin_durumu_sorgu)
				{
					$degisiklik = $degisiklik + 1;
				}
			}
			else
			{
				$yayin_durumu_sorgu = $db->prepare("UPDATE icerikler SET yayin_durumu = ? WHERE icerik_id = ?");
				$yayin_durumu_sorgu->execute(array(
					1,$icerik_id
				));
				
				if($yayin_durumu_sorgu)
				{
					$degisiklik = $degisiklik + 1;
				}
			}
		}
		
		if($degisiklik == 0)
		{
			echo "Yapılan değişiklik sayısı = 0";
			header("Refresh: 3; url=index.php");
		}
		else
		{
			echo "Yapılan değişiklik sayısı = ".$degisiklik;
			header("Refresh: 3; url=index.php");
		}
	}
?>