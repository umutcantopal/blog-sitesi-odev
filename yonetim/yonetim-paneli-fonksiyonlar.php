<?php
	function YeniIcerikOlustur(){
		require_once("../vt-baglanti.php");
		echo '
		<form class = "IcerikOlusturmaForm" method="POST" action="icerik-yaz.php" enctype="multipart/form-data">
			<h1>Yeni İçerik Oluştur</h1>
			<table style="width:100%">
				<tr>
					<td>Başlık:</td>
					<td><input type="text" name="icerik_baslik" class="icerik_baslik"></td>
				</tr>
				<tr>
					<td>Açıklama Yazısı: </td> 
					<td><textarea name="aciklama_yazisi" class="aciklama_yazisi"></textarea></td>
				</tr>
				<tr>
					<td>Kapak Resmi:</td>
					<td><input type="file" name="dosya" class="kapak_resim" /></td>
				</tr>
				<tr>
					<td>İçerik:</td>
					<td><textarea name="icerik_yazisi" class="icerik_yazisi" ></textarea></td>
				</tr>
				<tr>
					<td>Kategori:</td>
					<td>';
					echo '<select name="kategori" id="ktgr">';
						$sorgu = $db->query("SELECT * FROM kategoriler", PDO::FETCH_ASSOC);
							foreach ($sorgu as $row){
								extract($row);
								echo '<option value = "'.$kategori_ad.'">'.$kategori_ad.'</option>';
							}
				  Echo '</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Gönder"></td>
				</tr>
			</table>
		<form>
		';
	}
	
	function kategoriEkleCikar(){
		echo '<div class="yp-kategori-duzenle">';
		require_once("../vt-baglanti.php");
		$sorgu = $db->query("SELECT * FROM kategoriler", PDO::FETCH_ASSOC);
		echo '<h1>Mevcut Kategoriler</h1>';
		echo '<ul>';
		foreach($sorgu as $row){
			echo '<li>'.$row["kategori_ad"].'</li>';
		}
		echo '</ul>';
		
		echo '
			<h1>Yeni Kategori Ekle</h1>
			<form action="kategori-ekle.php" method="POST">
				<input type="text" name="kategori_ad" placeholder="Kategori Adı" />
				<input type="submit" value="Ekle"/>
			</form>
		';
		echo '</div>';
	}
	
	function icerikleriListele(){
		require_once("../vt-baglanti.php");
		// sayfalama
		$sorgu3 = $db->query("SELECT COUNT(*) as toplam FROM icerikler") -> fetch(PDO::FETCH_ASSOC);
		
		$sayfa_basi_gosterilecek_icerik_sayisi = 10;
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
		
		$uye_id = $_SESSION['kullanici_id'];
		
		if($_SESSION["uyelik_durumu"] == 3)
		{
			$sorgu = $db->query("SELECT icerik_id, yazar_id, baslik FROM icerikler ORDER BY icerik_id DESC LIMIT $limit, $sayfa_basi_gosterilecek_icerik_sayisi", PDO::FETCH_ASSOC);
		}
		else
		{
			$sorgu = $db->query("SELECT icerik_id, yazar_id, baslik FROM icerikler WHERE yazar_id = $uye_id ORDER BY icerik_id DESC LIMIT $limit, $sayfa_basi_gosterilecek_icerik_sayisi", PDO::FETCH_ASSOC);
		}
		
		$uye_id = $_SESSION['kullanici_id'];
		$sorgu3 = $db->query("SELECT count(*) as toplam FROM icerikler WHERE yazar_id = $uye_id")->fetch(PDO::FETCH_ASSOC);
		
		echo "<h1>Yayınlanan İçeriklerin Listesi</h1>";
		if($sorgu3["toplam"] == false OR $sorgu3["toplam"] == 0)
		{
			echo "Düzenleyebileceğin bir içerik yok...";
		}
		else
		{
			echo
			'
				<table class="table">
				<thead>
					<tr>
						<th>Yazar</th>
						<th>İçerik</th>
					</tr>
				</thead>
				<tbody>
			';
			foreach($sorgu as $icerik)
			{
				$sorgu2 = $db->query("SELECT kullanici_ad FROM uyeler WHERE uye_id = $icerik[yazar_id]")->fetch(PDO::FETCH_ASSOC);
				echo
				"
					<tr>
						<td>$sorgu2[kullanici_ad]</td>
						<td>$icerik[baslik]</td>
						<td><a href='yonetim-paneli.php?q=2&id=$icerik[icerik_id]'>Düzenle</a></td>
					</tr>
				";
			}
			echo
			"
				</tbody>
				</table>
			";
			//sayfaları yazma
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
						<a href=yonetim-paneli.php?q=2&p='.$i.' class="sayfa_numarasi">'.$i.'</a>
					';
				}
			}
			//sayfaları yazma
		}
	}
	
	function icerikDuzenle(){
		require_once("../vt-baglanti.php");
		$id = $_GET["id"];
		
		if(is_numeric($id))
		{
			$sorgu = $db->query("SELECT * FROM icerikler WHERE icerik_id = $id")->fetch(PDO::FETCH_ASSOC);
			
			if($sorgu)
			{			
				echo '
				<form class = "IcerikOlusturmaForm" method="POST" action="icerik-guncelle.php" enctype="multipart/form-data">
					<h1>İçeriği Düzenle</h1>
					<table style="width:100%">
						<tr>
							<td>Başlık:</td>
							<td><input type="text" name="icerik_baslik" class="icerik_baslik" value="'.$sorgu["baslik"].'"></td>
							<td><input type="text" name="icerik_id" value="'.$id.'" style="display:none;"></td>
						</tr>
						<tr>
							<td>Açıklama Yazısı: </td> 
							<td><textarea name="aciklama_yazisi" class="aciklama_yazisi">'.$sorgu["aciklama_yazisi"].'</textarea></td>
						</tr>
						<tr>
							<td>Kapak Resmi:</td>
							<td><input type="file" name="dosya" class="kapak_resim" /></td>
						</tr>
						<tr>
							<td>İçerik:</td>
							<td><textarea name="icerik_yazisi" class="icerik_yazisi">'.$sorgu["icerik_yazi"].'</textarea></td>
						</tr>
						<tr>
							<td>Kategori:</td>
							<td>';
							echo '<select name="kategori" id="ktgr">';
								$sorgu2 = $db->query("SELECT * FROM kategoriler", PDO::FETCH_ASSOC);
									foreach ($sorgu2 as $row){
										extract($row);
										if($kategori_ad == $sorgu["kategori_ad"])
										{
											echo '<option value = "'.$kategori_ad.'" selected>'.$kategori_ad.'</option>';
										}
										else
										{
											echo '<option value = "'.$kategori_ad.'">'.$kategori_ad.'</option>';
										}
									}
							echo '</select>
							</td>
						</tr>
						<tr>
							<td>Bu içeriği Gizli Yap</td>
							<td>';
								if($sorgu["yayin_durumu"] == 0)
								{
									echo
									'
									<input type="radio" id="gizli" name="gizlilik" value="0" checked>
									<label for="gizli">Evet</label><br>
									<input type="radio" id="acik" name="gizlilik" value="1">
									<label for="acik">Hayır</label>
									';
								}
								else
								{
									echo
									'
									<input type="radio" id="gizli" name="gizlilik" value="0">
									<label for="gizli">Evet</label><br>
									<input type="radio" id="acik" name="gizlilik" value="1" checked>
									<label for="acik">Hayır</label>
									';
								}
							echo '</td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Güncelle"></td>
						</tr>
					</table>
				<form>
				';
			}
			else
			{
				echo 'İçeriği getirirken sorun oldu veya böyle bir içerik yok';
			}
		}
		else
		{
			echo 'HATA';
		}
	}
	
	function kullanicilariListele(){
		echo "<h1>Kayıtlı Kullanıcıların Listesi</h1>";
		require_once("../vt-baglanti.php");
		// sayfalama
		$sorgu3 = $db->query("SELECT COUNT(*) as toplam FROM uyeler") -> fetch(PDO::FETCH_ASSOC);
		
		$sayfa_basi_gosterilecek_icerik_sayisi = 10;
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
		
		$sorgu = $db->query("SELECT uye_id, kullanici_ad, uyelik_durumu FROM uyeler LIMIT $limit, $sayfa_basi_gosterilecek_icerik_sayisi", PDO::FETCH_ASSOC);
		
		echo
		'
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Kullanıcı Adı</th>
						<th>Üyelik Durumu</th>
					</tr>
				</thead>
			<tbody>
		';
		foreach($sorgu as $row)
		{
			echo
			'
				<tr>
					<td>'.$row["uye_id"].'</td>
					<td>'.$row["kullanici_ad"].'</td>
					<td>
					<form action="kullanici-yetkisini-degistir.php" method="POST">
						<input type="radio" name="rutbe-'.$row["uye_id"].'" id="yasakli-'.$row["uye_id"].'" value="0" '.(($row["uyelik_durumu"] == 0) ? "checked" : "").'>
						<label for="yasakli-'.$row["uye_id"].'">Yasaklanmış</label>
						
						<input type="radio" name="rutbe-'.$row["uye_id"].'" id="uye-'.$row["uye_id"].'" value="1" '.(($row["uyelik_durumu"] == 1) ? "checked" : "").'>
						<label for="uye-'.$row["uye_id"].'">Üye</label>
						
						<input type="radio" '.(($_SESSION["uyelik_durumu"] == 2) ? "disabled" : "").' name="rutbe-'.$row["uye_id"].'" id="mod-'.$row["uye_id"].'" value="2" '.(($row["uyelik_durumu"] == 2) ? "checked" : "").'>
						<label for="mod-'.$row["uye_id"].'">Moderatör</label>
						
						<input type="radio" '.(($_SESSION["uyelik_durumu"] == 2) ? "disabled" : "").' name="rutbe-'.$row["uye_id"].'" id="admin-'.$row["uye_id"].'" value="3" '.(($row["uyelik_durumu"] == 3) ? "checked" : "").'>
						<label for="admin-'.$row["uye_id"].'">Admin</label>
					</td>
					<td><input type="submit" value="Yetki Seviyesini Değiştir"></td>
					</form>
				</tr>
			';
		}
		echo
		'
			</tbody>
			</table>
		';
		//sayfaları yazma
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
					<a href=yonetim-paneli.php?q=3&p='.$i.' class="sayfa_numarasi">'.$i.'</a>
				';
			}
		}
		//sayfaları yazma
	}
	
	function silinenYorumlarıListele(){
		require_once("../vt-baglanti.php");
		echo '<h1>Silinen Yorumlar</h1>';
		$sorgu = $db->query("SELECT * FROM yorumlar WHERE durum = 0 ORDER BY tarih DESC", PDO::FETCH_ASSOC);
		
		echo 
		'
			<table class="table">
			<thead>
				<tr>
					<th>Yazıldığı Konu</th>
					<th>Yazar</th>
					<th>Yazar Rütbesi</th>
					<th>Yorum</th>
					<th>Tarih</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
		';
		
		foreach($sorgu as $yorum)
		{
			$yorum_yazar_id = $yorum["yazar_id"];
			
			$sorgu2 = $db->query("SELECT * FROM uyeler WHERE uye_id = $yorum_yazar_id")->fetch(PDO::FETCH_ASSOC);
			$sorgu3 = $db->query("SELECT baslik FROM icerikler WHERE icerik_id = '{$yorum["icerik_id"]}'")->fetch(PDO::FETCH_ASSOC);
			
			echo '<tr class="silik-yorum" yorumid="'.$yorum["yorum_id"].'">';
				echo '<td>'.$sorgu3["baslik"].'</td>';
				echo '<td>'.$sorgu2["kullanici_ad"].'</td>';
				
				switch($sorgu2["uyelik_durumu"])
				{
					case 0:
					echo '<td>Uzaklaştırılmış</td>';
					break;
					
					case 1:
					echo '<td>Üye</td>';
					break;
					
					case 2:
					echo '<td>Moderatör</td>';
					break;
					
					case 3:
					echo '<td>Admin</td>';
					break;
				}
				
				echo '<td width="300px">'.$yorum["yorum"].'</td>';
				echo '<td>'.$yorum["tarih"].'</td>';
				
				if($_SESSION["uyelik_durumu"] == 2)
				{
					if($sorgu2["uyelik_durumu"] == 3)
					{
						echo '<td><p class="silinen-yorum-geri-getir-link" style="display:none;">Geri Getir</p></td>';
					}
					else
					{
						if($sorgu2["uyelik_durumu"] == 2 && $yorum["yazar_id"] != $_SESSION["kullanici_id"])
						{
							echo '<td><p class="silinen-yorum-geri-getir-link" style="display:none;">Geri Getir</p></td>';
						}
						else
						{
							echo '<td><p class="silinen-yorum-geri-getir-link">Geri Getir</p></td>';
						}
					}
				}
				else
				{
					echo '<td><p class="silinen-yorum-geri-getir-link">Geri Getir</p></td>';
				}
			echo '</tr>';
		}
		
		echo '</tbody>';
		echo '</table>';
	}
?>
