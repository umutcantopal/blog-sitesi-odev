<?php
	session_start();
	if(!isset($_SESSION["oturum"]))
	{
		echo '
		<html>
			<head>
				<link href="stil/sifirlama.css" type="text/css" rel="stylesheet"/>
				<link href="stil/uye_kayit_stil.css" type="text/css" rel="stylesheet"/>
				<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
			</head>
			<body>
				<div class="uyelik">
					<h4>Kayıt Ol</h4>
					<form method="POST" action="kayit-onay.php">
						<input type="text" name="kullaniciad" placeholder="Kullanıcı Adı" />
						<input type="password" name="kullanicisifre" placeholder="Şifre" />
						<input type="text" name="kullanicieposta" id="kullanicisozlesmeid" placeholder="E-Posta Adresi" />	
						<label><a href="kullanici-sozlesmesi.html">Kullanıcı Sözleşmesini</a> Okudum ve Kabul Ediyorum. <input type="checkbox" name="kullanicisozlesme" /></label>
						<input type="submit" name="kayit_onay_buton" value="Kayıt Ol">
					</form>
				</div>
			</body>
		</html> ';
	}
	else
	{
		header("Location: anasayfa/index.php");
	}
?>