<?php
	if($_POST)
	{
		session_start();
		require_once("../vt-baglanti.php");
		
		$ID = $_POST["makaleID"];
		
		$yorum_yazar_id = $_SESSION["uye_id"];
		
		$gelen_yorum = $_POST["yorum"];
		$bosluk_silinmis = trim($gelen_yorum);
		
		if($bosluk_silinmis == "")
		{
			echo "boş veri girildi";
		}
		else
		{
			$taglar_ayrilmis = strip_tags($bosluk_silinmis);
			
			$sorgu = "INSERT INTO yorumlar SET 
			yazar_id = ?,
			icerik_id = ?,
			yorum = ?,
			tarih = ?,
			durum = ?";
			
			$zaman = date("Y-m-d H:i:s");
			
			$sorgu_hazirla = $db->prepare($sorgu);
			
			$sorgu_calistir = $sorgu_hazirla->execute(array(
				$yorum_yazar_id, $ID, $taglar_ayrilmis, $zaman, 1
			));
			
			if($sorgu_calistir)
			{
				echo '
					<li><div class="kullanici-yorumu" yorumid="'.$db->lastInsertId().'">
					<div class="kullanici-yorumu-ust">
					<img src="../img/uye_avatar/'.$_SESSION["avatar"].'" width="40" />
					<p>'.$_SESSION["kullanici_ad"].'</p>
					<p>'.$zaman.'</p>
					</div>
					<hr/>
					<div class="kullanici-yorumu-alt">
					<p class="yorum-icerigi">'.$taglar_ayrilmis.'</p>
					<p class="yorum-sil-buton">Sil</p>
					</div>
					</div></li>
				';
			}
			else
			{
				echo "yorum veritabanına yazılamadı";
			}
			// $_SESSION["uye_id"] ->>>> yazar_id
			// $icerik_id ->>>>>>>>>>>>> icerik_id
			// $taglar_ayrilmis ->>>>>>> yorum
			// tarih ->>>>>>>>>>>>>>>>>> date("Y-d-m H:i:s");
			// durum ->>>>>>>>>>>>>>>>>> 1
		}
	}
?>