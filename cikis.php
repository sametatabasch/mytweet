<?php session_start();
include_once( 'veriler.php' );
/*tüm sessionları ve cookieleri siler*/
session_destroy();
setcookie( 'id', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'adiSoyadi', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'email', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'sifre', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'takipEdenler', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'takipEttikleri', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'konum', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'internetSitesi', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'kisiselBilgiler', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );
setcookie( 'kayitTarihi', '', time() + ( 60 * 60 * 24 * 7 * 365 ) );

header( "Location:" . $anadizin . "" );
?>