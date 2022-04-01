<div id="content">
<div class="content-icerik">
<?php
	if(!isset($_GET["k"]))
	{
		header("Location: ../anasayfa/index.php");
	}
	
	$kategori = $_GET["k"];
	
	require_once("../vt-baglanti.php");
	
	$sorgu1 = $db->query("SELECT COUNT(*) as toplam FROM icerikler WHERE kategori_ad = '{$kategori}'") -> fetch(PDO::FETCH_ASSOC);
		
	if($sorgu1["toplam"] > 0)
	{
		//sayfalama
			$sayfa_basi_gosterilecek_icerik_sayisi = 5;
			$toplam_icerik_sayisi = $sorgu1["toplam"];
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
		//sayfalma
		$sorgu = $db->query("SELECT * FROM icerikler WHERE kategori_ad = '{$kategori}' ORDER BY icerik_id DESC LIMIT $limit, $sayfa_basi_gosterilecek_icerik_sayisi", PDO::FETCH_ASSOC);
		echo "<ul>";
		foreach( $sorgu as $row )
		{
			$sorgu2 = $db->query("SELECT kullanici_ad FROM uyeler WHERE uye_id = {$row['yazar_id']} ") -> fetch(PDO::FETCH_ASSOC);
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
					<a href=listele.php?k='.$kategori.'&p='.$i.' class="sayfa_numarasi">'.$i.'</a>
				';
			}
		}
	}
	else
	{
		echo "Bu kategoride bir şeyler yazılmamış";
	}
?>
</div>
<?php
	include("../content-sidebar.php");
?>
</div>