<?php session_start();
ob_start();
include( 'veriler.php' );
error_reporting( E_ALL );
//---------------veri  tabanı bağlantısı--------------
/**
 *veritabanı işlemlerini yapmak için kullanılacak sınıf
 *
 * @author Samet ATABAŞ
 */
class database {
	/**
	 *kullanılacak değişkenler
	 *
	 * @var string $sunucu
	 * @var string $kullaniciAdi
	 * @var string $sifre
	 * @var string $veritabaniAdi
	 * @var bool   $connection
	 * @var bool   $selectDb
	 */
	private $sunucu = 'localhost';
	private $kullaniciAdi = 'root';
	private $sifre = '';
	private $veritabaniAdi = 'gb_tweet';
	private $connection;
	private $selectDb;

	/**
	 *veri tabanı bağlantısını kuracak fonksiyon
	 *
	 * @param string $charSet
	 *
	 * @return bool
	 */
	private function baglan( $charSet = 'utf8' ) {
		$this->connection = mysql_connect( $this->sunucu, $this->kullaniciAdi, $this->sifre );
		if ( $this->connection ) {
			mysql_set_charset( $charSet, $this->connection );
			$this->selectDb = mysql_select_db( $this->veritabaniAdi, $this->connection );
			if ( ! $this->selectDb ) {
				die( 'HATA : Veri tabanı seçilemedi' . mysql_error() );
			}
		}
		else {
			die( 'HATA : Bağlantı kurulamadı' . mysql_error() );
		}
	}

	/**
	 * Veritabanı bağlantısını sonlandıran fonksiyon
	 *
	 * @return void
	 */
	private function baglantiyisonlandir() {
		mysql_close( $this->connection );
	}

	function __construct( $charSet = 'utf8' ) {
		$this->baglan( $charSet );
	}

	function __destruct() {
		$this->baglantiyisonlandir();
	}

	/**
	 * Mysql SELECT işlemini yapacak fonksiyon
	 *
	 * @param string $alanlar
	 * @param string $tablo
	 * @param string $kosul
	 * @param string $ek
	 *
	 * @return array
	 */
	public function SELECT( $alanlar, $tablo, $kosul, $ek ) {
		$sql = "SELECT $alanlar FROM $tablo ";
		if ( ! empty( $kosul ) ) {
			$sql .= "WHERE " . $kosul;
		}
		if ( ! empty( $ek ) ) {
			$sql .= $ek;
		}
		$sorgu = mysql_query( $sql );
		if ( ! $sorgu ) {
			die( 'Sorgu çalıştırılamadı' . mysql_error() );
		}
		return mysql_fetch_array( $sorgu );
	}

	/**
	 * Mysql UPDATE işlemini yapacak fonksiyon
	 *
	 * @param string $tablo
	 * @param array  $veriler
	 * @param string $kosul
	 *
	 * @return bool
	 */
	public static function UPDATE( $tablo, $set = array(), $kosul ) {
		$s;
		foreach ( $set as $alan => $veri ) {
			if ( empty( $s ) ) {
				$s = $alan . '=' . $veri;
			}
			else {
				$s .= ',' . $alan . '=' . $veri;
			}
		}
		$sql   = "UPDATE $tablo SET $s WHERE $kosul";
		$sorgu = mysql_query( $sql );
		if ( $sorgu ) {
			return true;
		}
		else {
			echo mysql_error();
			return false;
		}
	}

	/**
	 * Mysql INSERT INTO işlemini yapacak fonksiyon
	 *
	 * @param string $tablo
	 * @param array  $arr [alan]=veri
	 *
	 * @return bool
	 */
	public static function INSERT( $tablo, $arr = array() ) {
		if ( is_array( $arr ) ) {
			foreach ( $arr as $alan => $veri ) {
				$alanlar[] = $alan;
				$veriler[] = $veri;
			}
			$a;
			foreach ( $alanlar as $alan ) {
				if ( empty( $a ) ) {
					$a = $alan;
				}
				else {
					$a .= ',' . $alan;
				}
			}
			$v;
			foreach ( $veriler as $veri ) {
				if ( empty( $v ) ) {
					$v = '\'' . $veri . '\'';
				}
				else {
					$v .= ',\'' . $veri . '\'';
				}
			}
			$query = "INSERT INTO $tablo($a) VALUES($v) ";
			$sql   = mysql_query( $query );
			if ( $sql ) {
				return true;
			}
			else {
				if ( mysql_errno() == 1062 ) {
					HATA( 'Email adresi kullanılıyor' . $anadizin, $anadizin );
					return false;
				}
				else {
					echo mysql_error();
					return false;
				}
			}
		}
		else {
			return HATA( 'Veriler Yanlış Girilmiş Lütfen Verileri Kontrol Ediniz' . $anadizin );
		}
	}

