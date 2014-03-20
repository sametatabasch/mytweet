<?php ob_start();
session_start();
/*
profil sayfası 
 
*/

?>
<?php include_once( 'header.php' );
include_once( 'fonksiyonlar.php' );
kontrol();
if ( empty( $_GET['id'] ) ) {
	$id = $_SESSION['id'];
}
else {
	$id = $_GET['id'];
}
if ( ( empty( $id ) ) AND ( empty( $_SESSION['id'] ) ) ) {
	header( "Location:" . $anadizin );
}
baglan();
$sorgu = mysql_query( "SELECT * FROM kullanicilar WHERE id=$id" );
$bilgiler = mysql_fetch_array( $sorgu );
mysql_close();
?>

<div id="content">
<div class="profil-buyuk">
	<a target="_blank" class="profile-picture" href="#resimlinki">
		<?php echo gravatar( $bilgiler['email'], 128, 'avatar' ) ?>
	</a>

	<div class="profile-card-inner">
		<h1 class="fullname">
			<?php echo $bilgiler['adiSoyadi'] ?>
		</h1>

		<p class="bio ">
			<?php echo $bilgiler['kisiselBilgiler'] ?>
		</p>

		<p class="location-and-url">
                <span class="location">
                    <?php echo $bilgiler['konum'] ?>
                </span>
			<span class="divider">·</span>
                <span class="url">
                    <?php echo $bilgiler['internetSitesi'] ?>
                </span>
		</p>
	</div>
	<div class="profile-card-actions">
		<?php if ( $_SESSION['id'] == $id ): ?>
			<a href="profil.php?x=duzenle" class="btn-profil-duzenle gri">Profilini düzenle</a>
		<?php else: ?>
			<?php if ( ! takiptemi( $_SESSION['id'], $id ) ) : ?>
				<form action="takip.php" method="post" style="float: right;">
					<input type="submit" class="btn-profil mavi" value="Takip Et">
					<input type="hidden" name="takipEdenId" value="<?php echo $_SESSION['id'] ?>">
					<input type="hidden" name="takipEdilenId" value="<?php echo $id; ?>">
					<input type="hidden" name="geri" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
				</form>
			<?php else: ?>
				<form action="takip.php" method="post" style="float: right;">
					<input type="submit" class="btn-profil mavi" value="Takibi Bırak">
					<input type="hidden" name="takibiBirakanId" value="<?php echo $_SESSION['id'] ?>">
					<input type="hidden" name="takibiBirakilanId" value="<?php echo $id; ?>">
					<input type="hidden" name="geri" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
					<input type="hidden" name="birak" value="1">
				</form>
			<?php endif; ?>
		<?php endif; ?>
		<ul class="stats stats-profil">
			<li>
				<?php $say = new say() ?>
				<a href="profil.php?id=<?php echo $_SESSION['id'] ?>">
					<strong><?php echo $say->durum( $id ); ?></strong> Durum
				</a>
			</li>
			<li>
				<a href="profil.php?id=<?php echo $id ?>&x=takipEttikleri">
					<strong><?php echo $say->takipEttikleri( $id ); ?></strong> Takip ettikleri
				</a>
			</li>
			<li>
				<a href="profil.php?id=<?php echo $id ?>&x=takipEdenler">
					<strong><?php echo $say->takipEdenler( $id ); ?></strong> Takipçileri
				</a>
			</li>
		</ul>
	</div>
	<div style="clear:both;"></div>
</div>
<div id="sol" class="sol">

	<div class="tweet-box profil-mini gri">
		<div class=" condensed">
			<div class="text-area">
				<div class="text-area-editor twttr-editor">
					<form method="post" action="durumpaylas.php">
						<textarea name="durum" style="width: 322px; height: 64px; overflow: hidden;"></textarea>
						<input type="hidden" name="yazanId" value="<?php echo $_SESSION['id'] ?>" />
						<input type="hidden" name="geri" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
						<?php if ( $_SESSION['id'] != $id ) { ?>
							<input type="hidden" name="yanitlananId" value="<?php echo $id ?>" />
						<?php } ?>
						<?php if ( $_SESSION['id'] != $id ) { ?>
							<button type="submit" class="mavi" id="durum-paylas-buton"><b>Yanıtla</b></button>
						<?php }
						else { ?>
							<button type="submit" class="mavi" id="durum-paylas-buton"><b>Durumunu Paylaş</b></button>
						<?php } ?>
					</form>
					<div style="clear:both;"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="arama gri">
		<form method="post" action="profil.php?x=arama">
			<input name="aranan" type="text" />
			<input type="hidden" name="geri" value="<?php echo $_SERVER['SCRIPT_NAME'] ?>" />
			<button type="submit" class="mavi"><b>Ara</b></button>
		</form>
		<div style="margin: 0px auto; width: 100px;"><span>Aramak için bir isim yaz</span></div>
		<div style="clear:both;"></div>
	</div>
	<div class="profile-nav gri">
		<ul class="">
			<li class="oval-ilk">
				<a href="<?php echo $anadizin ?>" class="list-link">Ana Sayfa<i class="ok-sag"></i></a>
			</li>
			<li class="">
				<a href="profil.php?id=<?php echo $id ?>&x=takipEttikleri" class="list-link">Takip ediliyor<i class="ok-sag"></i></a>
			</li>
			<li class="">
				<a href="profil.php?id=<?php echo $id ?>&x=takipEdenler" class="list-link">Takipçileri<i class="ok-sag"></i></a>
			</li>
			<li class="oval-son">
				<a href="cikis.php" class="list-link">Çıkış Yap</a>
			</li>
		</ul>
	</div>
