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

        .giris2 {

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

    if (isset($_POST["programgonder"]))
    {
        $sinifID = $_POST["sinif"];
        $sql = $db->prepare("DELETE FROM " . TABLO_PROGRAM . " WHERE " . TABLO_PROGRAM_SINIFID . "=?");
        $sql->bind_param("i", $sinifID);
        $sql->execute();

        for ($n = 1; $n <= 45; $n++)
        {
            $dersID = $_POST["ders$n"];
            $gun = $n % 5 == 0 ? 5 : $n % 5;
            $derssira = (int)($n / 5);
            if ($n % 5 != 0) $derssira++;
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
    while ($dersler = $sonucders->fetch_array())
    {
        $optiondersler .= "<option value={$dersler['ID']}>{$dersler['ders']}</option>";
    }

    $optionogretmenler = "";
    $sqlogretmenler = $db->prepare("SELECT * FROM " . TABLO_OGRETMENLER);
    $sqlogretmenler->execute();
    $sonucogretmenler = $sqlogretmenler->get_result();
    $optionogretmenler .= "<option value=''></option>";
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
        $optionsiniflar .= "<option value={$siniflar['ID']}>{$siniflar['sinifadi']} {$siniflar['ogretim']}.Öğretim</option>";
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
                    <div>Sınıf : <Select name="sinif"><?php echo $optionsiniflar; ?></Select>
                        <input type="submit"
                               name="programgonder"
                               value="Kaydet"/>
                    </div>
                    <Table border="1">
                        <Tr>
                            <Th></Th>
                            <Th>Pazartesi</Th>
                            <Th>Salı</Th>
                            <Th>Çarşamba</Th>
                            <Th>Perşembe</Th>
                            <Th>Cuma</Th>
                        </Tr>
                        <?php
                        $saat1 = 7;
                        $saat2 = $saat1 + 1;
                        for ($i = 1; $i <= 45; $i++)
                        {
                            if ($i % 5 == 1)
                            {
                                $saat1++;
                                $saat2 = $saat1 + 1;
                                echo "<Tr><Th>$saat1:15-$saat2:00</Th>";
                            }

                            echo "<Td>
                                  <Select class='giris2' name='ders$i'>$optiondersler</Select>
                                  <br/>
                                  <Select class='giris2' name='ogretmen$i'>$optionogretmenler</Select>
                                  <br/>
                                  <input type='text' placeholder='Ders Yeri' name='yer$i'/>
                                  </Td>";

                            if ($i % 5 == 0)
                            {
                                echo "</Tr>";
                            }
                        }

                        ?>
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
