<?php
	if($_POST)
	{
		$kategori_ad = $_POST["kategori_ad"];
		require_once("../vt-baglanti.php");
		$sorgu = $db->query("SELECT COUNT(*) as toplam FROM kategoriler WHERE kategori_ad = '{$kategori_ad}'")->fetch(PDO::FETCH_ASSOC);
		if($sorgu["toplam"] != 0)
		{
			echo "bu isimde bir kategori zaten var";
			header("Refresh: 3; url=yonetim-paneli.php?q=4");
		}
		else
		{	
			$sorgu2 = "INSERT INTO kategoriler SET kategori_ad = '$kategori_ad', icerik_sayisi = 0";
			if($db->exec($sorgu2))
			{
				echo "başarılı";
				header("Refresh: 3; url=yonetim-paneli.php?q=4");
			}
			else
			{
				echo "bir hata oldu";
				header("Refresh: 3; url=yonetim-paneli.php?q=4");
			}
		}
	}
?>