
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
    $mmFunctionsObj = new mmFunctionsLibrary();
	

	$element = $mmFunctionsObj->mmGetSiteDetailElementBySelem(1,$thisElemArr['elemData']['selemID']);
	
	$selemConfig = json_decode($element['selemConfig']);
	
	
	
	$idPic = $selemConfig->picGal;
	 
	
	
 $pic =	$mmFunctionsObj->getPicOnceDataByIdMM($idPic);
 
 $curThumb = 'thumb_400/';
  $imgMFile = 'user_upload/'.$curThumb.$pic['bildFile'];
 ////print_r($pic);
 ?>



<div class="project">
                   
                        <div class="project-image">
                        	<?php  if($imgMFile != ''){ ?>
                            <img src="<?php echo  $imgMFile; ?>" />
                            <?php } ?>
                        </div>
								<div class="project-image-secondary">
									<img src="../project-img.png" />
								</div>
                        <div class="project-overlay">
                            <div class="project-box-inner">
                                <h3><?php echo $thisElemArr['text1']; ?></h3>
                                <?php echo $thisElemArr['text1']; ?>
                            </div>
                        </div>
                         <a href=""></a>
                   
                </div>