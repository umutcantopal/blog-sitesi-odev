<div class="content-icerik makale">
	
	<?php
		if(!isset($_GET["id"]))
		{
			header("Location: ../anasayfa/index.php");
		}
		
		$id = $_GET["id"];
		if($id != null)
		{
			
			require_once("../vt-baglanti.php");
			
			if($db)
			{
				$db->query("SET CHARACTER SET utf8");
				
				$sorgu = $db->prepare("SELECT * FROM icerikler WHERE icerik_id= ?"); 
				$sorgu->execute(array($id));
				
				
				// $sorgu = $db->query("SELECT * FROM icerikler WHERE icerik_id='{$id}'") -> fetch(PDO::FETCH_ASSOC);
				if($sorgu)
				{
					if($sorgu->rowCount() > 0)
					{
						$sorgu1 = $sorgu->fetch(PDO::FETCH_ASSOC);
						if($sorgu1["yayin_durumu"] == 0)
						{
							echo "Bu içerik şimdi yok, yada hiç olmadı";
							die();
						}
						else
						{
							$sorgu2 = $db->query("SELECT kullanici_ad FROM uyeler WHERE uye_id={$sorgu1["yazar_id"]}") -> fetch(PDO::FETCH_ASSOC);
							
							if($sorgu2)
							{
								// Başlık
								echo '<div class="makale_id" style="display:none">'.$sorgu1["icerik_id"].'</div>';//yorum gönderirken veritabanına yazılacak id buradan geliyor
								echo '<h1 class="makale-baslik">'.$sorgu1["baslik"].'</h1>';
						
								// Yazar ver tarih
								echo '<p class="yazar-ve-tarih-bilgisi">
								<span class="makale-yazar">'.$sorgu2["kullanici_ad"].'</span> tarafından
								<span class="makale-tarih">'.$sorgu1["tarih"].'</span> tarihinde yazıldı.
								</p>';
							
								//Açıklama yazısı
								echo "<p class='tanitim-yazisi'>".$sorgu1["aciklama_yazisi"]."</p>";
							
								//Kapak Resmi
								$resim = $sorgu1["kapak_resmi"];
								echo '<img src="../img/makale_resimler/'.$resim.'"'.' style="width:100%">';
								
								//İcerik
								echo "<div>".nl2br($sorgu1["icerik_yazi"])."</div>";
							}
						
							else
							{
								echo "ikinci vt sorgusunda hata";
							}
						}
					}
					else
					{
						echo "Ardığın sayfayı bulamadım...";
						die();
					}
				}
				else
				{
					echo "sorguda hata";
					die();
				}
			}
			else
			{
				print $e->getMessage();
			}
		}
		else
		{
			echo "Aradığın sayfa bulunamadı";
			die();
		}
		
	?>
	
	
	
	<div class="yorumlar">
		<h3 class="yorumlar-ust-baslik">Yorumlar</h3>
		<?php
			include("yorum-fonksiyonlar.php");
			yorumYazmaAlaniniGetir();
		?>
		<ul class="yorumlarListe">
			<?php
				include("yorumlar.php");
			?>
		</ul>
	</div>
	
</div>