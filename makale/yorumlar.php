<?php
	// include("yorum-fonksiyonlar.php");
	
	$yorumSorgu = $db->query("SELECT * FROM yorumlar WHERE icerik_id = $id ORDER BY tarih DESC", PDO::FETCH_ASSOC);
	// var_dump($yorumSorgu);
	if($yorumSorgu)
	{
		$bulunanYorumSatiri = $yorumSorgu->rowCount();
					
		if($bulunanYorumSatiri > 0)
		{
			$eklenenYorumSayisi = 0;
			foreach($yorumSorgu as $bulunanYorum)
			{
				if($bulunanYorum['durum'] == 1)
				{
					$yorumYazanID = $bulunanYorum['yazar_id'];
								
					$yorumSorgu2 = $db->query("SELECT * FROM uyeler WHERE uye_id = $yorumYazanID", PDO::FETCH_ASSOC);
					foreach($yorumSorgu2 as $yazarBilgileri)
					{
						echo '<li><div class="kullanici-yorumu" yorumid="'.$bulunanYorum["yorum_id"].'">';
						echo '<div class="kullanici-yorumu-ust">';
						echo '<img src="../img/uye_avatar/'.$yazarBilgileri["avatar"].'" width="40" />';
						echo '<p>'.$yazarBilgileri["kullanici_ad"].'</p>';
					}
					echo '<p>'.$bulunanYorum['tarih'].'</p>';
					echo '</div>';
					echo '<hr/>';
					echo '<div class="kullanici-yorumu-alt">';
					echo '<p class="yorum-icerigi">'.$bulunanYorum['yorum'].'</p>';
					
					YorumSilButonu($yazarBilgileri, $bulunanYorum);
					
					echo '</div>';
					echo '</div></li>';
					
					$eklenenYorumSayisi = $eklenenYorumSayisi + 1 ;
				}
			}
			if($eklenenYorumSayisi == 0) //Konu için yorum yazılmış ama durumu 0 ise alttaki mesajı vermesi için bu kontrolü ekledim.
			{
				echo '<li class="yorum-yazilmamis-bilgi-mesaji">Bu konuya hiç yorum yazılmamış. İlk yorumu yazan sen ol.</li>';
			}
		}
		else
		{
			echo '<li class="yorum-yazilmamis-bilgi-mesaji">Bu konuya hiç yorum yazılmamış. İlk yorumu yazan sen ol.</li>';
		}
	}
	else
	{
		echo "Yorumları getirirken bir şeyler ters gitti";
	}
?>