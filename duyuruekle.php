<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
<link rel="favicon" href="favicon.ico">

    <title>Duyuru Ekle</title>
<link href='https://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
    <style type="text/css">
        html,body{
            font-family: 'Dosis', sans-serif;
            background: #00D24A;
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
    </style>
</head>
<body>
<?php
require "kontrol.php";

yokEt();
?>
<div>
<img src="kmyomobil.png" width="256" height="256">
<FORM id="formduyuru" method="POST" action="duyuru_ekle.php">
	<input type ="TEXT" name="mesaj" id="mesaj" placeholder="Duyuru Mesajı" /><BR/>
	<input type ="DATE" name="tarih" id="tarih" placeholder="Tarih" /><BR/>
	<input type ="TEXT" name="yazar" id="yazar" placeholder="Yazan Kişi" /><BR/>
	<input type ="TEXT" name="link"  id="link"  placeholder="Link (Boş Olabilir)" /><BR/>
	<button id="gonder">KAYDET</button>
</FORM>
</div>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
	$(document).ready(function () {
		var hatamesaj = "Lütfen Boşlukları Dolduralım...";
        $('#tarih').val(new Date().toDateInputValue());
		$("#gonder").click(function(){
			if($("#mesaj").val().trim() == "") {
				alert(hatamesaj);
			}else if($("#tarih").val().trim() == "") {
				alert(hatamesaj);
			}else if($("#yazar").val().trim() == "") {
				alert(hatamesaj);
			}else{
				$("#formduyuru").submit();
			}
		});
	});
</script>
</body>
</html>