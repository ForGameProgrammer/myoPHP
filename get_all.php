<?php
header('Content-Type: text/html; charset=utf-8');
require "degiskenler.php";
$json = array();

$db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
if ($db->connect_error)
{
    $json["basarili"] = 0;
    $json["hata"] = "Veri Tabanına Bağlanılamadı.";
    die(json_encode($json));
}

$db->query("SET NAMES UTF8");

$tablo = TABLO_DUYURU;
$sorgu = $db->prepare("Select * from " . TABLO_DUYURU);
$sorgu->execute();
$sonuc = $sorgu->get_result();
if ($sonuc->num_rows < 1)
{
    $json["basarili"] = 0;
    $json["hata"] = "Gösterilecek Duyuru Yok.";
    echo json_encode($json);
}
else
{
    $json["duyurular"] = array();
    while ($row = $sonuc->fetch_array())
    {
        $duyuru = array();
        $duyuru[TABLO_DUYURU_ID] = $row[TABLO_DUYURU_ID];
        $duyuru[TABLO_DUYURU_MESAJ] = $row[TABLO_DUYURU_MESAJ];
        $duyuru[TABLO_DUYURU_TARIH] = $row[TABLO_DUYURU_TARIH];
        $duyuru[TABLO_DUYURU_YAZAR] = $row[TABLO_DUYURU_YAZAR];
        $duyuru[TABLO_DUYURU_LINK] = $row[TABLO_DUYURU_LINK];
        array_push($json["duyurular"], $duyuru);
    }
    $json["basarili"] = 1;
    echo json_encode($json);
}

?>