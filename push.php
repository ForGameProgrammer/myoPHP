<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
</HEAD>
<BODY>
<?php
//Define your GCM server key here
require "degiskenler.php";

//This function will actually send the notification
function sendNotification($registrationIds, $message) {
	$msg = array
		(
		'duyuru' => $message,
	);

	$fields = array
		(
		'registration_ids' => $registrationIds,
		'data' => $msg,
	);

	$headers = array
		(
		'Authorization: key=' . API_ACCESS_KEYS,
		'Content-Type: application/json',
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
	if ($flag >= 1) {
		echo "Gönderildi...";
	} else {
		echo "Başarısız...";
	}
}

function sendMessageToAll($message) {
	$db = @new mysqli(DB_HOST, DB_KULLANICI, DB_SIFRE, DB_VERITABANI);
	if ($db->connect_error) {
		die("Veri Tabanına Bağlanılamadı...");
	}

	$sql = $db->prepare("SELECT * FROM " . TABLO_CIHAZLAR);
	if (!$sql) {
		die("SQL HATASI!");
	}
	$sql->execute();
	$sonuc = $sql->get_result();

	$gcmRegIds = array();
	while ($query_row = $sonuc->fetch_array()) {
		array_push($gcmRegIds, $query_row[TABLO_CIHAZLAR_CIHAZID]);
	}
	$pushMessage = $message;
	if (isset($gcmRegIds) && isset($pushMessage)) {
		$regIdChunk = array_chunk($gcmRegIds, 1000);
		foreach ($regIdChunk as $RegId) {
			sendNotification($RegId, $pushMessage);
		}

	}
}
//Function to send push notification to all
if (isset($_POST["duyuru"])) {
	sendMessageToAll($_POST["duyuru"]);
} else {
	echo '<FORM method="POST">
        <input type="TEXT" name="duyuru" />
        <input type="SUBMIT" />
    </FORM>';
}

?>
</BODY>
</HTML>