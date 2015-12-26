

<!-- tutaj sie zaczyna wlasciwa tresc podstrony -->
<div class="siteContent">
	<div class="siteContentColumns">
		<div class="leftColumn">
			<div class="filterMenu">
				<div class="filterMenuHeader">
					<h3>Filtern nach</h3>
				</div>
			</div>
		</div>
		<div class="rightColumn">
			<div class="siteTopGallery">
				<div id="siteTopGalleryCarousel">
					<div class="imageHolder">
						<!-- tutaj vFront!!! -->
						<img src="templates/wildkogel/img/top-img.jpg" />
					</div>
					<div class="imageHolder">
						<img src="templates/wildkogel/img/top-img.jpg" />
					</div>
					<div class="imageHolder">
						<img src="templates/wildkogel/img/top-img.jpg" />
					</div>
				</div>
			</div>
			<div class="siteTopTextBox">
				<div class="textBoxImage">
					<img src="templates/wildkogel/img/tuv.png" />
				</div>
				<h1>Sunkid Moving Carpet - Zauberteppich</h1>
				<h2>Lorem ipsum dolor sit amet consetetur sadipscing elitr</h2>
				<div class="paragraph">
					Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolo eirmod tempor invidunt ut labore
				</div>
			</div>
			<div class="siteTopIcons">
				<div id="siteTopIconsCarousel">
					<!-- icon Box musi byc bezposrednio pod siteTopIconsCarousel zebym mogl 
					potem podpiac karuzele na mobilu -->
					<!-- te icon Boxy powinny tez miec jakies linki, ale pamietam, ze to jakos mieszalo w adminie,
					wiec zrob zeby bylo dobrze, a ja potem dostosuje ewentualne oskryptowanie -->
					<div class="iconBox">
						<div class="iconBoxImage">
							<img src="templates/wildkogel/img/icon-box-star.png"/>
						</div>
						<div class="iconBoxText">
							<p>Merken</p>
						</div>
					</div>
					<div class="iconBox">
						<div class="iconBoxImage">
							<img src="templates/wildkogel/img/icon-box-info.png"/>
						</div>
						<div class="iconBoxText">
							<p>Infomaterial Anfordern</p>
						</div>
					</div>
					<div class="iconBox">
						<div class="iconBoxImage">
							<img src="templates/wildkogel/img/icon-box-gallery.png"/>
						</div>
						<div class="iconBoxText">
							<p>Bildergalerie</p>
						</div>
					</div>
					<div class="iconBox">
						<div class="iconBoxImage">
							<img src="templates/wildkogel/img/icon-box-video.png"/>
						</div>
						<div class="iconBoxText">
							<p>Video</p>
						</div>
					</div>
				</div>
			</div>

			<!-- plik 4.2 product detail -->

			<!-- PD 4 -->
			<div class="dropdownButton">
				Bildergalerie
			</div>
			<div class="dropdownContent dropdownContentGallery">
				<div class="dropdownContentGalleryInner">
					<div class="galleryImages">
						<div class="galleryImage">
							<a href=""><img src="templates/wildkogel/img/top-img.jpg"></a>
						</div>
						<div class="galleryImage">
							<a href=""><img src="templates/wildkogel/img/top-img.jpg"></a>
						</div>
						<div class="galleryImage">
							<a href=""><img src="templates/wildkogel/img/top-img.jpg"></a>
						</div>
						<div class="galleryImage">
							<a href=""><img src="templates/wildkogel/img/top-img.jpg"></a>
						</div>
					</div>
					<div class="galleryPagination">
						<a href="">1</a>
						<a href="">2</a>
						<a href="">3</a>
					</div>
				</div>
			</div>

			<!-- PD 6 -->
			<div class="dropdownButton">
				Varianten / Optionen
			</div>
			<div class="dropdownContent dropdownContentBordered">
				<!-- PD6.1 -->
				<div class="dropdownContentTwoColumnsLeftLarger">
					<div class="firstColumn">
						<h3>
							<p>Sunkid Galerie</p>
						</h3>
						<div class="paragraph">
							<p>Die Sunkid Galerie wurde 2001 erstmals am Stubaier Gletscher gemeinsam mit der Tiroler Landesregierung entwickelt. Seitdem konnten Weltweit 1200 lfm installiert werden. Die Fahrgäste werden vor Schnee, Regen, Wind und Kälte durch die Sunkid Galerie Förderbandüberdachung geschützt. Neben den Gästen schätzen auch die Betreiber die Sunkid Galerie, da sie auch beu widrigsten Wetterverhältnissen und Schneefall für eine rasche Inbetriebnahme und minimale Wartungsarbeiten sorgt.</p>
						</div>
					</div>
					<div class="secondColumn">
						<div class="galleryImage">
							<a href=""><img src="templates/wildkogel/img/top-img.jpg"></a>
						</div>
						<div class="galleryImage">
							<a href=""><img src="templates/wildkogel/img/top-img.jpg"></a>
						</div>
					</div>
				</div>
				<!-- PD 6.2 -->
				<div class="lineSeparator"></div>
				<!-- PD6.3 -->
				<div class="dropdownContentGalleryWithCaptions">
					<h3>
						<p>Sunkid Galerie - Varianten</p>
					</h3>
					<div class="imagesWithCaptions">
						<?php for ($i = 0; $i < 10; $i++) { ?>
						<div class="imageWithCaption">
							<div class="image">
								<img src="templates/wildkogel/img/top-img.jpg">
							</div>
							<div class="caption">
								<p>Lorem ipsum dolor sit amet consetetur dolor sit</p>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="lineSeparator"></div>
				<!-- PD6.4 -->
				<div class="dropdownContentTwoEqualColumns">
					<div class="firstColumn">
						<img src="templates/wildkogel/img/top-img.jpg">
					</div>
					<div class="secondColumn">
						<h3>
							<p>Super Slide Oberfläche</p>
						</h3>
						<div class="paragraph">
							<p>Sunkid hat als erster Hersteller eine eigene Gleitschicht entwickelt, welche die Reibungswerte verbessern. Die Super Slide Schicht garantiert weniger Reibung und geringeren Verschleiß und dadurch weniger Warung und Service.</p>
						</div>
					</div>
				</div>
				<div class="lineSeparator"></div>
			</div>

			<!-- plik 6 projects detail -->
			<!-- PD_6 -->

			<div class="projectImagesWithDescription">
				<div class="projectBox">
					<img src="templates/wildkogel/img/top-img.jpg">
					<h3>
						<p>Goliath - Schaukel</p>
					</h3>
					<div class="paragraph">
						<p>Lorem ipsum dolor sit amet, consetetur sadipscing, sed diam nonumy eirmod tempor invidunt ut labore et doloredolor sit amet, consetetur sadips</p>
					</div>
				</div>
				<div class="projectBox">
					<img src="templates/wildkogel/img/top-img.jpg">
					<h3>
						<p>Goliath - Schaukel</p>
					</h3>
					<div class="paragraph">
						<p>Lorem ipsum dolor sit amet, consetetur sadipscing, sed diam nonumy eirmod tempor invidunt ut labore et doloredolor sit amet, consetetur sadips</p>
					</div>
				</div>
				<div class="projectBox">
					<img src="templates/wildkogel/img/top-img.jpg">
					<h3>
						<p>Goliath - Schaukel</p>
					</h3>
					<div class="paragraph">
						<p>Lorem ipsum dolor sit amet, consetetur sadipscing, sed diam nonumy eirmod tempor invidunt ut labore et doloredolor sit amet, consetetur sadips</p>
					</div>
				</div>
			</div>

			<div class="dropdownButton">
				<p>Technische Details</p>
			</div>
			<div class="dropdownContent">
				Lorem ipsum...
			</div>
			<div class="dropdownButton">
				<p>Geländeform - Planung</p>
			</div>
			<div class="dropdownContent planningInformation">
				<h4>
					<p>Informationen für den Planer</p>
				</h4>
				<div class="paragraph">
					<p>Mit dem Sunkid-Lift-Baukastensystem können über 80 (!) verschiedene Typen kombiniert werden. Die Auswahl erfolgt nach Maßgabe des vorhandenen Geländes, der gewünschten Förderleistung und den Schneeverhältnissen.</p>
				</div>
				<div class="paragraphList">
					<p>&gt; umfassendes Liftprogramm bis 350 m Länge</p>
					<p>&gt; zertifiziert nach der neuen EU-Richtlinie 2000/9/EG</p>
				</div>
				<h4>
					<p>Idealgelände</p>
				</h4>
				<div class="paragraph">
					<p>Im Idealfall sollte das Geländeprofil in der Mitte ca. 20 % mehr "durchhängen" als das Förderseil. Im Ein- und Ausstiegsbereich muss die Seilhöhe genau eingehalten werdne. Die Höhe des Umlenkrades am Berg kann dann beliebig sein und ist abhängig vom Geländeverlauf nach dem Ausstieg. Mindesthöhe ist allerdings 1,4 m. Maximal sollte der Lift zB an einem Berggipfel enden, kann das Rad auch bis zu 8 m über dem Boden sein. Dafür können wir Spezialkonstruktionen liefern.</p>
				</div>
				<img src="/templates/wildkogel/img/perfect-terrain.jpg" />
				<div class="infoTable">
					<div class="table-responsive">
						<table>
							<tr>
								<th>Lange</th>
								<th colspan="2">fm Durchhang in der Mitte</th>
							</tr>
							<tr>
								<td></td>
								<td>min.</td>
								<td>max.</td>
							</tr>
							<tr>
								<td>100 m</td>
								<td>1,0 m</td>
								<td>1,5 m</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="infoBottomIcons">
					<div class="infoBottomIconsCarousel">
						<?php for ($i = 0; $i < 4; $i++) { ?>
	 						<div class="iconBox">
	 							<div class="iconBoxImage">
	 								<img src="templates/wildkogel/img/icon-box-video.png"/>
	 							</div>
	 							<div class="iconBoxText">
	 								<p>Video</p>
	 							</div>
	 						</div>
						 <?php } ?>
					</div>
				</div>
			</div>
			<div class="dropdownButton">
				<p>Lifttypen im Überblick</p>
			</div>
			<div class="dropdownContent">
				<div class="productsGrid">
					<?php for ($i = 0; $i < 20; ++$i) { ?>
	 					<div class="productGridItem">
	 						<div class="productBox" id="box-<?= $i; ?>">
	 							<div class="productBoxTop">
	 								<span>zur Merkliste hinzufungen</span>
	 								<img src="/templates/wildkogel/img/product-box-star.png" />
	 							</div>
	 							<div class="productBoxImage">
	 								<img src="/templates/wildkogel/img/product-box-image.png" />
	 							</div>
	 							<div class="productBoxText">
	 								Moving Carpet
	 								Zauberteppich <?= $i; ?>
	 							</div>
	 							<div class="productBoxButtons">
	 								<div class="productBoxButton">
	 									<a href="" data-parent="box-<?= $i; ?>" data-id="info-<?= $i; ?>">Quick-info</a>
	 								</div>
	 								<div class="productBoxButton">
	 									<a href="">DetailInfo</a>
	 								</div>
	 							</div>
	 						</div>
	 						<div class="quickInfoBox" id="info-<?= $i; ?>">
	 							<div class="quickInfoLinks">
	 								<div class="quickInfoLinkCarousel">
	 									<div class="quickInfoLink">
	 										<a href=""><img src="/templates/wildkogel/img/icon-box-star.png" />
	 											Merken</a>
	 									</div>
	 									<div class="quickInfoLink">
	 										<a href=""><img src="templates/wildkogel/img/icon-box-info.png"/>
	 											Infomaterial Anfordern</a>
	 									</div>
	 									<div class="quickInfoLink">
	 										<a href=""><img src="templates/wildkogel/img/icon-box-gallery.png"/>
	 											Bildergalerie</a>
	 									</div>
	 								</div>
	 							</div>
	 							<div class="quickInfoContent">
	 								<h4>
	 									<p>Sunkid Moving Carpet -	Zauberteppich  <?= $i; ?></p>
	 								</h4>
	 								<div class="paragraph">
	 									<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,</p>
	 								</div>
	 								<div class="quickInfoBoxLink">
	 									<a href="">Detailinfo</a>
	 								</div>
	 							</div>
	 						</div>
	 					</div>
					 <?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>