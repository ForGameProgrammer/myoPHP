<!DOCTYPE html>
<HTML>
<Head>
    <link rel="favicon" href="./favicon.ico">
    <title>Program Ekle</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        function Refresh(value) {
        URL = window.location.href.split("?")[0];
        window.location.replace(URL + "?sinif=" + value);
        }
    </script>
    <style>
        html,body{
            font-family: 'Dosis', sans-serif;
            background: #00D24A;
        }

        .bilgi{
            background: #00D24A;
            padding: 10px;
            border: 2px solid black;
            font-size: 32px;
            color: #fff;
            margin-top: 10px;
        }

        .ekle{
            border: 2px solid black;
            background: #00D24A;
            margin-top: 10px;
            padding: 10px;
            font-size: 24px;
        }

        .ekle .row{
            margin-top: 5px;
        }

        .program{
            border: 2px solid #000;
            background: #00D24A;
            margin-top: 10px;
            padding: 10px;
            font-size: 18px;
        }

        .program .siniflar{
            font-size: 24px;

        }

        .program table{
            border: 2px solid #000;
        }

        input,select{
            font-family: 'Dosis', sans-serif;
            border: none;
            padding: 4px;
            margin: 2px;
            border-left: 6px solid #FF9C00;
            outline: none;
            background: #D8D8D8;
            width: 97%;
            transition: background 1s, border-left 1s;
        }

        input:focus,select:focus{
            background: #fff;
            border-left: 2px solid #fff;
        }

        .gonder{
            font-family: 'Dosis', sans-serif;
            border: none;
            font-size: 36px;
            padding: 4px;
            outline: none;
            background: #00D24A;
            color: #fff;
            transition: background 1s, color 1s;
            width: 97%;
            border: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 10px;
        }

        .gonder:hover{
            background: #FF9C00;
            color: #fff;
            border: 1px solid #000;
        }

        .resim{
            text-align: center;
        }
    </style>
</Head>
<Body>
<div class="container bilgi">
<div class="row">
<div class="col-md-12 resim">
<img src="kmyomobil.png" width="256" height="256">
</div>
</div>
<div class="row">
<div class="col-md-12">
<div>
    <p>Durum:
    <?php
require "degiskenler.php";
require "kontrol.php";

yokEt();

$db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
if ($db->connect_error) {
	die("Veritabanı Bağlantı Hatası...");
}

if (isset($_POST["dersekle"])) {
	$dersadi = $_POST["dersadi"];
	$sql = $db->prepare("INSERT INTO " . TABLO_DERSLER . " (" . TABLO_DERSLER_DERS . ") VALUES(?)");
	$sql->bind_param("s", $dersadi);
	$sql->execute();
	echo "$dersadi İsimli Ders Eklendi...";
}

if (isset($_POST["ogretmenekle"])) {
	$ogretmenadi = $_POST["ogretmenadi"];
	$sql = $db->prepare("INSERT INTO " . TABLO_OGRETMENLER . " (" . TABLO_OGRETMENLER_AD . ") VALUES(?)");
	$sql->bind_param("s", $ogretmenadi);
	$sql->execute();
	echo "$ogretmenadi İsimli Öğretmen Eklendi...";
}

if (isset($_POST["sinifekle"])) {
	$ogretim = $_POST["ogretim"];
	$sinifadi = $_POST["sinifadi"];
	$sql = $db->prepare("INSERT INTO " . TABLO_SINIFLAR . " (" . TABLO_SINIFLAR_ADI . ", " . TABLO_SINIFLAR_OGRETIM . ") VALUES(?,?)");
	$sql->bind_param("si", $sinifadi, $ogretim);
	$sql->execute();
	echo "$sinifadi $ogretim. Öğretim Sınıfı Eklendi...";
}

