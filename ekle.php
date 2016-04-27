<?php
require "degiskenler.php";
?>
<HTML>
<Head>
    <style>
        .kutu1 {
            height: 25%;
            margin: 10px;
            padding: 10px;
            border: 1px solid green;
        }

        .giris {
            padding: 10px;
            margin: 5px;
            position: relative;
        }

        .kutu2 {
            width: 98.7%;
            height: 620px;
            margin: auto;
            padding: 10px;
            background: cyan;
            border: 1px solid green;
        }
    </style>
</Head>
<Body>
<div
    style="width: 99%; height: 10%; background: #cd4eff; margin: auto; line-height: 90px; text-align: center; color: white;">
    <?php

    $db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
    if ($db->connect_error) die("Veritabanı Bağlantı Hatası...");

    if (isset($_POST["dersekle"]))
    {
        $dersadi = $_POST["dersadi"];
        $sql = $db->prepare("INSERT INTO " . TABLO_DERSLER . " (" . TABLO_DERSLER_DERS . ") VALUES(?)");
        $sql->bind_param("s", $dersadi);
        $sql->execute();
        echo "$dersadi İsimli Ders Eklendi...";
    }

    if (isset($_POST["ogretmenekle"]))
    {
        $ogretmenadi = $_POST["ogretmenadi"];
        $sql = $db->prepare("INSERT INTO " . TABLO_OGRETMENLER . " (" . TABLO_OGRETMENLER_AD . ") VALUES(?)");
        $sql->bind_param("s", $ogretmenadi);
        $sql->execute();
        echo "$ogretmenadi İsimli Öğretmen Eklendi...";
    }

    if (isset($_POST["sinifekle"]))
    {
        $ogretim = $_POST["ogretim"];
        $sinifadi = $_POST["sinifadi"];
        $sql = $db->prepare("INSERT INTO " . TABLO_SINIFLAR . " (" . TABLO_SINIFLAR_ADI . ", " . TABLO_SINIFLAR_OGRETIM . ") VALUES(?,?)");
        $sql->bind_param("si", $sinifadi, $ogretim);
        $sql->execute();
        echo "$sinifadi $ogretim. Öğretim Sınıfı Eklendi...";
    }

    $optiondersler = "";
    $sqlders = $db->prepare("SELECT * FROM " . TABLO_DERSLER);
    $sqlders->execute();
    $sonucders = $sqlders->get_result();
    while ($dersler = $sonucders->fetch_array())
    {
        $optiondersler .= "<option value={$dersler['ID']}>{$dersler['ders']}</option>";
    }

    $optionogretmenler = "";
    $sqlogretmenler = $db->prepare("SELECT * FROM " . TABLO_OGRETMENLER);
    $sqlogretmenler->execute();
    $sonucogretmenler = $sqlogretmenler->get_result();
    while ($ogretmenler = $sonucogretmenler->fetch_array())
    {
        $optionogretmenler .= "<option value={$ogretmenler['ID']}>{$ogretmenler['ogretmenadi']}</option>";
    }

    $optionsiniflar = "";
    $sqlsiniflar = $db->prepare("SELECT * FROM " . TABLO_SINIFLAR);
    $sqlsiniflar->execute();
    $sonucsiniflar = $sqlsiniflar->get_result();
    while ($siniflar = $sonucsiniflar->fetch_array())
    {
        $optionsiniflar .= "<option value={$siniflar['ID']}>{$siniflar['sinifadi']}</option>";
    }

    $db->close();

    ?>
</div>