</div>
<div id="sag" class="sag">
<?php $x = $_GET['x'];
switch ( $x ) {
	case 'arama':
		?>
		<div class="sagsutun gri">
			<?php $aranan = trim( $_POST['aranan'] );
			$geri = $_POST['geri'];
			foreach ( arama( $aranan, $geri ) as $bulunan ) {
				?>
				<div class="account">
					<div>
						<?php if ( ! takiptemi( $id, $bulunan['id'] ) ) : ?>
							<form action="takip.php" method="post" style="float: right;">
								<input type="submit" class="btn-profil mavi" value="Takip Et">
								<input type="hidden" name="takipEdenId" value="<?php echo $_SESSION['id'] ?>">
								<input type="hidden" name="takipEdilenId" value="<?php echo $bulunan['id']; ?>">
								<input type="hidden" name="geri" value="x=takipEttikleri" />
							</form>
						<?php else: ?>
							<form action="takip.php" method="post" style="float: right;">
								<input type="submit" class="btn-profil mavi" value="Takibi Bırak">
								<input type="hidden" name="takibiBirakanId" value="<?php echo $_SESSION['id'] ?>">
								<input type="hidden" name="takibiBirakilanId" value="<?php echo $bulunan['id']; ?>">
								<input type="hidden" name="geri" value="x=takipEttikleri" />
								<input type="hidden" name="birak" value="1">
							</form>
						<?php endif; ?>
					</div>
					<div class="content">
						<a href="profil.php?id=<?php echo $bulunan['id'] ?>">
							<?php echo gravatar( $bulunan['email'], 48, 'avatar' ) ?>
							<strong class="fullname js-action-profile-name"><?php echo $bulunan['adiSoyadi'] ?></strong>
						</a>

						<p class="bio ">
							<?php echo $bulunan['kisiselBilgiler'] ?>
						</p>
					</div>
				</div>
			<?php } ?>
		</div>

		<?php
		break;
	case 'takipEttikleri':
		?>
		<div class="sagsutun gri">
			<?php $liste = new liste();
			foreach ( $liste->takipEttikleri( $id ) as $takipEdilen ) {
				?>
				<div class="account">
					<div>
						<?php if ( ! takiptemi( $id, $takipEdilen['id'] ) ) : ?>
							<form action="takip.php" method="post" style="float: right;">
								<input type="submit" class="btn-profil mavi" value="Takip Et">
								<input type="hidden" name="takipEdenId" value="<?php echo $_SESSION['id'] ?>">
								<input type="hidden" name="takipEdilenId" value="<?php echo $id; ?>">
								<input type="hidden" name="geri" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
							</form>
						<?php else: ?>
							<form action="takip.php" method="post" style="float: right;">
								<input type="submit" class="btn-profil mavi" value="Takibi Bırak">
								<input type="hidden" name="takibiBirakanId" value="<?php echo $_SESSION['id'] ?>">
								<input type="hidden" name="takibiBirakilanId" value="<?php echo $takipEdilen['id']; ?>">
								<input type="hidden" name="geri" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
								<input type="hidden" name="birak" value="1">
							</form>
						<?php endif; ?>
					</div>
					<div class="content">
						<a href="profil.php?id=<?php echo $takipEdilen['id'] ?>">
							<?php echo gravatar( $takipEdilen['email'], 48, 'avatar' ) ?>
							<strong class="fullname js-action-profile-name"><?php echo $takipEdilen['adiSoyadi'] ?></strong>
						</a>

						<p class="bio ">
							<?php echo $takipEdilen['kisiselBilgiler'] ?>
						</p>
					</div>
				</div>
			<?php } ?>
		</div>

		<?php
		break;
	case 'takipEdenler':
		?>
		<div class="sagsutun gri">
			<?php $liste = new liste();
			foreach ( $liste->takipEdenler( $id ) as $takipEden ) {
				?>
				<div class="account">
					<div>
						<?php if ( ! takiptemi( $id, $takipEden['id'] ) ) : ?>
							<form action="takip.php" method="post" style="float: right;">
								<input type="submit" class="btn-profil mavi" value="Takip Et">
								<input type="hidden" name="takipEdenId" value="<?php echo $_SESSION['id'] ?>">
								<input type="hidden" name="takipEdilenId" value="<?php echo $id; ?>">
								<input type="hidden" name="geri" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
							</form>
						<?php else: ?>
							<form action="takip.php" method="post" style="float: right;">
								<input type="submit" class="btn-profil mavi" value="Takibi Bırak">
								<input type="hidden" name="takibiBirakanId" value="<?php echo $_SESSION['id'] ?>">
								<input type="hidden" name="takibiBirakilanId" value="$takipEden['id']">
								<input type="hidden" name="geri" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
								<input type="hidden" name="birak" value="1">
							</form>
						<?php endif; ?>
					</div>
					<div class="content">
						<a href="profil.php?id=<?php echo $takipEden['id'] ?>" class="account-group js-user-profile-link">
							<?php echo gravatar( $takipEden['email'], 48, 'avatar' ) ?>
							<strong class="fullname js-action-profile-name"><?php echo $takipEden['adiSoyadi'] ?></strong>
						</a>

						<p class="bio ">
							<?php echo $takipEden['kisiselBilgiler'] ?>
						</p>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
		break;
	case 'duzenle':
		?>
		<div class="sagsutun gri">
			<div>
				<h2><b>Profili Düzenle</b></h2>
			</div>
			<div>
				<form action="profild.php" method="post" id="profild-form">
					<label>Adınız Soyadınız:</label>
					<input type="text" name="adiSoyadi" value="<?php echo $bilgiler['adiSoyadi']; ?>" />
					<label>E-mail Adresiniz:</label>
					<input type="text" name="email" value="<?php echo $bilgiler['email']; ?>" />
					<label>Şifreniz:</label>
					<input type="password" name="sifre" />
					<span>Eğer deşitirmeyeceksin boş bırakın</span>
					<label>Konumunuz:</label>
					<input type="text" name="konum" value="<?php echo $bilgiler['konum']; ?>" />
					<label>Web Siteniz:</label>
					<input type="text" name="internetSitesi" value="<?php echo $bilgiler['internetSitesi']; ?>" />
					<label>Kisisel Bilgileriniz:</label>
					<textarea name="kisiselBilgiler"><?php echo $bilgiler['kisiselBilgiler']; ?></textarea>
					<input type="submit" value="Güncelle" class="mavi" />
					<input type="hidden" name="id" value="<?php echo $bilgiler['id']; ?>" />
				</form>
			</div>
			<div style="clear:both;"></div>
		</div>
		<?php
		break;
	default:
		?>
			<div class="sagsutun gri">
				<?php $liste = new liste();
				foreach ( $liste->profil( $id ) as $durum ) {
					$yazanId = $durum['yazanId'];
					$sorgu   = mysql_query( "SELECT adiSoyadi,email FROM kullanicilar WHERE id=$yazanId" );
					$yazan   = mysql_fetch_array( $sorgu );
					?>
					<div class="durum">
						<div class="content">
							<div>
								<small class="time">
									<a title="<?php echo $durum['tarih'] ?>" href="">
										<span><?php echo $durum['tarih'] ?></span>
									</a>
								</small>
								<a href="profil.php?id=<?php echo $yazanId ?>">
									<?php echo gravatar( $yazan['email'], 48, 'avatar' ) ?>
									<strong class="fullname ">
										<?php echo $yazan['adiSoyadi'];
										if ( $durum['yanitlananId'] != 0 ) {
											$yanitlananId = $durum['yanitlananId'];
											$sorgu        = mysql_query( "SELECT adiSoyadi,email FROM kullanicilar WHERE id=$yanitlananId" );
											$yanitlanan   = mysql_fetch_array( $sorgu );
											echo ' - > ' . $yanitlanan['adiSoyadi'];
										}
										?>
									</strong>
								</a>
							</div>
							<p class="js-tweet-text">
								<?php echo $durum['metin'] ?>
							</p>

							<div class="stream-item-footer">
								<form class="details" method="post" action="begen.php">
									<input type="hidden" name="geri" value="<?php echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'] ?>" />
									<input type="hidden" name="id" value="<?php echo $durum['id'] ?>" />
									<input type="submit" value="Beğen" style="background: none; border:none;font-weight:bold;float:left;" class="details">
								</form>
								<form class="details" method="post" action="profil.php?id=<?php echo $durum['yazanId'] ?>">
									<input type="hidden" name="geri" value="<?php echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'] ?>" />
									<input type="submit" value="Yanıtla" style="background: none; border:none;font-weight:bold;float:left;" class="details">
								</form>
								<span class="puan"><?php echo $durum['puan'] ?> kez beğenildi</span>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
				<?php } ?>
			</div>
		<?php
}
?>
</div>
</div>

<?php include_once( 'footer.php' ) ?>
