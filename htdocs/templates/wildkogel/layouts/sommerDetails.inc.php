
<div id="siteContent" class="siteContent vFrontIsCurSeoContentSet">
    
    <img class="hereIsYourBackgroud hidden" src="templates/wildkogel/img/winter-bg.jpg"/>

	
<div class="breadcrumbs">
	 <?php echo  $cmsObj->getSiteBreadcrumbsString();  ?>
 
</div>
      <!-- Go to www.addthis.com/dashboard to customize your tools -->
<div class="addthis_sharing_toolbox shareIcons"></div>
	<!-- <div class="shareIcons">

		<a href="#" class="addthis_button_compact"><img src="templates/wildkogel/img/share-plus.png"/></a>
		<a href=""><img src="templates/wildkogel/img/share-mail.png"/></a>
		<a href=""><img src="templates/wildkogel/img/share-phone.png"/></a>
		<a id="atic_facebook" href="#" onclick="return addthis_sendto('facebook');"><img src="templates/wildkogel/img/share-face.png"/></a>
		<a href="#"  onclick="return addthis_sendto('twitter');"><img src="templates/wildkogel/img/share-tweet.png"/></a>
		<a href="#" onclick="return addthis_sendto('googleplus');"><img src="templates/wildkogel/img/share-gplus.png"/></a>
	</div> -->
	
	<div class="traumHinzufungen pc-hidden">
			 				<a   class="dropdownHeart basketButton addItem" data-siteid="<?php echo $cms['cms_siteID'] ?>" data-dropid="" data-type="site" data-target="<?php echo ($cms['cms_ownFields']['_cartBasket']=='')?21:$cms['cms_ownFields']['_cartBasket']; ?>" data-layout="<?php  echo $cms['cms_siteLayID']; ?>" href="javascript:void(0)">
							<?php echo  lang('heart-top'); ?></a>
			 			</div> 
    
<?php
 echo $cmsObj->setElementHolder('contentSite');
?>
   
    <?php 
  
    if($cms['cms_ownFields']['_back'] == 'on'  ){ ?>
    
      <h2  class="backButton"><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>"><?php echo  lang('back'); ?></a> </h2>  
    <?php } ?>
</div>