<?php
	if($_POST)
	{
		require_once("../vt-baglanti.php");
		session_start();
		
		$yorumid = $_POST["yorumid"];
		
		$sorgu1 = $db->prepare("SELECT * FROM yorumlar WHERE yorum_id = ?");
		$sorgu1->execute(array($yorumid));
		
		if($sorgu1)
		{
			if($sorgu1->rowCount() != 1)
			{
				echo "yorum bulunamadı";
			}
			else
			{	
				$yorum = $sorgu1->fetch(PDO::FETCH_ASSOC);
				$yazar = $db->query("SELECT * FROM uyeler WHERE uye_id = '{$yorum["yazar_id"]}'")->fetch(PDO::FETCH_ASSOC);
				if($yazar)
				{
					if($_SESSION["uyelik_durumu"] == 2)
					{
						if($yazar["uyelik_durumu"] == 3)
						{
							echo "hata";
						}
						elseif($yazar["uyelik_durumu"] == 2 && $yorum["yazar_id"] != $_SESSION["kullanici_id"])
						{
							echo "hata";
						}
						else
						{
							//geri getir!!!
							$yorum_tekrar_yayinla = $db->query("UPDATE yorumlar SET durum = 1 WHERE yorum_id = $yorumid");
							if($yorum_tekrar_yayinla)
							{
								echo "başarılı";
							}
							else
							{
								echo "hata";
							}
						}
					}
					elseif($_SESSION["uyelik_durumu"] == 3)
					{
						$yorum_tekrar_yayinla = $db->query("UPDATE yorumlar SET durum = 1 WHERE yorum_id = $yorumid");
						if($yorum_tekrar_yayinla)
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
						echo "hata";
					}
				}
				else
				{
					echo "sorgu hatası";
				}
			}
		}
		else
		{
			echo "sorgu hatası";
		}
	}
?>