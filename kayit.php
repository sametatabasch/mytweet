<?php ob_start();
session_start(); ?>
<html>
<head>
	<title>Gençbilişim.net- Tweeter gibi :) </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="CSS/sıfırla.css" rel="stylesheet" type="text/css" />
	<link href="CSS/still.css" rel="stylesheet" type="text/css" />
	<meta content="index, follow" name="robots" />
	<meta content="Gençbilişim.net" name="generator" />
	<meta content="Samet ATABAŞ" name="owner" />
	<meta content="Gençbilişim.net Tum hakki saklidir." name="copyright" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<!--bu genişliğin cihaz genişligi ile aynı olmasını sağlıyor -->
</head>
<body>
<?php
/*
yeni  üye kayıt etmek için... 
*/
include_once( 'fonksiyonlar.php' ); //fonksiyonları kullanmak  için

$kayitTarihi = date( 'Y-m-d G:i:s' );
$adiSoyadi = $_POST['adiSoyadi'];
$email = string_temizle( trim( $_POST['email'] ) );
$sifre = string_temizle( md5( trim( $_POST['sifre'] ) ) );
if ( empty( $adiSoyadi ) or empty( $email ) or empty( $sifre ) ) {
	HATA( 'Boş var', $anadizin );
}
if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
	HATA( 'geçersiz email', $anadizin );
}
//$varmi=mysql_query("SELECT * FROM kullanicilar WHERE email='$email'");
//if(mysql_num_rows($varmi)) {HATA('email kullanılıyor',$anadizin);}
$arr = array(
		'adiSoyadi'       => $adiSoyadi,
		'email'           => $email,
		'sifre'           => $sifre,
		'takipEdenler'    => $takipEdenler,
		'takipEttikleri'  => $takipEttikleri,
		'konum'           => $konum,
		'internetSitesi'  => $internetSitesi,
		'kisiselBilgiler' => $kisiselBilgiler,
		'kayitTarihi'     => $kayitTarihi
);
$database = new database();
if ( $database->INSERT( 'kullanicilar', $arr ) ) {
	header( "Location:" . $anadizin . "" );
}
?>
</body>
</html>