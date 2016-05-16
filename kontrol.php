<?php 
require "degiskenler.php"

function cookieKontrol()
{
	return (isset($_COOKIE[COOKIE1]) && isset($_COOKIE[COOKIE2]) && (@$_COOKIE[COOKIE1]!="") && (@$_COOKIE[COOKIE2]!=""));
}

function dbKontrol()
{
	if (!cookieKontrol()) return false;
	$veritabanidatabase = @new mysqli(DB_HOST,DB_KULLANICI,DB_SIFRE,DB_VERITABANI);
	if($veritabanidatabase->connect_error) die("Veri Tabanı Bağlantı Hatası. (Kontrol)");
	$veritabanidatabase->query("SET NAMES UTF8");
	$sqlsorgucumlesi = $veritabanidatabase->prepare("SELECT * FROM " . TABLO_UYELER . " WHERE " . TABLO_UYELER_ID . " = ? AND " . TABLO_UYELER_SIFRE . " = ?");
	if (!$sqlsorgucumlesi) 
	{
		die("SQL Cümle Hatası. (Kontrol)");
	}
	$sqlsorgucumlesi->bind_param("is",$_COOKIE[COOKIE1],$_COOKIE[COOKIE2]);
	$sqlsorgucumlesi->execute();
	$sqlsorgusonucu = $sqlsorgucumlesi->get_result();
	$sqlsorgusonucurows = $sqlsorgusonucu->num_rows;
	$veritabanidatabase->close();
	return  $sqlsorgusonucurows < 1 ? false : true;
}

function yokEt()
{
	if (!dbKontrol()) {
		die("Giriş Yapmalısınız.")
	}
}



?>