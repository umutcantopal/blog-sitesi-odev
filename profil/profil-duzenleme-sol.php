<div class="content-icerik">
	<div class="profilduzenlediv">
		<h3 style="color:#ce1c4a; font-weight:bold;">Profil Resmini Güncelle</h3>
		<form method="POST" action="../dosya-yukle.php" enctype="multipart/form-data">
			<input type="file" name="dosya" />
			<input type="submit" name="yolla" value="Yolla" />
		</form>
	</div>
	
	<div class="profilduzenlediv">
		<h3 style="color:#ce1c4a; font-weight:bold;">Şifre Değiştir</h3>
		<form method="POST" action="../sifre-degistir.php">
			Eski Şifreniz:<input type="password" name="eskisifre" class="sifredegis" />
			Yeni Şifreniz<input type="password" name="yenisifre" class="sifredegis" />
			Yeni Şifreniz Tekrar<input type="password" name="yenisifretekrar" class="sifredegis" />
			<input type="submit" name="degistir" value="Değiştir" />
		</form>
	</div>
</div>