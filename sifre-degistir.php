<?php
	if($_POST["degistir"])
	{	
		session_start();
		$eskisifre= $_POST["eskisifre"];
		$yenisifre= $_POST["yenisifre"];
		$yenisifretekrar= $_POST["yenisifretekrar"];
		
		if(empty($eskisifre) || empty($yenisifre) || empty($yenisifretekrar))
		{
			echo "Bütün alanları doldurup tekrar deneyin";
			header("Refresh: 5; url= profil/profili-duzenle.php");
		}
		else
		{
			$veritabani = new mysqli("localhost","root","","sistemanalizibir");
			if($veritabani->connect_error)
			{
				echo "Veritabanı bağlantı hatası, anasayfa dönüyor";
				header("Refresh: 5; url= anasayfa/index.php");
			}
			else
			{
				$veritabani -> set_charset("utf8");
				$adi = $_SESSION["kullanici_ad"];
				
				$sql = "SELECT sifre FROM uyeler WHERE kullanici_ad='$adi'";
				$sorgu = $veritabani->query($sql);
				$row = $sorgu->fetch_array(MYSQLI_ASSOC);
				
				if($eskisifre !== $row["sifre"])
				{
					echo "Eski şifrenizi hatalı girdiniz";
					header("Refresh: 5; url= profil/profili-duzenle.php");
				}
				else
				{
					if($yenisifre != $yenisifretekrar)
					{
						echo "Yeni şifrenizi aynı şekilde tekrar giremediniz";
						header("Refresh: 5; url= profil/profili-duzenle.php");
					}
					else
					{
						$sql2 = "UPDATE uyeler SET sifre='$yenisifre' WHERE kullanici_ad='$adi'";
						$sorgu2 = $veritabani->query($sql2);
						if($sorgu2)
						{
							echo "Başarılı";
							header("Refresh: 5; url=anasayfa/index.php");
							$veritabani->close();
						}
						else
						{
							echo "Bir şeyler yanlış gitti tekrar deneyiniz";
							$sorgu2->errno;
							// header("Refresh: 5; url=profili-duzenle.php");
							$veritabani->close();
						}
					}
				}
			}
		}
	}
	else
	{
		header("Location: anasayfa/index.php");
	}
?>