<html>
	<head>
		<link href="../stil/sifirlama.css" type="text/css" rel="stylesheet"/>
		<link href="../stil/stil.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>

<?php

		$q = $_GET["q"];
		if($q == "")
		{
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			header("Location: $url");
		}
		
		include("../header.php");
		include("arama-content.php");
?>

	</body>
</html>