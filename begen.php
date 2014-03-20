<?php include_once( 'fonksiyonlar.php' );
/*bir durumu beğen butonuna basınca bu sayfa çalışacak*/
$id       = $_POST['id'];
$geri     = $_POST['geri'];
$database = new database();
$database->UPDATE( 'durumlar', array( 'puan' => "(puan+1)" ), "id=$id" );
header( "Location:" . $geri . "" );
?>