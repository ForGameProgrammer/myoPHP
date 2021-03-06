<?php
header('Content-Type: text/html; charset=utf-8');
require "degiskenler.php";



//Array json için
$json = array();

//Dersler
//Sınıflar
//Öğretmenler
//Program

$veritabani = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
if ($veritabani->connect_error)
{
    $json["basarili"] = 0;
    $json["hata"] = "Veri Tabanına Bağlanılamadı.";
    die(json_encode($json));
}

$sorgu = $veritabani->prepare("SELECT * FROM " . TABLO_DERSLER);
if (!$sorgu) {
    die("hata");
}
$sorgu ->execute();
$sonuc = $sorgu->get_result();
$json["dersler"] = array();
while ($row = $sonuc->fetch_array())
{
    $ders = array();
    $ders[TABLO_DERSLER_ID]   = $row[TABLO_DERSLER_ID];
    $ders[TABLO_DERSLER_DERS] = $row[TABLO_DERSLER_DERS];
    array_push($json["dersler"], $ders);
}

$sorgu = $veritabani->prepare("SELECT * FROM " . TABLO_SINIFLAR);
$sorgu ->execute();
$sonuc = $sorgu->get_result();
$json["siniflar"] = array();
while ($row = $sonuc->fetch_array())
{
    $sinif = array();
    $sinif[TABLO_SINIFLAR_ID]      = $row[TABLO_SINIFLAR_ID];
    $sinif[TABLO_SINIFLAR_ADI]     = $row[TABLO_SINIFLAR_ADI];
    $sinif[TABLO_SINIFLAR_OGRETIM] = $row[TABLO_SINIFLAR_OGRETIM];
    array_push($json["siniflar"], $sinif);
}

$sorgu = $veritabani->prepare("SELECT * FROM " . TABLO_OGRETMENLER);
$sorgu ->execute();
$sonuc = $sorgu->get_result();
$json["ogretmenler"] = array();
while ($row = $sonuc->fetch_array())
{
    $ogretmen = array();
    $ogretmen[TABLO_OGRETMENLER_ID] = $row[TABLO_OGRETMENLER_ID];
    $ogretmen[TABLO_OGRETMENLER_AD] = $row[TABLO_OGRETMENLER_AD];
    array_push($json["ogretmenler"], $ogretmen);
}

$sorgu = $veritabani->prepare("SELECT * FROM " . TABLO_PROGRAM);
$sorgu ->execute();
$sonuc = $sorgu->get_result();
$json["program"] = array();
while ($row = $sonuc->fetch_array())
{
    $prog = array();
    $prog[TABLO_PROGRAM_ID]         = $row[TABLO_PROGRAM_ID];
    $prog[TABLO_PROGRAM_DERSID]     = $row[TABLO_PROGRAM_DERSID];
    $prog[TABLO_PROGRAM_GUN]        = $row[TABLO_PROGRAM_GUN];
    $prog[TABLO_PROGRAM_DERSSIRA]   = $row[TABLO_PROGRAM_DERSSIRA];
    $prog[TABLO_PROGRAM_OGRETMENID] = $row[TABLO_PROGRAM_OGRETMENID];
    $prog[TABLO_PROGRAM_SINIFID]    = $row[TABLO_PROGRAM_SINIFID];
    $prog[TABLO_PROGRAM_YER]        = $row[TABLO_PROGRAM_YER];
    array_push($json["program"], $prog);
}

$veritabani->close();
$json["basarili"] = 1;
echo json_encode($json);

?>