	/**
	 * Mysql num rows işlemini yapacak fonksiyon
	 *
	 * @param string $sql
	 *
	 * return integer | bool
	 */
	public static function NUM_ROWS( $sql ) {
		return mysql_num_rows( mysql_query( $sql ) );
	}

	/**
	 * Mysql num rows işlemini yapacak fonksiyon
	 *
	 * @param string  $sql
	 * @param integer $rowNo
	 *
	 * return array | bool
	 */
	public static function GETRESULT( $sql, $rowNo = 0 ) {
		return mysql_result( mysql_query( $sql ), $rowNo );
	}

	/**
	 * mysql_fetch_array fonksiyonu
	 *
	 * @param string $sql
	 *
	 * @return array
	 */
	public static function FETCH_ARRAY( $sql ) {
		return mysql_fetch_array( mysql_query( $sql ) );
	}

}

function baglan() {
	global $veritabanisunucu, $veritabaniadi, $veritabanikullaniciadi, $veritabanikullanicisifre;

	$baglanti = mysql_connect( $veritabanisunucu, $veritabanikullaniciadi, $veritabanikullanicisifre );

	if ( $baglanti ) {
		$db = mysql_select_db( $veritabaniadi, $baglanti );
		if ( ! $db ) {
			die( '<div id="hata"><center><img src="resimler/hata.png" alt="Hata" /></center><br /><h1>Veritabanına bağlanamadım hocam :)</h1></div>' );
		}
	}
	else {
		echo '<div id="hata"><center><img src="resimler/hata.png" alt="Hata" /></center><br /><h1>MySQL sunucusuna ulaşılamıyor.</h1></div>';
		exit();
	};
	mysql_set_charset( 'utf8', $baglanti );
}

;
//----------------------------------------------------------------------
//kontroller
function kontrol() {
	if ( ! empty( $_COOKIE['email'] ) ) {
		$_SESSION['id']              = $_COOKIE['id'];
		$_SESSION['adiSoyadi']       = $_COOKIE['adiSoyadi'];
		$_SESSION['email']           = $_COOKIE['email'];
		$_SESSION['sifre']           = $_COOKIE['sifre'];
		$_SESSION['takipEdenler']    = $_COOKIE['takipEdenler'];
		$_SESSION['takipEttikleri']  = $_COOKIE['takipEttikleri'];
		$_SESSION['konum']           = $_COOKIE['konum'];
		$_SESSION['internetSitesi']  = $_COOKIE['internetSitesi'];
		$_SESSION['kisiselBilgiler'] = $_COOKIE['kisiselBilgiler'];
		$_SESSION['kayitTarihi']     = $_COOKIE['kayitTarihi'];
	}
	if ( empty( $_SESSION['email'] ) ) {
		return false;
	}
	else {
		return true;
	}
}

;
//---------------------------------------------------
//tarih fonkfiyonu
function tarih() {
	$gun = date( 'l' );
	switch ( $gun ) {
		case 'Monday':
			$gun = 'Pazartesi';
			break;
		case 'Tuesday':
			$gun = 'Salı';
			break;
		case 'Wednesday':
			$gun = 'Çarşamba';
			break;
		case 'Thursday':
			$gun = 'Perşembe';
			break;
		case 'Friday':
			$gun = 'Cuma';
			break;
		case 'Saturday':
			$gun = 'Cumartesi';
			break;
		case 'Sunday':
			$gun = 'Pazar';
			break;
	}
	echo $gun . '  ' . date( 'd.m.Y' );
}

