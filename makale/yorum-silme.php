<?php
	if($_POST)
	{
		$id = $_POST["id"];
		//session id ve uyelik durumunu kesin kontrol et!!!!!!
		
		require_once("../vt-baglanti.php");
		
		session_start();
		
		$uye_statu = $_SESSION["uyelik_durumu"];
		$uye_id = $_SESSION["kullanici_id"];
		
		$sorgu1 = $db->prepare("SELECT * FROM yorumlar WHERE yorum_id = ?");
		$sorgu1->execute(array($id));
		
		if($sorgu1)
		{
			if($sorgu1->rowCount() > 0)
			{
				$yorum = $sorgu1->fetch(PDO::FETCH_ASSOC);
				
				if($uye_statu == 1)
				{
					if($yorum["yazar_id"] != $uye_id)
					{
						echo "hata";
					}
					else
					{
						//sil
						$yorumGizleSorgu = $db->query("UPDATE yorumlar SET durum = '0' WHERE yorum_id = '{$yorum["yorum_id"]}'");
					}
				}
				elseif($uye_statu == 2)
				{
					$sorgu2= $db->query("SELECT * FROM uyeler WHERE uye_id = '{$yorum["yazar_id"]}'")->fetch(PDO::FETCH_ASSOC);
					if($sorgu2["uyelik_durumu"] == 3)
					{
						echo "hata";
					}
					else
					{
						//sil
						$yorumGizleSorgu = $db->query("UPDATE yorumlar SET durum = '0' WHERE yorum_id = '{$yorum["yorum_id"]}'");
					}
				}
				elseif($uye_statu == 3)
				{
					$yorumGizleSorgu = $db->query("UPDATE yorumlar SET durum = '0' WHERE yorum_id = '{$yorum["yorum_id"]}'");
				}
				else
				{
					echo "hata";
				}
				
				if($yorumGizleSorgu)
				{
					echo "başarılı";
				}
				else
				{
					echo "hata";
				}
			}
			else
			{
				echo "istenen yorum yok";
			}
		}
		else
		{
			echo "veritabani hatasi";
		}
	}
?>