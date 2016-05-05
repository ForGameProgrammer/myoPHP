<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
</HEAD>
<BODY>
<?php  
require "degiskenler.php";

if (isset($_POST["mesaj"])) {
	$db = @new mysqli(DB_HOST,DB_KULLANICI,DB_SIFRE,DB_VERITABANI);
	if ($db->connect_error) {
		die("Veri Tabanına Bağlanılamadı...");
	}

	$mesaj = $_POST["mesaj"];
	$tarih = $_POST["tarih"];
	$yazar = $_POST["yazar"];
	$link  = $_POST["link"];

	$sql = $db->prepare("INSERT INTO " . TABLO_DUYURU . " (" . TABLO_DUYURU_MESAJ . "," . TABLO_DUYURU_TARIH . "," . TABLO_DUYURU_YAZAR ."," . TABLO_DUYURU_LINK . ") VALUES(?,?,?,?)");
	if (!$sql) {
		die("SQL HATASI!");
	}

	$sql->bind_param("ssss",$mesaj,$tarih,$yazar,$link);
	$sql->execute();
	echo "Duyurunuz Başarı ile Eklendi...";
	$db->close();

	//This function will actually send the notification
function sendNotification($registrationIds, $message)
{
    $msg = array
    (
        'duyuru' => $message,
    );

    $fields = array
    (
        'registration_ids' => $registrationIds,
        'data' => $msg
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEYS,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($result);

    $flag = $res->success;
    if($flag >= 1){
        echo "Duyuruları için Bildirimler Gönderildi...";
    }else{
        echo "Bildirimler Gönderilemedi...";
    }
}

function sendMessageToAll($message){
	$vt = @new mysqli(DB_HOST,DB_KULLANICI,DB_SIFRE,DB_VERITABANI);
    $ssqqll = $vt->prepare("SELECT * FROM " . TABLO_CIHAZLAR);
    if (!$ssqqll) {
        die("SQL HATASI!");
    }
    $ssqqll->execute();
    $sonuc=$ssqqll->get_result();

    $gcmRegIds = array();
    while($query_row = $sonuc->fetch_array()) {
         array_push($gcmRegIds, $query_row[TABLO_CIHAZLAR_CIHAZID]);
    }
    $pushMessage = $message;
    if(isset($gcmRegIds) && isset($pushMessage)) {
        $regIdChunk=array_chunk($gcmRegIds,1000);
        foreach($regIdChunk as $RegId){
            sendNotification($RegId, $pushMessage);
        }

    }
}
sendMessageToAll($_POST["mesaj"]);
	
}
?>
</BODY>
</HTML>