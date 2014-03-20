<?php
/*
index sayfası 
fonksiyonlar sayfasını include edecek . (veri tabanı  bağlantısı ve sabit değişkenler ayrı bir sayfada tutulabilir.) 
header content ve footer .php  sayfalarını  include edecek. 
kullanıcı  giriş yaptığında ve yapmadığında twitter gibi  farklı  sayfalar olacak 
*/
include_once( 'fonksiyonlar.php' );
?>

<?php include_once( 'header.php' ) ?>
<?php include_once( 'content.php' ) ?>
<?php include_once( 'footer.php' ) ?>
