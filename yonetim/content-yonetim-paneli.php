<div id="content">
	
	<?php
	require("yonetim-paneli-fonksiyonlar.php");
	
	echo '<div class="yonetim-paneli-fonksiyon">';
	if(!isset($_GET["q"]))
	{
		echo '
		<h1>Yönetim Paneli</h1>
		<ul class="yonetim-paneli-islemler-listesi">
			<li><a href="../yonetim/yonetim-paneli.php?q=1">Yeni İçerik Oluştur</a></li>
			<li><a href="../yonetim/yonetim-paneli.php?q=2">İçerik Düzenle</a></li>
			<li><a href="../yonetim/yonetim-paneli.php?q=3">Kullanıcı Yetkisi Düzenle</a></li>
			<li><a href="../yonetim/yonetim-paneli.php?q=4">Kategori Ekle - Çıkart</a></li>	
			<li><a href="../yonetim/yonetim-paneli.php?q=5">Silinen Yorumları Listele</a></li>	
		</ul> ';
	}
	else
	{
		switch($_GET["q"])
		{
			case 1:
			YeniIcerikOlustur();
			echo "<p class='yonetim-paneli-geri-git'><a href='yonetim-paneli.php'>Geri Dön</a></p>";
			break;
			
			case 2:
				if(!isset($_GET["id"]))
				{
					icerikleriListele();
				}
				else
				{
					icerikDuzenle();
				}
				echo "<p class='yonetim-paneli-geri-git'><a href='yonetim-paneli.php'>Geri Dön</a></p>";
			break;
			
			case 3:
				kullanicilariListele();
				echo "<p class='yonetim-paneli-geri-git'><a href='yonetim-paneli.php'>Geri Dön</a></p>";
			break;
			
			case 4:
			kategoriEkleCikar();
			echo "<p class='yonetim-paneli-geri-git'><a href='yonetim-paneli.php'>Geri Dön</a></p>";
			break;
			
			case 5:
			silinenYorumlarıListele();
			echo "<p class='yonetim-paneli-geri-git'><a href='yonetim-paneli.php'>Geri Dön</a></p>";
			break;
			
			default:
			echo "hata <a href='yonetim-paneli.php'>Geri Dön</a>";
			
		}
		echo '</div>';
	}
	
	?>
	<div class="yonetim-paneli-istatistikler">
		<?php
			//her switch case de geliyor
			if(!isset($_GET["q"]))
			{
			require_once("../vt-baglanti.php");
			$toplam_uye = $db->query("SELECT COUNT(*) as toplam FROM uyeler")->fetch(PDO::FETCH_ASSOC);
			$toplam_yasakli_uye = $db->query("SELECT COUNT(*) as toplam FROM uyeler WHERE uyelik_durumu = 0")->fetch(PDO::FETCH_ASSOC);
			$toplam_moderator_uye = $db->query("SELECT COUNT(*) as toplam FROM uyeler WHERE uyelik_durumu = 2")->fetch(PDO::FETCH_ASSOC);
			$toplam_admin_uye = $db->query("SELECT COUNT(*) as toplam FROM uyeler WHERE uyelik_durumu = 3")->fetch(PDO::FETCH_ASSOC);
			
			echo '<h3>Üye İstatistikleri<h3>';
			echo 'Sitede Toplam '.$toplam_uye["toplam"].' Üye Var <br/>';
			echo $toplam_yasakli_uye["toplam"].' Adet Üye Siteden Uzaklaştırılmış <br/>';
			echo 'Sitedeki Toplam Moderatör Sayısı: '.$toplam_moderator_uye["toplam"].'<br/>';
			echo 'Sitedeki Toplam Admin Sayısı: '.$toplam_admin_uye["toplam"];
			
			$toplam_icerik = $db->query("SELECT COUNT(*) as toplam FROM icerikler")->fetch(PDO::FETCH_ASSOC);
			$toplam_kategori = $db->query("SELECT COUNT(*) as toplam FROM kategoriler")->fetch(PDO::FETCH_ASSOC);
			$toplam_kategori = $db->query("SELECT COUNT(*) as toplam FROM icerikler")->fetch(PDO::FETCH_ASSOC);
			
			echo '<h3>Site İstatistikleri<h3>';
			echo 'Sitede Toplam '.$toplam_icerik["toplam"].' Adet İçerik Yayınlanmış <br/>';
			echo 'Sitede Toplam '.$toplam_kategori["toplam"].' Adet Kategori Bulunmakta <br/>';
			}
		?>
		
	</div>
</div>