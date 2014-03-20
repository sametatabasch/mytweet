<?php
error_reporting( E_ALL );
ob_start();
session_start();
/*site içinde kullanacağım sisteme  göre değişecek değişkenler */
global $veritabanisunucu, $veritabaniadi, $veritabanikullaniciadi, $veritabanikullanicisifre, $anadizin;
$veritabanisunucu         = 'localhost'; //MySQL sunucusu adıdır.
$veritabaniadi            = 'gb_tweet'; //MySQLdeki veritabanı adıdır .
$veritabanikullaniciadi = 'local'; //MySQL kullanıcı adıdır.
$veritabanikullanicisifre = '123456'; //MySQL kullanıcı şifresidir.
$anadizin = '/mytweet/'; //sitenin bulunduğu dizin sonuna / koymayı unutmayın (/dosya/)
?>