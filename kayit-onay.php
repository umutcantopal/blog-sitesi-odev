<?php
	if($_POST["kayit_onay_buton"] && !isset($_SESSION["oturum"]))
	{
		$kullaniciad = $_POST["kullaniciad"];
		$kullanicisifre = $_POST["kullanicisifre"];
		$kullanicieposta = $_POST["kullanicieposta"];
		
		if(empty($kullaniciad) || empty($kullanicisifre) || empty($kullanicieposta) || !isset($_POST["kullanicisozlesme"]))
		{
			echo "Bütün alanları doldurmalı ve kullanıcı sözleşmesini onaylamalısınız.";
			header("Refresh: 3; url=uye-kayit.php");
		}
		else
		{
			if((strlen($kullaniciad)<4 || strlen($kullaniciad)>20))
			{
				echo "kullanıcı adı 4-20 karakter arasında olmalı.";
				header("Refresh: 3; url=uye-kayit.php");
			}
			elseif((strlen($kullanicisifre)<6 || strlen($kullanicisifre)>30))
			{
				echo "şifre 6-30 karakter arasında olmalı.";
				header("Refresh: 3; url=uye-kayit.php");
			}
			elseif($kullanicieposta>50)
			{
				echo "e posta adresi 50 karakterden uzun olmamalı.";
				header("Refresh: 3; url=uye-kayit.php");
			}
			elseif(!isset($_POST["kullanicisozlesme"]))
			{
				echo "Sözleşmeyi kabul etmelisiniz";
				header("Refresh: 3; url=uye-kayit.php");
			}
			else
			{	
				// $veritabani = mysqli_connect("localhost","root","","sistemanalizibir");
				// mysqli_set_charset($veritabani,"utf8");
				
				require_once("vt-baglanti.php");
				
				// $kullanici_ad_sorgu = mysqli_query($veritabani, 'SELECT * FROM uyeler WHERE kullanici_ad='.'"'.$kullaniciad.'"');
				
				$kullanici_ad_kontrol = $db->prepare("SELECT * FROM uyeler WHERE kullanici_ad= ?");
				$kullanici_ad_kontrol->execute(array($kullaniciad));
				
				// $kadi_fetch = $kullanici_ad_kontrol_exec->fetch(PDO::FETCH_ASSOC);
				
				$sorgudan_gelen_satir_sayisi = $kullanici_ad_kontrol->RowCount();
				
				if($sorgudan_gelen_satir_sayisi != 0)
				{
					echo "Bu kullanıcı adı daha önceden alınmış";
					header("Refresh: 3; url=uye-kayit.php");
				}
				
				else
				{
					// $uye_ekleme_sorgu = "INSERT INTO uyeler (kullanici_ad, sifre, eposta, avatar, uyelik_durumu) VALUES (".$kullaniciad.",".$kullanicisifre.",".$kullanicieposta.", img/uye_avatar/default.png, 1)";
					// $uye_ekle = mysqli_query($veritabani, "INSERT INTO uyeler (kullanici_ad,sifre,eposta,avatar,uyelik_durumu)
					// VALUES ('{$kullaniciad}','{$kullanicisifre}','{$kullanicieposta}','default.png',1)");
					
					$sorgu = $db->prepare("INSERT INTO uyeler SET
					kullanici_ad = ?,
					sifre = ?,
					eposta = ?,
					avatar = ?,
					uyelik_durumu = ?");
					
					$kayit_olustur = $sorgu->execute(array(
						$kullaniciad, $kullanicisifre, $kullanicieposta, 'default.png', 1
					));
					
					if($kayit_olustur)
					{
						echo "kayıt başarılı";
						
						// $kullanici_id = $db->query("SELECT uye_id FROM uyeler WHERE kullanici_ad = {$kullaniciad}", PDO::FETCH_ASSOC);
						
						
						
						session_start();
						$_SESSION["oturum"]=true;
						$_SESSION["kullanici_ad"]=$kullaniciad;
						$_SESSION["kullanici_id"]=$bulunan_uye["uye_id"];
						// $_SESSION["sifre"]=$kullanicisifre;
						$_SESSION["uyelik_durumu"]=1;
						$_SESSION["avatar"]="default.png";
						$_SESSION["uye_id"]= $db->lastInsertId();
						
						header("Refresh: 3; url=anasayfa/index.php");
					}
					else
					{
						echo "kayıt başarısız";
						header("Refresh: 3; url=anasayfa/index.php");
					}
				}
			}
		}
	}
	else
	{
		header("Location: ../anasayfa/index.php");
	}
?>