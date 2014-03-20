<?php include_once( 'fonksiyonlar.php' );
/*durum paylaşmak  için .post metodu  ile durum ve yazanId yanıtlananId değerlerini  alıyor*/
$database = new database();
if ( empty( $_POST['durum'] ) or $_POST['durum'] == '' or empty( $_POST['yazanId'] ) ) {
	header( "Location:" . $_POST['geri'] );
	exit();
}
if ( empty( $_POST['yanitlananId'] ) ) {
	$yanitlananId = 0;
}
else {
	$yanitlananId = $_POST['yanitlananId'];
	/*include('PHPMailer_5.2.1/class.phpmailer.php');
	$mail= new PHPmailer;
	
	$body='mesaj içeriği html';
	
	$mail->CharSet='utf-8';
	$mail->SetFrom('sametatabasch@gmail.com','Samet ATABAŞ');
	
	$adress=$database->GETRESULT("SELECT email FROM kullanicilar WHERE id=$yanitlananId");
	$mail->AddAddress($adress);
	$mail->Subject='size yeni bir ileti var';
	$mail->AltBody='altbody';
	$mail->MsgHTML($body);
	if($mail->Send()) {
		echo 'Mesaj Gönderildi';
	}else {
		echo 'HAta oluştu mesaj gönderilemedi';
	}*/

	$kime    = $database->GETRESULT( "SELECT email FROM kullanicilar WHERE id=$yanitlananId" );
	$yazan   = $database->GETRESULT( "SELECT adiSoyadi FROM kullanicilar WHERE id=$yazanId" );
	$konu    = $yazan . ' size bir şeyler yazdı';
	$mesaj   = '
    <html>
        <head>
            <title>' . $yazan . ' size bir şeyler yazdı</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        </head>
        <body>
            <br>
            <br>
            ' . $yazan . ':<br>' . $metin . '<br> yanıtlamak için ve yanıtı görmek için linke tıklayın.<br>
            <a href="http://' . $_SERVER['HTTP_HOST'] . $anadizin . '/profil.php?id=' . $yanitlananId . '">http://' . $_SERVER['HTTP_HOST'] . '/profil.php?id=' . $yanitlananId . '</a>
        </body>
    </html>
    ';
	$headers = 'From:Özlem Yağlı' . "\r\n" . 'Content-type: text/html;charset=utf-8' . "\r\n";
	mail( $kime, $konu, $mesaj, $headers );
}
$veriler = array(
		'yazanId'      => $_POST['yazanId'],
		'tarih'        => date( 'Y-m-d G:i:s' ),
		'puan'         => 0,
		'metin'        => string_temizle( $_POST['durum'] ),
		'yanitlananId' => $yanitlananId,
);

if ( $database->INSERT( 'durumlar', $veriler ) ) {
	mysql_close();
	header( "Location:" . $anadizin . "" );
}
?>htmlspecialchars($string));
}