<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


// Klassen einbinden
// *******************************************************
include_once('../inc/functionsAll.inc.php');
include_once('inc/klassen/login.inc.php');


// Error Variable deklarieren
// *******************************************************
$isErrorLog = '';


// Abfrage ob Post gesendet wird
// *******************************************************
if (isset($_POST['frmUserLog']) && !empty($_POST['frmUserLog']) 
    && isset($_POST['frmPassLog']) && !empty($_POST['frmPassLog'])) {
  $loginObj = new cmsLogin();
  $isLoginOk = $loginObj->checkUserLoginData($_POST['frmUserLog'], $_POST['frmPassLog']);
  
  if (isset($isLoginOk) && $isLoginOk == true) {
    header('Location: ../');
    exit();
  }
  else {
    $isErrorLog = 'Der Benutzername und/oder das Passwort ist falsch!';
  }
}
else if (isset($_POST['frmUserLog']) && empty($_POST['frmUserLog']) 
         || isset($_POST['frmPassLog']) && empty($_POST['frmPassLog'])) {
  $isErrorLog = 'Bitte geben Sie Ihren Benutzername und das Passwort ein!';
}




?><!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo CMS_CUR_LOGINTITLE; ?></title>
    
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/styleLog.css" type="text/css" />
    
    <script type="text/javascript" src="../plugins/jquery.js"></script>
    
  </head>
  <body>
    
    <div id="siteLogBack"></div>
    
    <?php
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') === false) {
    ?>
    
    <div id="loginHolder">
      <div style="height:1px;"></div>
      <div class="frmHolder">
        <form action="" method="post" onsubmit="return checkLoginData();">
          <label for="frmUserLog">User:</label>
          <input type="text" name="frmUserLog" id="frmUserLog" />

          <div class="frmAbstandLog"></div>

          <label for="frmPassLog">Passwort:</label>
          <input type="password" name="frmPassLog" id="frmPassLog" />

          <div class="frmAbstandLog"></div>

          <input type="submit" value="Login" id="logSubmit" /><span class="logLoader"><img src="img/loader.gif" alt="lade..." title="" /></span>
          
          <?php
          if (isset($isErrorLog) && !empty($isErrorLog)) {
            echo '<div id="logErrorText" style="display:block;">' . $isErrorLog . '</div>';
          }
          else {
            echo '<div id="logErrorText"></div>';
          }
          ?>
        </form>
      </div>
    </div>
    
    
    
    
    <script type="text/javascript" src="js/startLog.js"></script>
    
    <?php
    }
    else {
      echo '<div class="noLoginShowOnIeBrowserHolder">';
        echo '<div id="loginHolder">';
          echo '<div style="height:1px;"></div>';
          echo '<div style="color:#fff; text-align:center; font-size:28px; margin:50px 50px 0px 50px;">Aus Sicherheitsgründen wird der Internet Explorer für den CMS Login nicht unterstützt.</div>';
          
          echo '<div style="color:#fff; text-align:center; font-size:21px; margin:60px 50px 0px 50px;">Bitte verwenden Sie z.B. diesen Browser:</div>';
          
          echo '<div style="text-align:center; margin:30px 0px 0px 0px;"><a href="https://www.mozilla.org/de/firefox/new/" target="_blank"><img width="220" src="img/firefox_logo.png" alt="Firefox" title="" /></a></div>';
        echo '</div>';
      echo '</div>';
    }
    ?>
    
  </body>
</html>