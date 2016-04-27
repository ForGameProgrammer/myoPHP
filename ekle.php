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

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {

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

    }

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
