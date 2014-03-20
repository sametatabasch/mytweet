<?php
error_reporting( 0 );
ob_start();
session_start();
/*site içinde kullanacağım sisteme  göre değişecek değişkenler */
global $veritabanisunucu, $veritabaniadi, $veritabanikullaniciadi, $veritabanikullanicisifre, $anadizin;
$veritabanisunucu         = 'localhost'; //MySQL sunucusu adıdır.
$veritabaniadi            = 'gb_tweet'; //MySQLdeki veritabanı adıdır .
$veritabanikullaniciadi   = 'root'; //MySQL kullanıcı adıdır.
$veritabanikullanicisifre = ''; //MySQL kullanıcı şifresidir.
$anadizin                 = '/tweet/'; //sitenin bulunduğu dizin sonuna / koymayı unutmayın (/dosya/)
?>