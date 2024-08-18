<?php

	try {

	$db=new PDO("mysql:host=localhost;dbname=udemy;charset=utf8", '', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//echo "Veritabanı bağlantısı başarılı"; 

	} catch (PDOExpception $e) {
	 
	echo $e->getMessage();
}

?>