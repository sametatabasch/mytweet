<?php
/*
sitenin content kısmı bu  sayfa üzerinden düzenlenecek. 
*/
if ( ! kontrol() ):
	?>
	<div id="content">
		<div id="begenilenler" class="mavi sol">
			<h2>En Çok Beğenilenler</h2>
			<?php $liste = new liste();
			baglan();
			foreach ( $liste->enBegenilenler() as $begenilen ) {
				$yazanId = $begenilen['yazanId'];
				$sorgu   = mysql_query( "SELECT adiSoyadi,email FROM kullanicilar WHERE id=$yazanId" );
				$yazan   = mysql_fetch_array( $sorgu );
				?>
				<div class="durum">
					<div class="content">
						<div>
							<small class="time">
								<a title="<?php echo $begenilen['tarih'] ?>" href="">
									<span><?php echo $begenilen['tarih'] ?></span>
								</a>
							</small>
							<a href="profil.php?id=<?php echo $yazanId ?>">
								<?php echo gravatar( $yazan['email'], 48, 'avatar' ) ?>
								<strong class="fullname ">
									<?php echo $yazan['adiSoyadi'];
									if ( $begenilen['yanitlananId'] != 0 ) {
										$yanitlananId = $begenilen['yanitlananId'];
										$sorgu        = mysql_query( "SELECT adiSoyadi,email FROM kullanicilar WHERE id=$yanitlananId" );
										$yanitlanan   = mysql_fetch_array( $sorgu );
										echo ' - > ' . $yanitlanan['adiSoyadi'];
									}
									?>
								</strong>
							</a>
						</div>
						<p class="js-tweet-text">
							<?php echo $begenilen['metin'] ?>
						</p>
						<span class="puan"><?php echo $begenilen['puan'] ?> kez beğenildi</span>
					</div>
					<div style="clear:both;"></div>
				</div>
			<?php }
			mysql_close(); ?>
		</div>
		<div id="giris" class="gri sag">
			<h2><strong>Giriş Yap</strong></h2>

			<form action="giris.php" method="post">
				<div class="">
					<input type="text" class="input" name="email" title="e-posta adresi" autocomplete="on">
					<span class="">e-posta adresi</span>
				</div>
				<table class="">
					<tbody>
					<tr>
						<td class="">
							<div class="">
								<input type="password" class="input" name="sifre" title="Şifre">
								<span class="placeholder">Şifre</span>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
				<label class="">
					<input type="checkbox" name="hatirla">
					<span>Beni hatırla</span>
				</label>
				<button type="submit" id="giris_buton" class="mavi sag" tabindex="0">Giriş yap</button>
			</form>
		</div>
		<div id="kayit" class="gri sag">
			<h2><strong>Yeni misin?</strong> Kaydol</h2>

			<form method="post" class="" action="kayit.php">
				<div class="">
					<input type="text" maxlength="20" name="adiSoyadi" autocomplete="off" class="input">
					<span class="">Ad ve soyad</span>
				</div>
				<div class="">
					<input type="text" name="email" autocomplete="off" class="input">
					<span class="">E-posta</span>
				</div>
				<div class="">
					<input type="password" name="sifre" class="input">
					<span class="">Şifre</span>
				</div>
				<button id="kayit_buton" class=" mavi sag" type="submit">
					Kaydol
				</button>
			</form>
		</div>
	</div>
<?php
else:
	?>
	<div id="content">
		<div id="sol" class="sol">
			<div class="profil-mini gri">
				<div class="profil">
					<a id="profil-link" href="profil.php?id=<?php echo $_SESSION['id']; ?>">
						<div class="content">
							<div class="account-group js-mini-current-user">
								<?php echo gravatar( $_SESSION['email'], 40, 'avatar' ) ?>
								<b class="fullname"><?php echo $_SESSION['adiSoyadi'] ?></b>
								<small class="metadata">Profil sayfamı görüntüle</small>
							</div>
						</div>
					</a>
				</div>
				<div class="">
					<ul class="stats">
						<li>
							<?php $say = new say() ?>
							<a href="profil.php?id=<?php echo $_SESSION['id'] ?>">
								<strong><?php echo $say->durum( $_SESSION['id'] ); ?></strong> Durum
							</a>
						</li>
						<li>
							<a href="profil.php?id=<?php echo $_SESSION['id'] ?>&x=takipEttikleri">
								<strong><?php echo $say->takipEttikleri( $_SESSION['id'] ); ?></strong> Takip ettikleri
							</a>
						</li>
						<li>
							<a href="profil.php?id=<?php echo $_SESSION['id'] ?>&x=takipEdenler">
								<strong><?php echo $say->takipEdenler( $_SESSION['id'] ); ?></strong> Takipçileri
							</a>
						</li>
					</ul>
				</div>
				<div class="tweet-box tweet-user">
					<div class="tweet-box condensed">
						<div class="text-area">
							<div class="text-area-editor twttr-editor">
								<form method="post" action="durumpaylas.php">
									<textarea name="durum" style="width: 295px; height: 55px; overflow: hidden;"></textarea>
									<input type="hidden" name="yazanId" value="<?php echo $_SESSION['id'] ?>" />
									<input type="hidden" name="geri" value="<?php echo $_SERVER['SCRIPT_NAME'] . $_SERVER['QUERY_STRING']; ?>">
									<button type="submit" class="mavi" id="durum-paylas-buton"><b>Durumunu Paylaş</b></button>
								</form>
								<div style="clear:both;"></div>
							</div>
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
					<li class="active oval-ilk">
						<a href="<?php echo $anadizin ?>" class="list-link">Ana Sayfa<i class="ok-sag"></i></a>
					</li>
					<li class="">
						<a href="profil.php?x=takipEttikleri" class="list-link">Takip ediliyor<i class="ok-sag"></i></a>
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
			<div class="sagsutun gri">
				<?php $liste = new liste();
				foreach ( $liste->anasayfa( $_SESSION['id'] ) as $durum ) {
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
		</div>
	</div>
<?php
endif;
?>