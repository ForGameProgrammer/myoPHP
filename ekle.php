<HTML>
<Head>
    <style>
        .kutu1 {
            width: 200px;
            height: 200px;
            margin: 10px;
            padding: 10px;
        }

        input {
            padding: 10px;
            margin: 5px;
            position: relative;
        }
    </style>
</Head>
<Body>
<?php
/*
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    echo "Dead";
}
*/

    print_r($_POST);
?>

<Form method="POST">
    <div style="background: #7bff00;" class="kutu1">
        <input type="text" name="dersadi" placeholder="Ders Adı"/>
        <br>
        <input type="submit" name="dersekle" value="Ders Ekle"/>
        <br>
        <p id="dersyazi"></p>
    </div>
</Form>

</Body>
</HTML>
