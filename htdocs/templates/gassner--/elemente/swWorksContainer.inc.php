		<div class="container mobile-showcase">
			<div class="col-md-5 col-md-push-5"><br>
				<div class="work-mob1"><?php echo $thisElemArr['text1'] ; ?></div>
				
				<div class="work-mob2"><?php echo $thisElemArr['text2'] ; ?></div>
				
				<div class="work-mob3"><?php echo $thisElemArr['text3'] ; ?></div>
					</div>
			<div class="col-md-4 col-md-pull-5 col-md-offset-1 text-center">
				<?php echo $thisElemArr['bild1']; ?>
			</div>
		</div>
		<div class="container perspective hidden-xs">
			<?php echo  str_replace('thumb_800/','',$thisElemArr['bild2']); ?>
		</div>
		<div class="container perspective visible-xs">
			<?php echo str_replace('thumb_800/','',$thisElemArr['bild2']); ?>
		</div>