<?php
	session_start();
	
	if(!isset($_SESSION["oturum"]))
	{
		header("Location: anasayfa/index.php");
	}
	else
	{
		session_destroy();
		echo "Çıkış yapıldı, ana sayfaya dönüyor";
		header("Refresh: 3; url=anasayfa/index.php");
	}
?>