;
//----------------------------------------------------------------------
function gravatar( $mail, $boyut, $class ) {
	global $anadizin;
	if ( empty( $mail ) ) {
		$grav_url = "http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=54";
	}
	else {
		$default  = 'http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=' . $boyut . ''; // 'http://'.$_SERVER['HTTP_HOST'].$anadizin."Resimler/avatar.jpg";
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $mail ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $boyut;
	}
	$resim = '<img src="' . $grav_url . '" class="' . $class . '" />';
	return $resim;
}

;
//-------------------------------------------------------------------
//Hata fonksiyonu
function HATA( $hata, $sayfa ) {
	echo
			'<div id="hata">
			<h1>' . $hata . '</h1>
		</div>';
	echo '<a href="' . $sayfa . '"><input type="button" value="Geri"></a>';
	exit();
}

;
//----------------------------------------------------------------------
//say class ı 
class say extends database {
	/**
	 * Kullanıcının paylaştığı durumları yasan fonksiyon
	 *
	 * @param integer $id
	 *
	 * @return integer
	 */
	public function durum( $id ) {
		return parent::NUM_ROWS( "SELECT id FROM durumlar WHERE yazanId=$id" );
	}

	/**
	 * Kullanıcının takipettiği kişi sayısını yasan fonksiyon
	 *
	 * @param integer $id
	 *
	 * @return integer
	 */
	public function takipEttikleri( $id ) {
		$takipEttikleri = parent::GETRESULT( "SELECT takipEttikleri FROM kullanicilar WHERE id=$id", 0 );
		if ( empty( $takipEttikleri ) ) {
			return '0';
		}
		else {
			$takipEttikleri = explode( ',', $takipEttikleri );
			return count( $takipEttikleri );
		}
	}

	/**
	 * Kullanıcıyı  takip  eden kişi sayısını veren fonksiyon
	 *
	 * @param integer $id
	 *
	 * @return integer
	 */
	public function takipEdenler( $id ) {
		$takipEdenler = parent::GETRESULT( "SELECT takipEdenler FROM kullanicilar WHERE id=$id", 0 );
		if ( empty( $takipEdenler ) ) {
			return '0';
		}
		else {
			$takipEdenler = explode( ',', $takipEdenler );
			return count( $takipEdenler );
		}
	}
}

//----------------------------------------------------------------------
//liste
class liste extends database {
	public function anasayfa( $id ) {
		$takipEttikleri = parent::FETCH_ARRAY( "SELECT takipEttikleri FROM kullanicilar WHERE id=$id" );
		if ( $takipEttikleri[0] == '' ) {
			$takipEttikleri[0] = $id;
			unset( $takipEttikleri['takipEttikleri'] );
		}
		else {
			$takipEttikleri = explode( ',', $takipEttikleri[0] );
			array_push( $takipEttikleri, $id );
		}
		$query = 'SELECT * FROM durumlar WHERE ';
		foreach ( $takipEttikleri as $idler ) {
			if ( $query == 'SELECT * FROM durumlar WHERE ' ) {
				$query = $query . "yazanId=$idler OR yanitlananId=$idler";
			}
			else {
				$query = $query . " OR yazanId=$idler OR yanitlananId=$idler";
			}
		}
		$query    = $query . ' ORDER BY id DESC';
		$sorgu    = mysql_query( $query );
		$sonuclar = array();
		while ( $veri = mysql_fetch_array( $sorgu ) ) {
			array_push( $sonuclar, $veri );
		}
		return $sonuclar;
	}

	public function profil( $id ) {
		$sorgu    = mysql_query( "SELECT * FROM durumlar WHERE yazanId=$id OR yanitlananId=$id ORDER BY id DESC" );
		$sonuclar = array();
		while ( $veri = mysql_fetch_array( $sorgu ) ) {
			array_push( $sonuclar, $veri );
		}
		return $sonuclar;
	}