<Form method="POST">
    <Table width="99%" style="margin: 10px">
        <Tr>
            <td width="11%">
                <div style="background: #7bff00;" class="kutu1">
                    <input class="giris" type="text" name="dersadi" placeholder="Ders Adı"/>
                    <br>
                    <input class="giris" type="submit" name="dersekle" value="Ders Ekle"/>
                </div>
            </td>
            <td rowspan="3" width="82%">
                <div class="kutu2">
                    <Table>
                        <Tr>
                            <Th></Th>
                            <Th>Pazartesi</Th>
                            <Th>Salı</Th>
                            <Th>Çarşamba</Th>
                            <Th>Perşembe</Th>
                            <Th>Cuma</Th>
                        </Tr>
                        <Tr>
                            <Th>08:15-09:00</Th>
                            <Td>
                                <Select name="ders1"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen1"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer1">
                            </Td>
                            <Td><Select name="ders10"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen10"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer10"></Td>
                            <Td><Select name="ders20"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen20"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer20"></Td>
                            <Td><Select name="ders30"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen30"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer30"></Td>
                            <Td><Select name="ders40"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen40"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer40"></Td>
                        </Tr>
                        <Tr>
                            <Th>09:15-10:00</Th>
                            <Td><Select name="ders2"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen2"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer2"></Td>
                            <Td><Select name="ders11"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen11"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer11"></Td>
                            <Td><Select name="ders21"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen21"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer21"></Td>
                            <Td><Select name="ders31"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen31"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer31"></Td>
                            <Td><Select name="ders41"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen41"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer41"></Td>
                        </Tr>
                        <Tr>
                            <Th>10:15-11:00</Th>
                            <Td><Select name="ders3"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen3"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer3"></Td>
                            <Td><Select name="ders12"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen12"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer12"></Td>
                            <Td><Select name="ders22"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen22"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer22"></Td>
                            <Td><Select name="ders32"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen32"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer32"></Td>
                            <Td><Select name="ders42"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen42"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer42"></Td>
                        </Tr>
                        <Tr>
                            <Th>11:15-12:00</Th>
                            <Td><Select name="ders4"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen4"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer4"></Td>
                            <Td><Select name="ders13"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen13"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer13"></Td>
                            <Td><Select name="ders23"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen23"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer23"></Td>
                            <Td><Select name="ders33"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen33"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer33"></Td>
                            <Td><Select name="ders43"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen43"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer43"></Td>
                        </Tr>
                        <Tr>
                            <Th>12:15-13:00</Th>
                            <Td><Select name="ders5"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen5"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer5"></Td>
                            <Td><Select name="ders14"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen14"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer14"></Td>
                            <Td><Select name="ders24"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen24"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer24"></Td>
                            <Td><Select name="ders34"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen34"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer34"></Td>
                            <Td><Select name="ders44"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen44"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer44"></Td>
                        </Tr>
                        <Tr>
                            <Th>13:15-14:00</Th>
                            <Td><Select name="ders6"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen6"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer6"></Td>
                            <Td><Select name="ders15"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen15"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer15"></Td>
                            <Td><Select name="ders25"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen25"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer25"></Td>
                            <Td><Select name="ders35"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen35"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer35"></Td>
                            <Td><Select name="ders45"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen45"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer45"></Td>
                        </Tr>
                        <Tr>
                            <Th>14:15-15:00</Th>
                            <Td><Select name="ders7"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen7"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer7"></Td>
                            <Td><Select name="ders16"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen16"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer16"></Td>
                            <Td><Select name="ders26"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen26"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer26"></Td>
                            <Td><Select name="ders36"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen36"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer36"></Td>
                            <Td><Select name="ders46"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen46"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer46"></Td>
                        </Tr>
                        <Tr>
                            <Th>15:15-16:00</Th>
                            <Td><Select name="ders8"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen8"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer8"></Td>
                            <Td><Select name="ders17"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen17"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer17"></Td>
                            <Td><Select name="ders27"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen27"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer27"></Td>
                            <Td><Select name="ders37"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen37"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer37"></Td>
                            <Td><Select name="ders47"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen47"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer47"></Td>
                        </Tr>
                        <Tr>
                            <Th>16:15-17:00</Th>
                            <Td><Select name="ders9"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen9"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer9"></Td>
                            <Td><Select name="ders18"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen18"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer18"></Td>
                            <Td><Select name="ders28"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen28"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer28"></Td>
                            <Td><Select name="ders38"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen38"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer38"></Td>
                            <Td><Select name="ders48"><?php echo $optiondersler; ?></Select><br><Select
                                    name="ogretmen48"><?php echo $optionogretmenler; ?></Select><br><input
                                    type="text" name="yer48"></Td>
                        </Tr>
                    </Table>
                </div>
            </td>
        </Tr>
        <Tr>
            <td>
                <div style="background: #7bff00;" class="kutu1">
                    <input class="giris" type="text" name="ogretmenadi" placeholder="Öğretmen Adı"/>
                    <br>
                    <input class="giris" type="submit" name="ogretmenekle" value="Öğretmen Ekle"/>
                </div>
            </td>
        </Tr>
        <Tr>
            <td>
                <div style="background: #7bff00;" class="kutu1">
                    <input class="giris" type="text" name="sinifadi" placeholder="Sınıf"/>
                    <br>
                    <Select class="giris" name="ogretim">
                        <option value="1" selected>1. Öğretim</option>
                        <option value="2">2. Öğretim</option>
                    </Select>
                    <br>
                    <input class="giris" type="submit" name="sinifekle" value="Sınıf Ekle"/>
                </div>
            </td>
        </Tr>
    </Table>
</Form>


</Body>
</HTML>
