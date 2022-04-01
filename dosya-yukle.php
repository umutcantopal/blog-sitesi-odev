<?php
	if($_POST["yolla"])
	{
		// $dosya = $_FILES["dosya"]["tmp_name"];
		$hata = $_FILES["dosya"]["error"];
		if($hata != 0)
		{
			// echo $_FILES["dosya"]["error"];
			echo "DOSYA YÜKLENİRKEN HATA, ANASAYFAYA DÖNÜYOR";
			if($hata == 1)
			{
				echo "En fazla 1MB olmalı";
			}
			header("Refresh: 5; url= anasayfa/index.php");
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
			
			// echo "Dosya Adı: ".$dosya_adi."<br/>Dosya Tipi: ".$dosya_tipi."<br/>Dosya Boyutu: ".$dosya_boyutu."<br/>Dosya Uzantısı: ".$dosya_uzantisi;
			
			if(($dosya_tipi == "image/jpeg" && ($dosya_uzantisi == "jpg" || $dosya_uzantisi == "jpeg")) || ($dosya_tipi == "image/png" && $dosya_uzantisi == "png"))
			{
				if($dosya_boyutu > 1024*1024)
				{
					echo "En fazla 1MB olmalı, çok gönderdin";
				}
				else
				{
					//kontroller başarılı, burada dosya yüklenecek
					session_start();
					$veritabani = new mysqli("localhost","root","","sistemanalizibir");
					if($veritabani->connect_error)
					{
						echo "resmi yüklerken veritabanı bağlantısında bir sorun oldu";
					}
					else
					{
						$veritabani -> set_charset("utf8");
						$adi = $_SESSION["kullanici_ad"];
						
						//unlink fonksiyonu için eski avatarın yolunu alma
						$sql3 = "SELECT avatar FROM uyeler WHERE kullanici_ad='$adi'";
						$sorgucalistir = $veritabani -> query($sql3);
						$satir = $sorgucalistir -> fetch_array(MYSQLI_ASSOC);
						$eski_avatar_yolu = "img/uye_avatar/".$satir["avatar"];
						
						//yeni dosyanın yüklenmesi ve veritabanında avatar alanının uzantısının değiştirlmesi
						$yeni_dosya_adi = rand(0,999999999).$adi.rand(0,999999999).".".$dosya_uzantisi;
						$dosya_yolu = "img/uye_avatar/$yeni_dosya_adi";	
						move_uploaded_file($tmp_name, "$dosya_yolu");
											
						
						$sql = "UPDATE uyeler SET avatar='$yeni_dosya_adi' WHERE kullanici_ad='$adi'";
						
						$sonuc = $veritabani -> query($sql);
						if(!$sonuc)
						{
							echo "hata";
							echo $veritabani->errno;
						}
						else
						{
							//avatar sessionu'nu güncelleme
							$sql2 = "SELECT avatar FROM uyeler WHERE kullanici_ad='$adi'";
							$sorgu = $veritabani -> query($sql2);
							$row = $sorgu -> fetch_array(MYSQLI_ASSOC);
							$_SESSION["avatar"] = $row["avatar"];
							echo "Başarılı Anasayfaya Dönüyor";
							
							//Eski Resimi Silme
							if($satir["avatar"] != "default.png")
							{
								unlink($eski_avatar_yolu);
							}
								header("Refresh: 5; url= anasayfa/index.php");
						}
					}
					$veritabani->close();
				}
			}
			else
			{
				echo "Sadece JPG veya PNG türünde olmalı";
			}
		}
	}
	else
	{
		header("Location: anasayfa/index.php");
	}
?>