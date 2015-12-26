<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
       $img = $matches[1]; 
 ?>
 
<div class="siteContent">
<div class="dropdownButton">
		<span><?php echo $thisElemArr['text1']; ?></span>
                <?php if($img != 'admin/img/noImg.png'){ ?>
		<img src="<?php echo $img; ?>">
                <?php } ?>
                
	</div>
	<div class="dropdownContent">
            
            
             <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
            
            
		<!--<p>Skipasspreise und Tarife für Erwachsene, Familien und Kinder.
			Gültig auf allen Liftanlagen der Wildkogel-Arena in Neukirchen und Bramberg.</p>
		<table>
			<tr>
				<th>Tage</th>
				<th>Erwachsene</th>
				<th>Jugend</th>
				<th>Kinder</th>
			</tr>
			<tr>
				<td>Lorem</td>
				<td>Ipsum</td>
				<td>123,12</td>
				<td>123,33</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<h2><p>Mit dem Skipass der Wildkogel-Arena GRATIS ins Hallenbad:</p></h2>
		<p>Im Hallenbad Kogler in Mittersill dem Badespaß frönen. Ein 25 m Becken mit</p>
		<p>Massagebucht und Unterwassermusik, ein Kinderbecken mit Minirutsche, eine 60 m Rutsche und ein Whirlpool machen den Badetag zum Abenteuer. Der Gratiseintritt gilt nur für Karten der Wildkogel-Arena ab der 3-Tageskarte.</p>
		<div class="lineSeparator"></div>
		<h2><p>Sonnen-Wahl-Abo Karten</p></h2>
		<p>Die Wahlskipässe haben eine Laufzeit von 6 bzw. 10 Tagen und können innerhalb dieser Zeit 4 oder 6 Tage konsumiert werden.</p>
	--></div>
    </div>