if (isset($_POST["programgonder"])) {
	$sinifID = $_POST["sinif"];
	$sql = $db->prepare("DELETE FROM " . TABLO_PROGRAM . " WHERE " . TABLO_PROGRAM_SINIFID . "=?");
	$sql->bind_param("i", $sinifID);
	$sql->execute();

	for ($n = 1; $n <= 45; $n++) {
		$dersID = $_POST["ders$n"];
		$gun = $n % 5 == 0 ? 5 : $n % 5;
		$derssira = (int) ($n / 5);
		if ($n % 5 != 0) {
			$derssira++;
		}

		$ogretmenID = $_POST["ogretmen$n"];
		$yer = $_POST["yer$n"];
		$sql = $db->prepare("INSERT INTO " . TABLO_PROGRAM . " (" . TABLO_PROGRAM_DERSID . "," . TABLO_PROGRAM_GUN . "," . TABLO_PROGRAM_DERSSIRA . "," . TABLO_PROGRAM_OGRETMENID . "," . TABLO_PROGRAM_SINIFID . "," . TABLO_PROGRAM_YER . ") VALUES(?,?,?,?,?,?)");
		$sql->bind_param("iiiiis", $dersID, $gun, $derssira, $ogretmenID, $sinifID, $yer);
		$sql->execute();
	}
	echo "Ders Programı Düzenlendi";
}

$optiondersler = "";
$sqlders = $db->prepare("SELECT * FROM " . TABLO_DERSLER);
$sqlders->execute();
$sonucders = $sqlders->get_result();
$optiondersler .= "<option value=''></option>";
$denemedersler = array();
while ($dersler = $sonucders->fetch_array()) {
    array_push($denemedersler,$dersler);
	$optiondersler .= "<option value={$dersler['ID']}>{$dersler['ders']}</option>";
}

$optionogretmenler = "";
$sqlogretmenler = $db->prepare("SELECT * FROM " . TABLO_OGRETMENLER);
$sqlogretmenler->execute();
$sonucogretmenler = $sqlogretmenler->get_result();
$optionogretmenler .= "<option value=''></option>";
$denemeogretmenler = array();
while ($ogretmenler = $sonucogretmenler->fetch_array()) {
    array_push($denemeogretmenler,$ogretmenler);
	$optionogretmenler .= "<option value={$ogretmenler['ID']}>{$ogretmenler['ogretmenadi']}</option>";
}
$getsinif = $_GET["sinif"];
if (isset($getsinif)) 
{
    $sqldeneme = $db->prepare("SELECT * FROM " . TABLO_PROGRAM . " WHERE " . TABLO_PROGRAM_SINIFID . "=?");  
    $sqldeneme->bind_param("i",$getsinif);
    $sqldeneme->execute();
    $sonucdeneme = $sqldeneme->get_result();
}

$optionsiniflar = "";
$sqlsiniflar = $db->prepare("SELECT * FROM " . TABLO_SINIFLAR);
$sqlsiniflar->execute();
$sonucsiniflar = $sqlsiniflar->get_result();
while ($siniflar = $sonucsiniflar->fetch_array()) {
    if ($getsinif == $siniflar[TABLO_SINIFLAR_ID]) {
        $optionsiniflar .= "<option value='{$siniflar['ID']}' selected>{$siniflar['sinifadi']} {$siniflar['ogretim']}.Öğretim</option>";
    }
	else
    {
        $optionsiniflar .= "<option value='{$siniflar['ID']}'>{$siniflar['sinifadi']} {$siniflar['ogretim']}.Öğretim</option>";
    } 
}



?>

    </p>
    </div>
</div>
</div>
</div>

