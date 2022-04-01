<div class="content-icerik">
	<?php
		require_once("../vt-baglanti.php");
		
		// sayfalama
		$sorgu3 = $db->query("SELECT COUNT(*) as toplam FROM icerikler") -> fetch(PDO::FETCH_ASSOC);
		
		$sayfa_basi_gosterilecek_icerik_sayisi = 5;
		$toplam_icerik_sayisi = $sorgu3["toplam"];
		$toplam_sayfa_sayisi = ceil($toplam_icerik_sayisi/$sayfa_basi_gosterilecek_icerik_sayisi);
		
		$sayfa;
		
		if(!isset($_GET["p"]))
		{
			$_GET["p"] = 1;
			$sayfa = 1;
		}
		else
		{
			if($_GET["p"]<1)
			{
				$_GET["p"]=1;
			}
			
			if($_GET["p"]>$toplam_sayfa_sayisi)
			{
				$_GET["p"]=$toplam_sayfa_sayisi;
			}
			
			$sayfa = $_GET["p"];
		}
		
		$limit = ($sayfa - 1) * $sayfa_basi_gosterilecek_icerik_sayisi ;
		
		// sayfalama
		
		$sorgu = $db->query("SELECT * FROM icerikler WHERE yayin_durumu = 1 ORDER BY icerik_id DESC LIMIT $limit, $sayfa_basi_gosterilecek_icerik_sayisi ", PDO::FETCH_ASSOC);
		// $sorgu = $db->query("SELECT * FROM icerikler ORDER BY icerik_id DESC LIMIT $limit, 2") -> fetch(PDO::FETCH_ASSOC);
		
		if($sorgu->rowCount() > 0)
		{
			// $sorgu2 = $db->query("SELECT kullanici_ad FROM uyeler WHERE $sorgu['yazar_id'] = uye_id", PDO::FETCH_ASSOC);
			echo "<ul>";
			foreach( $sorgu as $row )
			{
				$sorgu2 = $db->query("SELECT kullanici_ad FROM uyeler WHERE uye_id = {$row['yazar_id']}") -> fetch(PDO::FETCH_ASSOC);
				// var_dump($row);
				echo "<li>";
				echo '
						<div class="icerik-kart">
							<div class="icerik-kart-baslik">
								<h2>'.$row['baslik'].'</h2>
							<span class="icerik-kart-yazar">'.$sorgu2['kullanici_ad'].'</span> tarafından <span class="icerik-kart-tarih">'.$row['tarih'].'</span> tarihinde
							</div>
								<div class="icerik-kart-bilgi">
								<img src="../img/makale_resimler/'.$row['kapak_resmi'].'" height="100px" width="200px" />
								<p>'.$row['aciklama_yazisi'].'</p>
								<a href="../makale/konu.php?id='.$row['icerik_id'].'">devamını oku--></a>
							</div>
						</div>
					';
				echo "</li>";
			}
			echo "</ul>";
		}
		else
		{
			echo "Görüntülenecek bir şey bulunamadı.";
		}
		
		for($i=1;$i<=$toplam_sayfa_sayisi;$i++)
		{
			if($i == $sayfa)
			{
				echo '
					<a class="sayfa_numarasi" style="border:none; color:black;">'.$i.'</a>
				';
			}
			else
			{
				echo '
					<a href=index.php?p='.$i.' class="sayfa_numarasi">'.$i.'</a>
				';
			}
		}
	?>
</div>