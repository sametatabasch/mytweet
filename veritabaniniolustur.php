<?php include_once( 'veriler.php' );
$baglanti = mysql_connect( $veritabanisunucu, $veritabanikullaniciadi, $veritabanikullanicisifre );
mysql_set_charset( 'utf8', $baglanti );
$sorgu = mysql_query( " CREATE DATABASE IF NOT EXISTS $veritabaniadi DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci" );
if ( ! $sorgu ) {
	echo 'create' . mysql_error() . '<br>';
}
$db    = mysql_select_db( $veritabaniadi, $baglanti );
$sorgu = mysql_query( "CREATE TABLE IF NOT EXISTS durumlar (
  id int(11) NOT NULL AUTO_INCREMENT,
  yazanId int(11) NOT NULL,
  tarih datetime NOT NULL,
  puan int(11) NOT NULL,
  metin text NOT NULL,
  yanitlananId int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14" );
if ( ! $sorgu ) {
	echo 'durumlar' . mysql_error() . '<br>';
}
$sorgu = mysql_query( "CREATE TABLE IF NOT EXISTS kullanicilar (
  id int(11) NOT NULL AUTO_INCREMENT,
  adiSoyadi text NOT NULL,
  email varchar(50) NOT NULL,
  sifre text NOT NULL,
  takipEdenler longtext NOT NULL,
  takipEttikleri longtext NOT NULL,
  konum text NOT NULL,
  internetSitesi text NOT NULL,
  kisiselBilgiler longtext NOT NULL,
  kayitTarihi datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 " );
if ( ! $sorgu ) {
	echo 'kullanicilar' . mysql_error() . '<br>';
}
header( "Location:" . $anadizin . "" );

?>