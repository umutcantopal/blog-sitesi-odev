<html>
	<head>
		<link href="../stil/sifirlama.css" type="text/css" rel="stylesheet"/>
		<link href="../stil/stil.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<?php
			session_start();
	
			if(@$_SESSION["oturum"] == true)
			{
				// echo "giriş var";
				include("../header.php");
				include("content-profil-duzenle.php");
				include("../footer.php");
			}
			else
			{
				header("Location: ../anasayfa/index.php");
			}
		?>
	</body>
</html>