<Form method="POST">
    <div class="container ekle">
        <div class="row">
            <div class="col-md-4">
                <input class="giris" type="text" name="dersadi" placeholder="Ders Adı"/>
            </div>
            <div class="col-md-4">
                <input class="giris" type="text" name="ogretmenadi" placeholder="Öğretmen Adı"/>
            </div>
            <div class="col-md-4">
                <input class="giris" type="text" name="sinifadi" placeholder="Bölüm & Sınıf"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input class="gonder" type="submit" name="dersekle" value="DERS EKLE"/>
            </div>
            <div class="col-md-4">
                <input class="gonder" type="submit" name="ogretmenekle" value="ÖĞRETMEN EKLE"/>
            </div>

            <div class="col-md-4">
                <Select class="giris" name="ogretim">
                <option value="1" selected>1. Öğretim</option>
                <option value="2">2. Öğretim</option>
                </Select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <input class="gonder" type="submit" name="sinifekle" value="SINIF EKLE"/>
            </div>
        </div>
    </div>

    <div class="container program">
    <div class="row">
    <div class="col-md-12">
        <div><p class="text-center siniflar"><strong>Sınıf : </strong><Select name="sinif" onChange="Refresh(this.value)"><?php echo $optionsiniflar; ?></p></Select>
            <input type="submit"
                    class="gonder"
                   name="programgonder"
                   value="KAYDET"/>
        </div>
        <Table border="1">
            <Tr>
                <Th></Th>
                <Th><p class="text-center">Pazartesi</p></Th>
                <Th><p class="text-center">Salı</p></Th>
                <Th><p class="text-center">Çarşamba</p></Th>
                <Th><p class="text-center">Perşembe</p></Th>
                <Th><p class="text-center">Cuma</p></Th>
            </Tr>
            <?php
$saat1 = 7;
$saat2 = $saat1 + 1;
for ($i = 1; $i <= 45; $i++) {
	if ($i % 5 == 1) {
		$saat1++;
		$saat2 = $saat1 + 1;
		echo "<Tr><Th>$saat1:15-$saat2:00</Th>";
	}

    $gun = $i % 5 == 0 ? 5 : $i % 5;
    $derssira = (int) ($i / 5);
    if ($i % 5 != 0) $derssira++;
    $denemedersoption = "";
    $denemeogretmenoption ="";
    $denemeyer = "";
    while ($itemdeneme = $sonucdeneme->fetch_array()) 
    {
        if ($itemdeneme[TABLO_PROGRAM_GUN] == $gun && $itemdeneme[TABLO_PROGRAM_DERSSIRA] == $derssira) 
        {
            foreach ($denemedersler as $dersler) 
            {

                if ($dersler[TABLO_DERSLER_ID] == $itemdeneme[TABLO_PROGRAM_DERSID]) 
                {
                    $denemedersadi = $dersler[TABLO_DERSLER_DERS];
                    $denemedersid = $dersler[TABLO_DERSLER_ID];
                    $denemedersoption = "<option value='$denemedersid' selected>$denemedersadi</option>";
                    break;
                }
            }

            foreach ($denemeogretmenler as $ogretmenler) 
            {
                if ($ogretmenler[TABLO_OGRETMENLER_ID] == $itemdeneme[TABLO_PROGRAM_OGRETMENID]) {
                    $denemeogretmenadi = $ogretmenler[TABLO_OGRETMENLER_AD];
                    $denemeogretmenid =  $ogretmenler[TABLO_OGRETMENLER_ID];
                    $denemeogretmenoption = "<option value='$denemeogretmenid' selected>$denemeogretmenadi</option>";
                    break;
                }
            }
            $denemeyer = $itemdeneme[TABLO_PROGRAM_YER];
            break;
        }
    }
	echo "<Td><Select class='giris2' name='ders$i'>";
    echo $denemedersoption;
    echo "$optiondersler</Select>
                      <br/>
                      <Select class='giris2' name='ogretmen$i'>";
     echo $denemeogretmenoption;
    echo "$optionogretmenler</Select>
                      <br/>";
    
        echo "<input type='text' placeholder='Ders Yeri' name='yer$i' value='$denemeyer'/>";
  
    echo "</Td>";

	if ($i % 5 == 0) {
		echo "</Tr>";
	}
}

?>
        </Table>
    </div>
    </div>
    </div>

</Form>

<?php 
$db->close();
?>
</Body>
</HTML>
