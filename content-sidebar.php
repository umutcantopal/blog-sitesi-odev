<?php
	require_once("vt-baglanti.php");
?>

<div class="content-sidebar">
	<div class="arama">
		<h4>Arama Yap</h4>
		<img src="../img/buyutec.png" width="32" height="32">
		<form action="../arama/arama.php" type="GET">
			<input type="text" name="q" class="arama-textbox">
			<input type="submit" value="Şimdi Ara" class="arama-buton">
		</form>
	</div>
			
	<div class="si kategori">
		<h4>Kategoriler</h4>
		<ul>
			<?php
			
			$sorgu = $db->query("SELECT * FROM kategoriler", PDO::FETCH_ASSOC);
			
			if ( $sorgu->rowCount() ){
				 foreach( $sorgu as $row ){
					  echo '<li><a href="../kategori/listele.php?k='.$row["kategori_ad"].'">'.ucfirst($row["kategori_ad"]).'</a></li>';
				 }
			}
			
			?>
		</ul>
	</div>
	
	<div class="si son-yorumlar">
		<h4>Son Yorumlar</h4>
		<ul>
			<?php
				$sorgu = $db->query("SELECT * FROM yorumlar WHERE durum = 1 ORDER BY tarih DESC LIMIT 5", PDO::FETCH_ASSOC);
				
				if($sorgu->rowCount() == 0)
				{
					echo "hiç yorum yazılmamış";
				}
				else
				{
					foreach($sorgu as $row){
						$yazar_id = $row["yazar_id"];
						$icerik_id = $row["icerik_id"];
						$sorgu2 = $db->query("SELECT kullanici_ad FROM uyeler WHERE uye_id = $yazar_id")->fetch(PDO::FETCH_ASSOC);
						$sorgu3 = $db->query("SELECT baslik FROM icerikler WHERE icerik_id = $icerik_id")->fetch(PDO::FETCH_ASSOC);
						
						echo '
							<li>
								<div class="yorum-div">
									<div class="yorum-yazar">'.$sorgu2["kullanici_ad"].'</div>
									<div class="yorum-icerik">'.$sorgu3["baslik"].' konusunda dedi ki:</div>
									<div class="yorum">'.$row["yorum"].'</div>
								</div>
							</li>
						';
					}
				}
			?>
		</ul>
	</div>
				
	<div class="si son-yazılar">
		<h4>Son Yazılar</h4>
		<ul>
			<?php
				$sorgu = $db->query("SELECT icerik_id, baslik FROM icerikler WHERE yayin_durumu = 1 ORDER BY icerik_id DESC LIMIT 10", PDO::FETCH_ASSOC);
				
				foreach($sorgu as $row){
					echo '<li><a href = "../makale/konu.php?id='.$row["icerik_id"].'" > '.$row["baslik"].'</a></li>';
				}
			?>
		</ul>
	</div>
</div>

<div style="clear:both;"></div>