<html>
	<head>
		<link href="../stil/sifirlama.css" type="text/css" rel="stylesheet"/>
		<link href="../stil/stil.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<script src="../js/jquery-3.5.0.min.js"></script>
		<script src="../js/yorum-yaz-ajax.js"></script>
		
		<link href="../stil/makale-stil.css" type="text/css" rel="stylesheet"/>
	</head>
	<body>
		<?php
			session_start();
			include("../header.php");
			include("konu-content.php");
			include("../footer.php");
		?>
	</body>
</html>