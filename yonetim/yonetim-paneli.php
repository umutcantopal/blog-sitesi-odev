<html>
	<head>
		<link href="../stil/sifirlama.css" type="text/css" rel="stylesheet"/>
		<link href="../stil/stil.css" type="text/css" rel="stylesheet"/>
		<link href="../stil/yonetim-paneli-stil.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Yönetim Paneli</title>
		
		<script src="../js/jquery-3.5.0.min.js"></script>
		<script src="../js/yonetim-paneli-ajax.js"></script>
		
		
	</head>
	<body>
		<?php
			session_start();
	
			if(@$_SESSION["oturum"] == true)
			{
				// echo "giriş var";
				if($_SESSION["uyelik_durumu"] == 3 OR $_SESSION["uyelik_durumu"] == 2)
				{
					include("../header.php");
					include("content-yonetim-paneli.php");
				}
				else
				{
					header("Location: ../anasayfa/index.php");
				}
			}
			else
			{
				header("Location: ../anasayfa/index.php");
			}
		?>
	</body>
</html>