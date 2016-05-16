<?php
require "degiskenler.php";

$db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
if ($db->connect_error) {
	die("Veri Tabanına Bağlanılamadı.");
}
$kadi = $_POST["kadi"];
$sifre = $_POST["sifre"];

$db->query("SET NAMES UTF8");

$sorgu = $db->prepare("SELECT * FROM " . TABLO_UYELER . " WHERE " . TABLO_UYELER_KULLANICI . " = ? AND " . TABLO_UYELER_SIFRE . " = ?");
if (!$sorgu) {
	die("SQL Hatası.");
}
//Değişkenleri Gönderiyoruz şifre MD5 ile
$sorgu->bind_param("ss", $kadi, md5($sifre));
//SQL Çalıştır
$sorgu->execute();
//Sonucu Al
$sonuc = $sorgu->get_result();
//Eğer Gelen Sonuçtaki Satır Satısı 1'den Küçükse
if ($sonuc->num_rows < 1) {
	$db->close();
	//5 Sn İçinde Yönlendir index.php
	header("refresh:5;url=index.php");
	echo "Yanlış Giriş Yaptınız. 5 saniye içinde yönlendirileceksiniz...";
} 
else 
{
	//Sonucun 1 Satırını Al (Gelmesi Gereken 1 Satır)
	$sonuc1 = $sonuc->fetch_array();
	//Beni Hatırla İşaretli İse
	if (isset($_POST["hatirla"])) {
		//1 Yıllığına Cookie Ayarla
		setcookie(COOKIE1, $sonuc1[TABLO_UYELER_ID], time() + 60 * 60 * 24 * 365);
		setcookie(COOKIE2, md5($sifre), time() + 60 * 60 * 24 * 365);

	} else {
		//Tarayıcı Kapanana Kadar Cookie Ayarla
		setcookie(COOKIE1, $sonuc1[TABLO_UYELER_ID], false);
		setcookie(COOKIE2, md5($sifre), false);
	}
	$db->close();
	//index.php ye Yönlendir
	header('Location: index.php');
}
?>