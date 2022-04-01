<?php
	if($_POST)
	{
		$veri = key($_POST);
		$secilen_rutbe = $_POST[$veri];
		
		$veri2 = explode("-",$veri);
		
		$id = $veri2[1];
		require_once("../vt-baglanti.php");
		session_start();
		
		$sorgu = $db->prepare("SELECT kullanici_ad,uyelik_durumu FROM uyeler WHERE uye_id = ?");
		$sorgu->execute(array($id));
		
		$kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);
		$gelinen_sayfa = htmlspecialchars($_SERVER['HTTP_REFERER']);
		
		if($_SESSION["uyelik_durumu"] == 2 && ($secilen_rutbe == 2 || $secilen_rutbe == 3))
		{
			die();
		}
		else if($_SESSION["uyelik_durumu"] == 1 || $_SESSION["uyelik_durumu"] == 0)
		{
			die();
		}
		else
		{
			if($kullanici["uyelik_durumu"] == $secilen_rutbe)
			{
				echo "Bu kullanıcı zaten bu rütbede, değişiklik yapılmadı.";
				header("Refresh: 3; url=$gelinen_sayfa");
			}
			else
			{
				$sorgu2 = $db->prepare("UPDATE uyeler SET uyelik_durumu = ? WHERE uye_id = ?");
				$sorgu2->execute(array($secilen_rutbe,$id));
				
				if($sorgu2)
				{
					echo "Başarılı<br>";
					header("Refresh: 3; url=$gelinen_sayfa");
				}
			}
		}
	}
?>