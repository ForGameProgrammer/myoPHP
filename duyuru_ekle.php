<?php  
require "degiskenler.php";

if (isset($_POST["mesaj"])) {
	$db = @new mysqli(DB_HOST,DB_KULLANICI,DB_SIFRE,DB_VERITABANI);
	if ($db->connect_error) {
		die("Veri Tabanına Bağlanılamadı...");
	}

	$mesaj = $_POST["mesaj"];
	$tarih = $_POST["tarih"];
	$yazar = $_POST["yazar"];
	$link  = $_POST["link"];

	$sql = $db->prepare("INSERT INTO " . TABLO_DUYURU . " (" . TABLO_DUYURU_MESAJ . "," . TABLO_DUYURU_TARIH . "," . TABLO_DUYURU_YAZAR ."," . TABLO_DUYURU_LINK . ") VALUES(?,?,?,?)");
	if (!$sql) {
		die("SQL HATASI!");
	}

	$sql->bind_param("ssss",$mesaj,$tarih,$yazar,$link);
	$sql->execute();
	echo "Duyurunuz Başarı ile Eklendi...";

	$db->close();

}
?>