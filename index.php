<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
<link rel="favicon" href="favicon.ico">

    <link href='https://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
    <title>Anasayfa</title>
    <style>
        html,body{
            font-family: 'Dosis', sans-serif;
            background: #00D24A;
            font-size: 36px;
        }
        div{
            padding: 20px;
            margin: auto;
            width: 40%;
            text-align: center;
        }
        input{
            font-family: 'Dosis', sans-serif;
            border: none;
            font-size: 36px;
            padding: 10px;
            margin: 10px;
            border-left: 6px solid #FF9C00;
            outline: none;
            background: #D8D8D8;
            width: 97%;
            transition: background 1s, border-left 1s;
        }
        input:focus{
            border-left: 6px solid #fff;
            background: #fff;
        }
        button{
            font-family: 'Dosis', sans-serif;
            border: none;
            font-size: 48px;
            padding: 10px;
            margin: 10px;
            outline: none;
            background: #00D24A;
            color: #fff;
            transition: background 1s, color 1s;
            width: 100%;
            border: 1px solid #000;
        }
        button:hover{
            background: #FF9C00;
            color: #fff;
        }
        h1{
            color: #fff;
        }
    </style>
</head>
<body>
<div>
<img src="kmyomobil.png" width="256" height="256">
<?php  
require "kontrol.php";

if (kontrolEt()) 
{
?>

<h1>
Hoşgeldiniz
</h1>
<p><a href="logout.php">Çıkış</a></p>

<?php
}else
{
?>
<FORM id="formduyuru" method="POST" action="onay.php">
	<input type ="TEXT"        name="kadi"    placeholder="Kullanıcı Adı" /><BR/>
    <input type ="PASSWORD"    name="sifre"   placeholder="Şifre" /><BR/>
	<label>
    <input type ="CHECKBOX"    name="hatirla" style="" />Beni Hatırla
    </label>
    <BR/>
	<button type ="SUBMIT">GİRİŞ</button>
</FORM>
<?php 
}
?>
</div>
</body>
</html>