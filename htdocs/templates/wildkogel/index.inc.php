<?php
 global $filterColumn; 
 $filtrerHeader = true;
 $filterFooter = true;
 $filterColumn = true;

 if ($_GET['filtr']) {
	 require_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/klassen/filtersystem.inc.php');

	 $filtrObj = new cmsOwnFiltersystem();
	 $filtrArr = $filtrObj->getSettings(1, $_GET['filtr']);

	 if (isset($filtrArr['filterData']['header'])) {

		 $filtrerHeader = false;
	 } else {
		 $filtrArr = $filtrObj->getSettings('global');
		 if (isset($filtrArr['filterData']['header'])) {
			 $filtrerHeader = false;
		 }
	 }


	 if (isset($filtrArr['filterData']['footer'])) {

		 $filterFooter = false;
	 } else {
		 $filtrArr = $filtrObj->getSettings('global');
		 if (isset($filtrArr['filterData']['footer'])) {
			 $filterFooter = false;
		 }
	 }


	 if (isset($filtrArr['filterData']['column'])) {
		 $filtrercolumn = false;
	 } else {


		 $filtrArr = $filtrObj->getSettings('global');

		 if (isset($filtrArr['filterData']['column'])) {
			 $filtrerColumn = false;
		 }
	 }
 }

 $curLangHomeLink = '';

 $curPageNameUri = '';
 if (isset($_GET['page_name']) && !empty($_GET['page_name'])) {
	 $curPageNameUri = $_GET['page_name'];
 }

 $curLangLink = '<a href="en/'.$curPageNameUri.'">English</a>';
 if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
	 $curLangLink = '<a href="'.$curPageNameUri.'">Deutsch</a>';
	 $curLangHomeLink = $_POST['VCMS_POST_LANG'];
 }

 if (isset($_POST['VCMS_POST_LANG']) && $_POST['VCMS_POST_LANG'] == 'en') {
	 require_once('templates/wildkogel/inc/lang/en.inc.php');
 } else {
	 require_once('templates/wildkogel/inc/lang/de.inc.php');
 }

 require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
 $mmFunctionsObj = new mmFunctionsLibrary();
 $icons = $mmFunctionsObj->mmGetSiteListDataArray(333, 13);



 $iconArr = array(
	  '334' => 'iconInfocall',
	  '335' => 'iconRodel',
	  '336' => 'iconGondel',
	  '337' => 'iconWetter',
	  '338' => 'iconLivecam',
	  '339' => 'iconInfo',
	  '340' => 'iconSleep',
	  '341' => 'icoSearch'
 );


 require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/timeClass.inc.php');

 $mmFunctionsObj = new mmFunctionsLibrary();
 $time           = new timeClass();
 $siteData = $mmFunctionsObj->mmGetSiteListDataArrayOnce($cms['cms_siteID']);
 $imageArr = explode(';', $siteData['seitBackImages']);

 foreach ($imageArr as $key => $value) {
     
     
     if($time->checkTimeBanner($value)){
         $backFileArr[] = $mmFunctionsObj->getPicOnceDataByIdMM($value);
     }	 
 }

 $arr = range(0, count($backFileArr) - 1);
 shuffle($arr);



 if (is_file($_SERVER['DOCUMENT_ROOT'].'/user_upload/'.$backFileArr[$arr[0]]['bildFile'])) {
	 $bg = '/user_upload/'.$backFileArr[$arr[0]]['bildFile'];
 } else {
	 $bg = '';
 }



 if (empty($cms['cms_ownFields']['_showCTAHead']) || $cms['cms_ownFields']['_showCTAHead'] == 1) {
	 $bgm = 'berge_header_weiss.png';
 } else {
	 $bgm = 'berge_header.png';
 }

 require_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/klassen/order.inc.php');
  $orderObj = new cmsOrderModul();
  $countItems = $orderObj->countItemBasket();

 $langMenu = $cmsObj->buildLanguageMenu($cms['cms_siteID']);
 
?>
 
