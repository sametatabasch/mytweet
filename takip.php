<?php ob_start();
session_start();
include_once( 'fonksiyonlar.php' );
/*takip işlemlerini bu sayfa düzenlenlenecek
takip edilecek  ve takip  eden kişilerin id leri  post ile gelecek 
*/
$geri              = $_POST['geri'];
$birak             = $_POST['birak'];
$takipEdenId       = $_POST['takipEdenId'];
$takipEdilenId     = $_POST['takipEdilenId'];
$takibiBirakanId   = $_POST['takibiBirakanId'];
$takibiBirakilanId = $_POST['takibiBirakilanId'];
if ( ( empty( $takibiBirakilanId ) ) or ( empty( $takibiBirakanId ) ) or ( empty( $takipEdilenId ) ) or ( empty( $takipEdenId ) ) ) {
	header( "Location:profil.php?" . $geri . "" );
}
if ( $birak == 1 ) {
	baglan();
	$sorgu          = mysql_query( "SELECT takipEttikleri FROM kullanicilar WHERE id=$takibiBirakanId" );
	$sorgu1         = mysql_query( "SELECT takipEdenler FROM kullanicilar WHERE id=$takibiBirakilanId" );
	$takipEttikleri = mysql_result( $sorgu, 0 );
	$takipEdenler   = mysql_result( $sorgu1, 0 );
	$takipEdenler   = explode( ',', $takipEdenler );
	$takipEttikleri = explode( ',', $takipEttikleri );
	$bul            = array_search( $takibiBirakilanId, $takipEttikleri );
	unset( $takipEttikleri[$bul] );
	$bul1 = array_search( $takibiBirakanId, $takipEdenler );
	unset( $takipEdenler[$bul1] );
	$yazTakipEttikleri;
	foreach ( $takipEttikleri as $takipEdilenId ) {
		if ( empty( $yazTakipEttikleri ) ) {
			$yazTakipEttikleri = $takipEdilenId;
		}
		else {
			$yazTakipEttikleri = $yazTakipEttikleri . ',' . $takipEdilenId;
		}
	}
	$yazTakipedenler;
	foreach ( $takipEdenler as $takipEdenId ) {
		if ( empty( $yazTakipedenler ) ) {
			$yazTakipedenler = $takipEdenId;
		}
		else {
			$yazTakipedenler = $yazTakipedenler . ',' . $takipEdenId;
		}
	}
	$sorgu = mysql_query( "UPDATE  kullanicilar SET takipEttikleri='$yazTakipEttikleri' WHERE id=$takibiBirakanId" );
	$sorgu = mysql_query( "UPDATE  kullanicilar SET takipEdenler='$yazTakipEdenler' WHERE id=$takibiBirakilanId" );
	header( "Location:profil.php?" . $geri . "" );
}
else {
	baglan();
	$sorgu          = mysql_query( "SELECT takipEttikleri FROM kullanicilar WHERE id=$takipEdenId" );
	$sorgu1         = mysql_query( "SELECT takipEdenler FROM kullanicilar WHERE id=$takipEdilenId" );
	$takipEttikleri = mysql_result( $sorgu, 0 );
	$takipEdenler   = mysql_result( $sorgu1, 0 );
	if ( empty( $takipEttikleri ) ) {
		$takipEttikleri = $takipEdilenId;
	}
	else {
		$takipEttikleri = $takipEttikleri . ',' . $takipEdilenId;
	}
	if ( empty( $takipEdenler ) ) {
		$takipEdenler = $takipEdenId;
	}
	else {
		$takipEdenler = $takipEdenler . ',' . $takipEdenId;
	}
	$sorgu = mysql_query( "UPDATE  kullanicilar SET takipEttikleri='$takipEttikleri' WHERE id=$takipEdenId" );
	$sorgu = mysql_query( "UPDATE  kullanicilar SET takipEdenler='$takipEdenler' WHERE id=$takipEdilenId" );
	header( "Location:profil.php?" . $geri . "" );
}
?>