<HTML>
    <HEAD>
        <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
    </HEAD>
    <BODY>
        <?php
require "degiskenler.php";

if (isset($_POST["tarih"])) {
	$db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
	if ($db->connect_error) {
		die("Veri Tabanına Bağlanılamadı...");
	}
	$tarih = $_POST["tarih"];
	$yemek1 = $_POST["yemek1"];
	$yemek2 = $_POST["yemek2"];
	$yemek3 = $_POST["yemek3"];

	$sql = $db->prepare("INSERT INTO " . TABLO_YEMEKLER . " (" . TABLO_YEMEKLER_TARIH . "," . TABLO_YEMEKLER_YEMEK1 . "," . TABLO_YEMEKLER_YEMEK2 . "," . TABLO_YEMEKLER_YEMEK3 . ") VALUES(?,?,?,?)");
	if (!$sql) {
		die("SQL HATASI!");
	}
	$sql->bind_param("ssss", $tarih, $yemek1, $yemek2, $yemek3);
	$sql->execute();
	echo "Yemek Başarı ile Eklendi...";
	$db->close();

}

?>
  </BODY>
</HTML>