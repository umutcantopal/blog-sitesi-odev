<?php
	try {
		$db = new PDO("mysql:host=localhost;dbname=sistemanalizibir","root","");
	} catch ( PDOException $e ){
		 print $e->getMessage();
	}
	
	$db->query("SET CHARACTER SET utf8");
?>