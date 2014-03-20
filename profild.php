<?php include_once( 'fonksiyonlar.php' );
/*profil  bilgileri ve şifre  değişimi  bu  sayfadan  düzenlenecek */
$id    = $_POST['id'];
$sifre = string_temizle( trim( $_POST['sifre'] ) );
$email = string_temizle( trim( $_POST['email'] ) );
if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
	HATA( 'geçersiz email', $anadizin );
}
$database = new database();
$veriler  = array(
		'adiSoyadi'       => "'" . string_temizle( trim( $_POST['adiSoyadi'] ) ) . "'",
		'email'           => "'" . $email . "'",
		'konum'           => "'" . string_temizle( trim( $_POST['konum'] ) ) . "'",
		'internetSitesi'  => "'" . string_temizle( trim( $_POST['internetSitesi'] ) ) . "'",
		'kisiselBilgiler' => "'" . string_temizle( trim( $_POST['kisiselBilgiler'] ) ) . "'",
);
if ( empty( $sifre ) or $sifre == '' ) {
	if ( $database->UPDATE( 'kullanicilar', $veriler, "id=$id" ) ) {
		header( "location:" . $anadizin . "profil.php" );
	}
}
else {
	$veriler['sifre'] = "'" . md5( $sifre ) . "'";
	if ( $database->UPDATE( 'kullanicilar', $veriler, "id=$id" ) ) {
		header( "location:" . $anadizin . "profil.php" );
	}
}
?>