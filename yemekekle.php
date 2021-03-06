<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
<link rel="favicon" href="favicon.ico">
    
    <link href='https://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
    <title>Yemek Ekle</title> 
    <style>
        html,body{
            font-family: 'Dosis', sans-serif;
            background: #00f280;
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
    		background: #00f280;
    		color: #fff;
    		transition: background 1s, color 1s;
    		width: 100%;
            border: 1px solid #000;
    	}
    	button:hover,button:focus{
    		background: #FF9C00;
    		color: #fff;
    	}
    </style>
</head>
<body>
<?php  
require "kontrol.php";

yokEt();
?>
<div>
<img src="kmyomobil.png" width="256" height="256">
<FORM id="formduyuru" method="POST" action="yemek_ekle.php">
    <input type ="DATE"   name="tarih"  placeholder="Tarih"   /><BR/>
	<input type ="TEXT"   name="yemek1" placeholder="Yemek 1" /><BR/>
	<input type ="TEXT"   name="yemek2" placeholder="Yemek 2" /><BR/>
	<input type ="TEXT"   name="yemek3" placeholder="Yemek 3" /><BR/>
	<button type ="SUBMIT">KAYDET</button>
</FORM>
</div>
</body>
</html>