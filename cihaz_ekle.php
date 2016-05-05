<?php  
require "degiskenler.php";

if (isset($_POST["cihaz"])) {
	$db = @new mysqli(DB_HOST,DB_KULLANICI,DB_SIFRE,DB_VERITABANI);
	if ($db->connect_error) {
		die("Veri Tabanına Bağlanılamadı...");
	}

	$cihaz = $_POST["cihaz"];

	$sql = $db->prepare("SELECT * FROM " . TABLO_CIHAZLAR . " WHERE " . TABLO_CIHAZLAR_CIHAZID . "=?");
	if (!$sql) {
		die("SQL HATASI!");
	}
	$sql->bind_param("s",$cihaz);
	$sql->execute();
	$sonuc=$sql->get_result();
	if ($sonuc->num_rows > 0) {
		die("Zaten Var");
	}

	$sql = $db->prepare("INSERT INTO " . TABLO_CIHAZLAR . " (" . TABLO_CIHAZLAR_CIHAZID . ") VALUES(?)");
	if (!$sql) {
		die("SQL HATASI!");
	}

	$sql->bind_param("s",$cihaz);
	$sql->execute();

	$db->close();
}
?>