<?php if ($cms['cms_siteLayID'] == 6) { ?>

	 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/bootstrap.min.css" rel="stylesheet">
	 <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,300italic,600,600italic,700,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/font-awesome.min.css" rel="stylesheet">
	 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/tooltipster.css" rel="stylesheet">

	 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/style.css" rel="stylesheet">

	 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/superfish.css">
	 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.carousel.css">
	 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.theme.css">


	 <?php $cmsObj->getSiteLayout(); ?>


 <?php } else { ?>



	 <?php if ($cms['cms_siteLayID'] == 1 || $cms['cms_siteLayID'] == 2) { ?>
		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/bootstrap.min.css" rel="stylesheet">
		 <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,300italic,600,600italic,700,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/font-awesome.min.css" rel="stylesheet">
		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/tooltipster.css" rel="stylesheet">

		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/style.css" rel="stylesheet">

		 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/superfish.css">
		 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.carousel.css">
		 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.theme.css">


		 <!-- 1_Home -->
		 <div class="siteHeader">
		 	<div class="top">
		 		<div class="topInner">
		 			<div class="topLeft">
		 				<div class="logo">
		 					<a href="<?php echo SITE_URL ?><?php echo $_GET['_lang'] ?>/home">
		 						<img id="logoBand" src="<?php echo SITE_URL ?>templates/wildkogel/img/band.png" />
		 						<img id="logoImg" src="<?php echo SITE_URL ?>templates/wildkogel/img/logo.png" /></a>
		 				</div>
		 			</div>
		 			<div class="menuToggle">
		 				<span><?php echo  lang('Menu-offnen'); ?></span>
		 			</div>
		 			<div id="topIcons">
						 <?php
						 foreach ($icons as $key => $value) {

							 $linkArr = json_decode($value['detailElemData']['selemLink']);
							 $textArr =  json_decode($value['detailElemData']['selemInhalt']);
                                                         
                                                    
                                                         
                                                 ?>
			 				<div class="topIcon">
			 					<a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>"  class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self" >
                                                                    <span class="tooltipster <?php echo $iconArr[$key] ?>" title="<?php  echo strip_tags($textArr->elemText1) ?>">
			 						</span>
			 					</a>
			 				</div>
						 <?php } ?>
		 			</div>
		 			<div class="topRight">
		 				<div class="topSearch">
                                                    
                                                    <form method="post" action="/search-result">
                                                        <input type="text" name="search" id="searchInput" value="" style="display:none;" placeholder="<?php echo SEARCH ?>" autofocus/>
                                                    </form> 
                                                    <div class="topIcon iconSearch tooltipster" title="<?php echo SEARCH ?>">

		 					</div>
		 				</div>
		 				<div class="languageSelector">
		 					<a class="languageButton"><?php echo  lang('sprachen'); ?>
		 						<img src="<?php echo SITE_URL ?>templates/wildkogel/img/sprachen_pfeil.png"/></a>
		 					<div class="languageList">
		 						<ul>
		 							<?php echo $langMenu; ?>
		 							<li>
		 								<a href="http://www.wildkogel-arena.nl/nl.html">Nederlands</a>
		 							</li>
                                                                        <li>
		 								<a href="http://www.wildkogel-arena.cz/cz.html">čeština</a>
		 							</li>
		 						</ul>
		 					</div>
		 				</div>
		 				<div class="heartTop " data-logo="<?php echo SITE_URL ?>templates/wildkogel/img/band.png">
                                                    <img src="<?php echo SITE_URL ?>templates/wildkogel/img/heart_inaktiv_top.png" class="tooltipster"  title="<?php echo CART; ?>"/>
                                                        <span class="merklisteNumber"  >(<?php echo $countItems; ?>)</span>
		 				</div>
		 			</div>
		 			<div id="navbar">
						 <?php echo $cmsObj->getCmsMenu(1, 1); ?>
		 				<div class="topMenuClose">
		 				</div>
		 			</div>
		 		</div>
		 	</div>
		 	<div class="dummy">

		 	</div>

                     
                     

			 <?php 
                     
                         
                         $idSite = $cms['cms_siteID'];
                         
                         if ($cms['cms_siteLayID'] == 1) { ?>
			 	<div class="bigHeader giveMeBackground color<?php echo $cms['cms_ownFields']['_showCTAHead'] ?>">
			 		<img class="hereIsYourBackgroud hidden" src="<?php echo ($bg == '') ? 'templates/wildkogel/img/header2.jpg' : $bg; ?>"/>


					 <?php echo $cmsObj->setElementHolder('H1H2Banner'); ?>
			 		<div id="mobileIcons">
						 <?php
						 foreach ($icons as $key => $value) {

							 $linkArr = json_decode($value['detailElemData']['selemLink']);
							 $textArr =  json_decode($value['detailElemData']['selemInhalt']);
                                                         
                                                    
                                                    if($iconArr[$key] != 'icoSearch'){     
                                                 ?>
			 				<div class="topIcon">
			 					<a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>"  class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self" >
                                                                    <span class="tooltipster <?php echo $iconArr[$key] ?>" title="<?php  echo strip_tags($textArr->elemText1) ?>">
			 						</span>
			 					</a>
			 				</div>
						 <?php
                                                    }
                                                 
                                                    } ?>
			 		</div>
			 	</div> 

			 <?php } else { ?>

			 	<div class="standardHeader giveMeBackground color<?php echo $cms['cms_ownFields']['_showCTAHead'] ?>">
			 		<div class="standardHeaderInner">
			 			<img class="hereIsYourBackgroud hidden" src="<?php echo ($bg == '') ? 'templates/wildkogel/img/aktivitaten.png' : $bg; ?>"/>

						 <?php echo $cmsObj->setElementHolder('H1H2Banner'); ?>
			 			<div class="traumHinzufungen mobile-hidden">
			 				<a   class="dropdownHeart basketButton addItem" data-siteid="<?php echo $cms['cms_siteID'] ?>" data-dropid="" data-type="site" data-target="<?php echo ($cms['cms_ownFields']['_cartBasket']=='')?21:$cms['cms_ownFields']['_cartBasket']; ?>" data-layout="<?php  echo $cms['cms_siteLayID']; ?>" href="javascript:void(0)"><img src="templates/wildkogel/img/traum_hinzu.png" /></a>
			 			</div>
			 			<div id="mobileIcons">
							 <?php
						 foreach ($icons as $key => $value) {

							 $linkArr = json_decode($value['detailElemData']['selemLink']);
							 $textArr =  json_decode($value['detailElemData']['selemInhalt']);
                                                         
                                                    
                                                    if($iconArr[$key] != 'icoSearch'){     
                                                 ?>
			 				<div class="topIcon">
			 					<a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>"  class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self" >
                                                                    <span class="tooltipster <?php echo $iconArr[$key] ?>" title="<?php  echo strip_tags($textArr->elemText1) ?>">
			 						</span>
			 					</a>
			 				</div>
						 <?php
                                                    }
                                                 
                                                    } ?>
			 			</div>

			 		</div>
			 	</div>

			 <?php } ?>


		 </div>
		 <div class="scrollDown">
		 </div><?php } else { ?>

		 <!-- Sommer -->

		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/bootstrap.min.css" rel="stylesheet">
		 <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,300italic,600,600italic,700,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/font-awesome.min.css" rel="stylesheet">
		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/tooltipster.css" rel="stylesheet">

		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/style.css" rel="stylesheet">
		 <link href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/sommer.css" rel="stylesheet">

		 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/superfish.css">
		 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.carousel.css">
		 <link rel="stylesheet" href="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.theme.css">


		 <!-- 1_Home -->
		 <div class="siteHeader">
		 	<div class="top">
		 		<div class="topInner">
		 			<div class="topLeft">
		 				<div class="logo">
		 					<a href="<?php echo SITE_URL ?>/<?php echo $_GET['_lang'] ?>/home">
		 						<img id="logoBand" src="<?php echo SITE_URL ?>/templates/wildkogel/img/band-sommer.png" />
		 						<img id="logoImg" src="<?php echo SITE_URL ?>/templates/wildkogel/img/logo.png" /></a>
		 				</div>
		 			</div>
		 			<div class="menuToggle">
		 				<span><?php echo  $lang['Menu-offnen'] ?></span>
		 			</div>
		 			<div id="topIcons">
						  <?php
						 foreach ($icons as $key => $value) {

							 $linkArr = json_decode($value['detailElemData']['selemLink']);
							 $textArr =  json_decode($value['detailElemData']['selemInhalt']);
                                                         
                                                    
                                                         
                                                 ?>
			 				<div class="topIcon">
			 					<a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>"  class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self" >
                                                                    <span class="tooltipster <?php echo $iconArr[$key] ?>" title="<?php  echo strip_tags($textArr->elemText1) ?>">
			 						</span>
			 					</a>
			 				</div>
						 <?php } ?>


		 			</div>
		 			<div class="topRight">
		 				<div class="topSearch">
                                                    
                                                    <form method="post" action="/search-result">
                                                        <input type="text" name="search" id="searchInput" value="" style="display:none;" placeholder="<?php echo SEARCH ?>" autofocus />
                                                    </form> 
                                                    <div class="topIcon iconSearch tooltipster" title="<?php echo SEARCH ?>">

		 					</div>
		 				</div>
		 				<div class="languageSelector">
		 					<a class="languageButton">Sprachen
		 						<img src="/templates/wildkogel/img/sprachen_pfeil.png"/></a>
		 					<div class="languageList">
		 						<ul>
		 							<?php echo $langMenu; ?>
		 							<li>
		 								<a href="http://www.wildkogel-arena.nl/nl.html">Nederlands</a>
		 							</li>
                                                                        <li>
		 								<a href="http://www.wildkogel-arena.cz/cz.html">čeština</a>
		 							</li>
		 						</ul>
		 					</div>
		 				</div>
                                            <div class="heartTop " data-logo="/templates/wildkogel/img/band.png">
                                                    <img src="<?php echo SITE_URL ?>/templates/wildkogel/img/heart_inaktiv_top.png" class="tooltipster"  title="<?php echo CART; ?>"/>
                                                        <span class="merklisteNumber"  >(<?php echo $countItems; ?>)</span>
		 				</div>
		 			</div>
		 			<div id="navbar">
						 <?php echo $cmsObj->getCmsMenu(1, 1); ?>
		 				<div class="topMenuClose">
		 				</div>
		 			</div>
		 		</div>
		 	</div>
		 	<div class="dummy">

		 	</div>


			 <?php if ($cms['cms_siteLayID'] == 4) { ?>
			 	<div class="bigHeader giveMeBackground color<?php echo $cms['cms_ownFields']['_showCTAHead'] ?>">
			 		<img class="hereIsYourBackgroud hidden" src="<?php echo ($bg == '') ? 'templates/wildkogel/img/header3.jpg' : $bg; ?>"/>

					 <?php echo $cmsObj->setElementHolder('H1H2Banner'); ?>
			 		<div id="mobileIcons">
							 <?php
						 foreach ($icons as $key => $value) {

							 $linkArr = json_decode($value['detailElemData']['selemLink']);
							 $textArr =  json_decode($value['detailElemData']['selemInhalt']);
                                                         
                                                    
                                                    if($iconArr[$key] != 'icoSearch'){     
                                                 ?>
			 				<div class="topIcon">
			 					<a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>"  class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self" >
                                                                    <span class="tooltipster <?php echo $iconArr[$key] ?>" title="<?php  echo strip_tags($textArr->elemText1) ?>">
			 						</span>
			 					</a>
			 				</div>
						 <?php
                                                    }
                                                 
                                                    } ?>
			 		</div>
			 	</div> 

			 <?php } else { ?>

			 	<div class="standardHeader giveMeBackground color<?php echo $cms['cms_ownFields']['_showCTAHead'] ?>">
			 		<div class="standardHeaderInner">
			 			<img class="hereIsYourBackgroud hidden" src="<?php echo ($bg == '') ? 'templates/wildkogel/img/aktivitaten.png' : $bg; ?>"/>

						 <?php echo $cmsObj->setElementHolder('H1H2Banner'); ?>
			 			<div class="traumHinzufungen mobile-hidden">
			 				<a   class="dropdownHeart basketButton addItem" data-siteid="<?php echo $cms['cms_siteID'] ?>" data-layout="<?php  echo $cms['cms_siteLayID']; ?>" data-dropid="" data-type="site" data-target="<?php echo ($cms['cms_ownFields']['_cartBasket']=='')?21:$cms['cms_ownFields']['_cartBasket']; ?>" href="javascript:void(0)"><img src="templates/wildkogel/img/traum_hinzu.png" /></a>
			 			
			 			</div>
			 			<div id="mobileIcons">
							 	 <?php
						 foreach ($icons as $key => $value) {

							 $linkArr = json_decode($value['detailElemData']['selemLink']);
							 $textArr =  json_decode($value['detailElemData']['selemInhalt']);
                                                         
                                                    
                                                    if($iconArr[$key] != 'icoSearch'){     
                                                 ?>
			 				<div class="topIcon">
			 					<a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>"  class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self" >
                                                                    <span class="tooltipster <?php echo $iconArr[$key] ?>" title="<?php  echo strip_tags($textArr->elemText1) ?>">
			 						</span>
			 					</a>
			 				</div>
						 <?php
                                                    }
                                                 
                                                    } ?>
			 			</div>
			 		</div>
			 	</div>

			 <?php } ?>


		 </div>
		 <div class="scrollDown">
		 </div>

	 <?php }
	 ?>


	 <?php $cmsObj->getSiteLayout(); ?>


	 <!-- Koniec Home -->
<?php
if ($cms['cms_siteLayID'] == 4 || $cms['cms_siteLayID'] == 2) { 
  
    echo $cmsObj->setElementHolder('bottombanner', 'inherit');

} ?>

<?php
 echo $cmsObj->setElementHolder('footer1', 'inherit');
?>
	
	 <!-- Cookie zakomentowane zeby nie przeszkadzalo 
	 <div class="cookieMessage">
	 	<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
	 	<div class="cookieClose">
	 			<span class="fa fa-times"></span>
	 	</div>
	 </div>
	 -->

	 <?php if ($cms['cms_siteLayID'] == 2) { ?>

		 <?php
		 $curBackLink = '';
		 $curBackLinkHtmlA = '';
		 $curBackLinkHtmlE = '';

		 if (isset($cms['cms_siteParent']) && !empty($cms['cms_siteParent'])) {
			 $curBackLink = $cmsObj->getCurentLinkBySiteIdUser($cms['cms_siteParent']);
		 }

		 if (isset($curBackLink) && !empty($curBackLink)) {
			 $curBackLinkHtmlA = '<a href="'.$curBackLink.'">';
			 $curBackLinkHtmlE = '</a>';
		 }
		 ?>

		 <?php echo $curBackLinkHtmlA; ?><div id="siteArrowBackDetailSiteBtn" style="display:none;"><i class="fa fa-chevron-left"></i><div class="siteArrowBackDetailSiteBtnText">Zurück<br />zur<br />auswahl</div></div><?php echo $curBackLinkHtmlE; ?>

	 <?php } ?>



	 <!--
	 <div class="popupMerkliste">
	   <div class="merklisteTop">
	 	<div class="merklisteTopInner">
	 		<div class="mLogo">
	 			<img src="/templates/wildkogel/img/sunkid-logo.png" />
	 		</div>
	 		<h1>Merkliste</h1>
	 		<div class="popupClose">
	 			schließen
	 		</div>
	 	</div>
	   </div>
	   <div class="merklisteContent">
	 	<div class="merklisteFilters">
	 		Positionen Filtern nach: alles Anzeigen | Produkte | Projektberichte | Bilder Bestellung
	 	</div>
	 	<div class="merklisteItems">
	 		<div class="merklisteItem">

	 		</div>
	 	</div>
	   </div>
	   <div class="merklisteFooter">
	 	<a href="/order-form">Zur Dateneingabe</a>
	   </div>
	 </div>-->

	 <?php
	 if ($cms['cms_siteID'] == 301) {
		 require_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/klassen/order.inc.php');
		 $json = $orderObject->checkOrderTypes();

		 if ($json) {
			 ?>
			 <script>
			 	var targets = <?php echo $json; ?>;
			 </script> 
			 <?php
		 }
	 } else {
		 ?>
		 <script>
		 	var targets = '';
		 </script>  

		 <?php
	 }
	 ?>
	 <div class="popupMerkliste">
	 	<div class="top popupTop">
	 		<div class="topInner">
	 			<div class="topLeft">
	 				<div class="logo">
	 					<a href="<?php echo SITE_URL; ?><?php echo $_GET['_lang'] ?>/home">
                                                     <?php if ($cms['cms_siteLayID'] == 1 || $cms['cms_siteLayID'] == 2) { ?>
	 						<img id="logoBand" src="<?php echo SITE_URL ?>/templates/wildkogel/img/band.png">
                                                     <?php }else{ ?>
                                                         <img id="logoBand" src="<?php echo SITE_URL ?>/templates/wildkogel/img/band-sommer.png">
                                                    <?php } ?>   
                                                        
	 						<img id="logoImg" src="<?php echo SITE_URL ?>/templates/wildkogel/img/logo.png"></a>
	 				</div>
	 			</div>
	 			<div class="topRight">
	 				<div class="popupClose">
	 						<?php echo  lang('close-basket'); ?> 
	 				</div>
	 			</div>
	 		</div>
	 	</div>
	 	<div class="standardHeader giveMeBackground color<?php echo $cms['cms_ownFields']['_showCTAHead'] ?>">
	 		<div class="standardHeaderInner">
	 			<img class="hereIsYourBackgroud hidden" src="<?php echo ($bg == '') ? 'templates/wildkogel/img/aktivitaten.png' : $bg; ?>"/>
	 			<img class="activeHeart" src="<?php echo SITE_URL ?>/templates/wildkogel/img/heart_aktiv.png" />
	 			<h1><?php echo  lang('dein-traumurlaub'); ?> </h1>
	 		</div>
	 	</div>
	 	<div class="merklisteContent">
	 		<div class="merklisteFilters">
	 			Positionen Filtern nach: alles Anzeigen | Wanderungen | Gastronomie | Aktivitäten | Themen
	 		</div>
	 		<div class="merklisteItems">
	 			<div class="merklisteItem">
	 				<div style="background-image: url(<?php echo SITE_URL ?>/user_upload/thumb_400/steineralm.png;);" class="panel panelLarge panelPhoto giveMeBackground">
	 					<img class="hereIsYourBackgroud hidden" src="/user_upload/thumb_400/steineralm.png">
	 					<div class="panelTitle">
	 						<p>Lorem ipsum</p>					
	 					</div>
	 				</div>
	 			</div>
	 		</div>
	 	</div>
	 	<!-- Footer z jednym przyciskiem -->
	 	<!--
	   <div class="merklisteFooter">
	 	  <a href="/order-form">Zur Dateneingabe</a>
	   </div>
	 	-->
	 	<div class="merklisteDoubleFooter"> 
	 		<div class="merklisteFooterLeft">
                            <a href="javascript:void(0)" id="friendForm" data-url="https://wildkogel-arena.at/<?php echo $_GET['_lang'] ?>/traumliste-send-to-a-friend"><?php echo  lang('form-friends'); ?></a>
	 		</div>
	 		<div class="merklisteFooterRight">
	 			<a href="javascript:void(0)" id="friendForm1" data-url="https://wildkogel-arena.at/<?php echo $_GET['_lang'] ?>/traumliste-an-wildkogel-arena"><?php echo  lang('form-order'); ?></a>
	 		</div>
	 	</div>
	 </div>

 <?php } // else cms['cms_siteLayID'] == 6  ?>



<script type="text/javascript">
   var vcmsCurBackstretchElemSet = '.siteHeaderBigPicHolder';
<?php
 if (!isset($cms['cms_ownFields']['_fixAnfrageHide']) || $cms['cms_ownFields']['_fixAnfrageHide'] != 'on') {
	 echo 'var isFixedAnfrageFooterShowedOnSet = true;';
 } else {
	 echo 'var isFixedAnfrageFooterShowedOnSet = false;';
 }
?>
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5645f8b52e9d4ded" async="async"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?>/admin/frontAdmin/js/orders.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/superfish.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/isotope.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL ?><?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/whcookies.js"></script>	