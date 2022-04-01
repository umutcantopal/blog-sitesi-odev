<?php
	function YorumSilButonu($yazarBilgileri, $bulunanYorum)
	{
		if(isset($_SESSION["oturum"]))
		{
			if($_SESSION["uyelik_durumu"] == 3)
			{
				echo '<p class="yorum-sil-buton">Sil</p>';
			}
			elseif($_SESSION["uyelik_durumu"] == 1)
			{
				if($bulunanYorum['yazar_id'] == $_SESSION["uye_id"])
				{
					echo '<p class="yorum-sil-buton">Sil</p>';
				}
			}
			elseif($_SESSION["uyelik_durumu"] == 2)
			{
				if($yazarBilgileri["uyelik_durumu"] == 2)
				{
					if($bulunanYorum['yazar_id'] == $_SESSION["uye_id"])
					{
						echo '<p class="yorum-sil-buton">Sil</p>';
					}
				}
				elseif($yazarBilgileri["uyelik_durumu"] != 3)
				{
					echo '<p class="yorum-sil-buton">Sil</p>';
				}
			}
		}
	}
	
	function yorumYazmaAlaniniGetir()
	{
		if(!isset($_SESSION["oturum"]))
		{
			echo '<p style="color:#b73131;">Yorum yazabilmek için üye girişi yapmalısın.</p>';
		}
		else
		{
			echo '<p style="color:#b73131;">Bir Yorum Yaz</p>';
			echo '
				<div>
					<textarea class="yorumTextare" name="yorum" placeholder="Yorumu buraya girin..."></textarea>
					<input type="submit" value="Gönder" class="yorumGonderButonu" />
				</div>
				';
		}
	}
	
	// function bulunanYorumlarıYazdır($bulunanYorum, $yazarBilgileri)
	// {
		// $eklenenYorumSayisi = 0;
		// foreach($yorumSorgu as $bulunanYorum)
		// {
			// if($bulunanYorum['durum'] == 1)
			// {
				// $yorumYazanID = $bulunanYorum['yazar_id'];
								
				// $yorumSorgu2 = $db->query("SELECT kullanici_ad, avatar, uyelik_durumu FROM uyeler WHERE uye_id = $yorumYazanID", PDO::FETCH_ASSOC);
				// foreach($yorumSorgu2 as $yazarBilgileri)
				// {
					// echo '<div class="kullanici-yorumu">';
					// echo '<div class="kullanici-yorumu-ust">';
					// echo '<img src="../img/uye_avatar/'.$yazarBilgileri["avatar"].'" width="40" />';
					// echo '<p>'.$yazarBilgileri["kullanici_ad"].'</p>';
				// }
				// echo '<p>'.$bulunanYorum['tarih'].'';
				// echo '</div>';
				// echo '<hr/>';
				// echo '<div class="kullanici-yorumu-alt">';
				// echo $bulunanYorum['yorum'];
					
				// YorumSilButonu($yazarBilgileri, $bulunanYorum);
					
				// echo '</div>';
				// echo '</div>';
					
				
								
				// $eklenenYorumSayisi = $eklenenYorumSayisi + 1 ;
			// }
		// }
	// }
?>