	public function takipEttikleri( $id ) {
		$sorgu          = mysql_query( "SELECT takipEttikleri FROM kullanicilar WHERE id=$id" );
		$takipEttikleri = mysql_fetch_array( $sorgu );
		if ( $takipEttikleri[0] == '' ) {
			$takipEttikleri[0] = 0;
			unset( $takipEttikleri['takipEttikleri'] );
		}
		else {
			$takipEttikleri = explode( ',', $takipEttikleri[0] );
		}
		$query = 'SELECT * FROM kullanicilar WHERE ';
		foreach ( $takipEttikleri as $idler ) {
			if ( $query == 'SELECT * FROM kullanicilar WHERE ' ) {
				$query = $query . "id=$idler";
			}
			else {
				$query = $query . " OR id=$idler";
			}
		}
		$sorgu    = mysql_query( $query );
		$sonuclar = array();
		while ( $veri = mysql_fetch_array( $sorgu ) ) {
			array_push( $sonuclar, $veri );
		}
		return $sonuclar;
	}

	public function takipEdenler( $id ) {
		$sorgu        = mysql_query( "SELECT takipEdenler FROM kullanicilar WHERE id=$id" );
		$takipEdenler = mysql_fetch_array( $sorgu );
		if ( $takipEdenler[0] == '' ) {
			$takipEdenler[0] = 0;
			unset( $takipEdenler['takipEdenler'] );
		}
		else {
			$takipEdenler = explode( ',', $takipEdenler[0] );
		}
		$query = 'SELECT * FROM kullanicilar WHERE ';
		foreach ( $takipEdenler as $idler ) {
			if ( $query == 'SELECT * FROM kullanicilar WHERE ' ) {
				$query = $query . "id=$idler";
			}
			else {
				$query = $query . " OR id=$idler";
			}
		}
		$sorgu    = mysql_query( $query );
		$sonuclar = array();
		while ( $veri = mysql_fetch_array( $sorgu ) ) {
			array_push( $sonuclar, $veri );
		}
		return $sonuclar;
	}

	public function enBegenilenler() {
		$sorgu    = mysql_query( "SELECT * FROM durumlar ORDER BY puan DESC LIMIT 0 , 4" );
		$sonuclar = array();
		while ( $veri = mysql_fetch_array( $sorgu ) ) {
			array_push( $sonuclar, $veri );
		}
		return $sonuclar;
	}
}

//----------------------------------------------------------------------
//takipte mi
function takiptemi( $id, $kim ) {
	baglan();
	$sorgu          = mysql_query( "SELECT takipEttikleri FROM kullanicilar WHERE id=$id" );
	$takipEttikleri = mysql_fetch_array( $sorgu );
	if ( $takipEttikleri[0] == '' ) {
		$takipEttikleri[0] = 0;
		unset( $takipEttikleri['takipEttikleri'] );
	}
	else {
		$takipEttikleri = explode( ',', $takipEttikleri[0] );
	}
	mysql_close();
	return in_array( $kim, $takipEttikleri );
}

//----------------------------------------------------------------------
//arama
function arama( $aranan, $geri ) {
	if ( empty( $aranan ) ) {
		if ( $geri == '/profil.php' ) {
			header( "Location:" . $anadizin . "profil.php" );
			exit();
		}
		else {
			header( "Location:" . $geri );
			exit();
		}
	}
	$aranan = explode( ' ', $aranan );
	baglan();
	$query = "SELECT * FROM kullanicilar WHERE";
	foreach ( $aranan as $kelime ) {
		if ( $query == "SELECT * FROM kullanicilar WHERE" ) {
			$query = $query . " adiSoyadi like '%" . $kelime . "%'";
		}
		else {
			$query = $query . " OR adiSoyadi like '%" . $kelime . "%'";
		}
	}
	$sorgu = mysql_query( $query );
	if ( ! $sorgu ) {
		echo mysql_error();
	}
	$sonuclar = array();
	while ( $sonuc = mysql_fetch_array( $sorgu ) ) {
		array_push( $sonuclar, $sonuc );
	}
	return $sonuclar;
}

//----------------------------------------------------------------------------
//string_temizle
/*
sql injettion gibi saldırıları  önlemek  için 
*/
function string_temizle( $string ) {
	baglan();
	if ( get_magic_quotes_gpc() ) {
		$string = mysql_real_escape_string( nl2br( htmlspecialchars( stripcslashes( $string ) ) ) );
	}
	else {
		$string = mysql_real_escape_string( nl2br( htmlspecialchars( $string ) ) );
	}
	return $string;
}

?>