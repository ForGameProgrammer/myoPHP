<?php
require "degiskenler.php";

$db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
if ($db->connect_error) {
	die("Veri Tabanına Bağlanılamadı.");
}
$kadi = $_POST["kadi"];
$sifre = $_POST["sifre"];

$db->query("SET NAMES UTF8");
$tuyeler = TABLO_UYELER;
$tuyekad = TABLO_UYELER_KULLANICI;
$tuyesif = TABLO_UYELER_SIFRE;

$sorgu = $db->prepare("SELECT * FROM $tuyeler WHERE $tuyekad=? AND $tuyesif=?");
if (!$sql) {
	die("SQL Hatası.");
}
$sorgu->bind_param("ss", $kadi, md5($sifre));
$sorgu->execute();
$sonuc = $sorgu->get_result();
if ($sonuc->num_rows < 1) {
	echo "Yanlış Giriş Yaptınız. 5 saniye içinde yönlendirileceksiniz...";
	header("refresh:5;url=index.php");
} else {
	if (isset($_POST["hatirla"])) {
		/* Set cookie to last 1 year */
		setcookie($COOKIE1, $sonuc[TABLO_UYELER_ID], time() + 60 * 60 * 24 * 365);
		setcookie($COOKIE2, md5($sifre), time() + 60 * 60 * 24 * 365);

	} else {
		/* Cookie expires when browser closes */
		setcookie($COOKIE1, $sonuc[TABLO_UYELER_ID], false);
		setcookie($COOKIE2, md5($sifre), false);
	}
	header('Location: index.php');
}
?>