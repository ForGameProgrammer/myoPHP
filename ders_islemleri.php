<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
<link rel="favicon" href="favicon.ico">

    <link href='https://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
    <title>Ders İşlemleri</title>
    <style>
        html,body{
            font-family: 'Dosis', sans-serif;
            background: #00D24A;
            color: #fff;
            font-size: 36px;
        }
        div{
            padding: 20px;
            margin: auto;
            width: 40%;
            text-align: center;
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
require "degiskenler.php";
require "kontrol.php";
yokEt();




?>
</div>
</body>
</html>