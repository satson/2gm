<?php
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
}
else {
  require_once('templates/wildkogel/inc/lang/de.inc.php');
}
?>


    <link href="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Hind:400,300,500,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/style.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>css/superfish.css">
<link rel="stylesheet" href="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.theme.css">




  <div class="siteHeader">
        <div class="top">
            <div class="topLeft">
                <div class="logo">
                    <img src="" />
                </div>
            </div>
            <div class="topRight">
                <div class="toolbar">
                    <div class="searchInput">
                        <a href=""></a>
                        <input type="text" name="search" />
                    </div>
                    <div class="topMerkliste">
                        <a href="">Merkliste (10)</a>
                    </div>
                    <div class="languageSelector">
                        <a class="languageButton">Sprachen</a>
                        <div class="languageList">
                            <ul>
                                <li>
                                    <a href="">Deutsch</a>
                                </li>
                                <li>
                                    <a href="">English</a>
                                </li>
                                <li>
                                    <a href="">French</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="topMenu">
                    <!-- tutaj wygeneruj mi menu z submenu 
                   Produkte
                    - Moving Carpet
                    - Lifte
                    - Sunny Stuff
                   Sunkid
                   Service
                   Projekte
                   Kontakt
                   -->
                </div>
            </div>
        </div>
        <div class="bigHeader giveMeBackground">
            <img class="hereIsYourBackgroud hidden" src="" />
            <div class="bigHeaderInner">
                <div class="bigHeaderBlock">
                    <div class="bigHeaderBlockInner">
                        <img src="/templates/sunkid/img/sommer.png" alt="">
                        <h3>Sommer</h3>
                        <img src="/templates/sunkid/img/sommer_img.png" alt="">
                        <a href=""></a>
                    </div>
                </div>
                <div class="bigHeaderBlock">
                    <div class="bigHeaderBlockInner">
                        <img src="/templates/sunkid/img/winter.png" alt="">
                        <h3>Winter</h3>
                        <img src="/templates/sunkid/img/winter_img.png" alt="">
                        <a href=""></a>
                    </div>
                </div>
                <div class="bigHeaderBlock">
                    <div class="bigHeaderBlockInner">
                        <img src="/templates/sunkid/img/urban.png" alt="">
                        <h3>Urban</h3>
                        <img src="/templates/sunkid/img/urban_img.png" alt="">
                        <a href=""></a>
                    </div>
                </div>
                <div class="bigHeaderBlock">
                    <div class="bigHeaderBlockInner">
                        <img src="/templates/sunkid/img/amusement.png" alt="">
                        <h3>Amusement Technology</h3>
                        <img src="/templates/sunkid/img/amusement_img.png" alt="">
                        <a href=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scrollDown">
        <!-- to jest ta strzałka do przewiniecia lekkiego w dol -->
        <a href="#siteContent"></a>
    </div>



 <div id="siteContent" class="siteContent">
        <div class="container">
        <?php $cmsObj->getSiteLayout(); ?>
        
        
            <div class="homeProduktfinder">
                <a href="">Produktfinder</a>
            </div>
            <div class="homeNewsBox">
                <div class="homeNewsHeader">
                    <h2>News</h2>
                </div>
                <div class="homeNews owl-carousel">
                    <div class="news">
                        <img src="templates/sunkid/img/news_img.jpg" />
                        <h4>2014-08-24</h4>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetet</p>
                        <a href="">mehr</a>
                    </div>
                    <div class="news">
                        <img src="templates/sunkid/img/news_img.jpg" />
                        <h4>2014-08-24</h4>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetet</p>
                        <a href="">mehr</a>
                    </div>
                    <div class="news">
                        <img src="templates/sunkid/img/news_img.jpg" />
                        <h4>2014-08-24</h4>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetet</p>
                        <a href="">mehr</a>
                    </div>
                </div>
            </div>
            <div class="homeTextBox">
                <h2>Lorem ipsum consetet dolor diam nonumy</h2>
                <h3>Lorem ipsum dolor consetetur</h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                <p>At <a href="">vero eos et accusam</a> et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetd tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. St</p>
            </div>
        </div>
    </div>




 


   <div class="siteFooter">
        <div class="siteFooterInner">
            <div class="siteFooterTopRow">
                <div class="col-md-3">
                    <div class="footerWidget">
                        <h3>Kontakt</h3>
                        <p>Adresse:</p>
                        <p>Email:</p>
                        <p>Tel.:</p>
                        <p>Mobil:</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerWidget">
                        <h3>Follow us</h3>
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerWidget">
                        <h3>Newsletter</h3>
                        <form action="" method="post">
                            <input type="text" name="" value="" placeholder="Anrede*"/>
                            <input type="submit" value="Newletter anmelden" />
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerWidget">
                        <h3>Archiv</h3>
                        <p><a href="">Presse</a></p>
                        <p><a href="">Impressum</a></p>
                        <p><a href="">Links</a></p>
                    </div>
                </div>
            </div>
            <div class="siteFooterBottomRow">
                <div class="col-md-3">
                    <div class="footerWidget">
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerWidget">
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerWidget">
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerWidget">
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                        <p><a href="">Lorem ipsum</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toTop" id="siteArrowScrollTopSiteBtn"></div>
    <div class="cookieMessage">
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
        <div class="cookieClose"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/functions.js"></script>
    
    


<script type="text/javascript" src="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/superfish.min.js"></script>
<script type="text/javascript" src="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/owl-carousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/isotope.js"></script>
<script type="text/javascript" src="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>js/functions.js"></script>