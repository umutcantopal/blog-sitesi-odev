<?php
	if($_POST["giris_buton"] && !isset($_SESSION["oturum"]))
	{	
		// $veritabani = mysqli_connect("localhost","root","","sistemanalizibir");
		// mysqli_set_charset($veritabani,"utf8");
		
		require_once("vt-baglanti.php");
		
		$kullanici_ad=$_POST["kullanici_ad"];
		$sifre=$_POST["sifre"];
		
		if(empty($kullanici_ad) || empty($sifre))
		{
			echo "Kullanıcı adı ve şifre boş olmamalı";
			header("Refresh: 3; url= anasayfa/index.php");
		}
		else
		{
			// $veritabani_sorgu = 'SELECT * FROM uyeler WHERE kullanici_ad='.'"'.$kullanici_ad.'"';
			// $sorgu= mysqli_query($veritabani,$veritabani_sorgu);
			// $gelen_satir_sayisi = mysqli_num_rows($sorgu);
			
			$sorgu = $db->prepare("SELECT * FROM uyeler WHERE kullanici_ad= ?"); 
			$sorgu->execute(array($kullanici_ad));
			
			$gelen_satir_sayisi = $sorgu->RowCount();
			
			if($gelen_satir_sayisi > 0)
			{
				// $bulunan_uye = mysqli_fetch_array($sorgu);
				$bulunan_uye = $sorgu->fetch(PDO::FETCH_ASSOC);
				
				if($bulunan_uye['sifre'] == $sifre && $bulunan_uye['kullanici_ad'] == $kullanici_ad)
				{
					//başaralı
					if($bulunan_uye["uyelik_durumu"] == 0)
					{
						echo "Hesabınız bir yönetici tarafından kapatılmış";
						header("Refresh: 3; url= anasayfa/index.php");
					}
					else
					{
						session_start();
						$_SESSION["oturum"]=true;
						$_SESSION["kullanici_ad"]=$kullanici_ad;
						$_SESSION["kullanici_id"]=$bulunan_uye["uye_id"];
						$_SESSION["uyelik_durumu"]=$bulunan_uye["uyelik_durumu"];
						$_SESSION["avatar"]=$bulunan_uye["avatar"];
						$_SESSION["uye_id"]=$bulunan_uye["uye_id"];
						
						echo "Giriş başaralı, ana sayfaya dönüyorsunuz";
						header("Refresh: 3; url= anasayfa/index.php");
					}	
				}
				else
				{
					echo "yanlış kullanıcı adı veya şifre yanlış";
					header("Refresh: 3; url= anasayfa/index.php");
				}
			}
			else
			{
				echo "Böyle bir kullanıcı bulunamadı";
				header("Refresh: 3; url= anasayfa/index.php");
			}
		}
	}
	else
	{
		header("Location: anasayfa/index.php");
	}
?>