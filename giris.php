<?php ob_start();
session_start();
/*ana sayfadan giriş formunu  karşılayan sayfa*/
include_once( 'fonksiyonlar.php' );
baglan();
$email   = string_temizle( $_POST['email'] );
$sifre   = string_temizle( md5( trim( $_POST['sifre'] ) ) );
$hatirla = $_POST['hatirla'];
$sorgu   = mysql_query( "SELECT * FROM kullanicilar WHERE email='$email' AND sifre='$sifre'" );
if ( mysql_num_rows( $sorgu ) < 1 ) {
	HATA( 'Giriş Başarısız' . mysql_error(), $anadizin . 'index.php' );
}
else {
	$veri                        = mysql_fetch_assoc( $sorgu );
	$_SESSION['id']              = $veri['id'];
	$_SESSION['adiSoyadi']       = $veri['adiSoyadi'];
	$_SESSION['email']           = $veri['email'];
	$_SESSION['sifre']           = $veri['sifre'];
	$_SESSION['takipEdenler']    = $veri['takipEdenler'];
	$_SESSION['takipEttikleri']  = $veri['takipEttikleri'];
	$_SESSION['konum']           = $veri['konum'];
	$_SESSION['internetSitesi']  = $veri['internetSitesi'];
	$_SESSION['kisiselBilgiler'] = $veri['kisiselBilgiler'];
	$_SESSION['kayitTarihi']     = $veri['kayitTarihi'];
	if ( $hatirla ) {
		setcookie( 'id', $_SESSION['id'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'adiSoyadi', $_SESSION['adiSoyadi'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'email', $_SESSION['email'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'sifre', $_SESSION['sifre'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'takipEdenler', $_SESSION['takipEdenler'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'takipEttikleri', $_SESSION['takipEttikleri'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'konum', $_SESSION['konum'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'internetSitesi', $_SESSION['internetSitesi'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'kisiselBilgiler', $_SESSION['kisiselBilgiler'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
		setcookie( 'kayitTarihi', $_SESSION['kayitTarihi'], time() + ( 60 * 60 * 24 * 7 * 365 ) );
	}
	mysql_close();
	header( "Location:" . $anadizin . "" );
}
?>