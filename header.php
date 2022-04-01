<div id="header">
	<div class="logo">
		<a href="../anasayfa/index.php"><img src="../img/logo.png" width="300px" /></a>
	</div>
	<div class="header-menu">
		<ul>
			<li><a href="../anasayfa/index.php">Ana Sayfa</a></li>
			<li><a href="#">Hakkımızda</a></li>
			<li><a href="#">İletişim</a></li>
		<ul>
	</div>
	<div class="uyelik">
		<?php
			if(isset($_SESSION["oturum"]))
			{
				echo '<div class="avatar">
					<img src="../img/uye_avatar/'.$_SESSION["avatar"].'" width="50px" height="50px" />
					</div>
					<div class="uye_islemleri">
					Merhaba '.$_SESSION["kullanici_ad"].
					'<a href="../profil/profili-duzenle.php">Profili Düzenle</a>
					<a href="../cikis.php">Çıkış Yap</a>
					</div>';
					
					if($_SESSION["uyelik_durumu"] == 2 || $_SESSION["uyelik_durumu"] == 3)
					{
						echo'<div class="yonetim_paneli">
						<a href="../yonetim/yonetim-paneli.php">Yönetim Panelini Aç</a>
						</div>';
					}
			}
			else
			{
				echo '
				<div class="uyelik-sol">
				<form action="../uye-giris.php" method="POST">
				<input type="text" name="kullanici_ad" placeholder="Kullanıcı Adı" class="kullaniciad">
				<input type="password" name="sifre" placeholder="Şifre" class="sifre">
				<input type="submit" value="Giriş Yap" name="giris_buton" class="uye-giris-buton">
				</form>
				</div>
				<div class="uyelik-sag">
				<form action="../uye-kayit.php" method="POST">
				<input type="submit" value="Yeni Kayıt" name="kayit_buton" class="uye-kayit-buton">
				</form>
				</div>';
			}
		?>
	</div>
</div>