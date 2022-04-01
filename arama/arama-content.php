<div id="content">
<div class="content-icerik">
	<?php
		require_once("../vt-baglanti.php");
		$q_dizi = explode(" ",$q);
		$q_eleman_sayisi = count($q_dizi);
		
		if($q_eleman_sayisi != 0)
		{
			$bulunan_icerikler = array();
			// var_dump($bulunan_icerikler);
			for($i=0;$i<$q_eleman_sayisi;$i++)
			{
				$sorgu = $db->prepare("SELECT * FROM icerikler WHERE baslik LIKE ?");
				$sorgu->execute(array(
				 "%$q_dizi[$i]%"
				));
				// $sorgu = $db->query("SELECT * FROM icerikler WHERE baslik LIKE '%$q%'");
				$sonuc = $sorgu->fetch(PDO::FETCH_ASSOC);
				if($sonuc)
				{
					$bulunan_icerikler[$i] = $sonuc;
				}
				// var_dump($sonuc);
			}
			if(count($bulunan_icerikler) == 0)
			{
				echo "<h1 style='font-size:30px; font-weight:bold; margin-bottom:5px; color:gray;'>Aradağını Bulamadım<h1>";
			}
			else
			{
				echo "<h1 style='font-size:30px; font-weight:bold; margin-bottom:5px; color:gray;'>Arama Sonuçları<h1>";
				for($i=0;$i<count($bulunan_icerikler);$i++)
				{
					$sorgu2 = $db->query("SELECT kullanici_ad FROM uyeler WHERE uye_id = {$bulunan_icerikler[$i]['yazar_id']}") -> fetch(PDO::FETCH_ASSOC);
					
					echo '
						<div class="icerik-kart">
							<div class="icerik-kart-baslik">
								<h2>'.$bulunan_icerikler[$i]['baslik'].'</h2>
							<span class="icerik-kart-yazar">'.$sorgu2['kullanici_ad'].'</span> tarafından <span class="icerik-kart-tarih">'.$bulunan_icerikler[$i]['tarih'].'</span> tarihinde
							</div>
								<div class="icerik-kart-bilgi">
								<img src="../img/makale_resimler/'.$bulunan_icerikler[$i]['kapak_resmi'].'" height="100px" width="200px" />
								<p>'.$bulunan_icerikler[$i]['aciklama_yazisi'].'</p>
								<a href="../makale/konu.php?id='.$bulunan_icerikler[$i]['icerik_id'].'">devamını oku--></a>
							</div>
						</div>
					';
				}
			}
		}
	?>
</div>
<?php
	include("../content-sidebar.php");
?>
</div>
