<?php
require "degiskenler.php";
$json = array();

$db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
if ($db->connect_error)
{
    $json["basarili"] = 0;
    $json["hata"] = "Veri Tabanına Bağlanılamadı.";
    die(json_encode($json));
}


$tablo = DB_TABLO;
$sorgu = $db->prepare("Select * from $tablo");
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
        $duyuru["id"] = $row["id"];
        $duyuru["mesaj"] = $row["mesaj"];
        $duyuru["tarih"] = $row["tarih"];
        $duyuru["yazar"] = $row["yazar"];
        array_push($json["duyurular"], $duyuru);
    }
    $json["basarili"] = 1;
    echo json_encode($json);
}

?>