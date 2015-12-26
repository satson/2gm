<?php
global $cms;
global $cmsObj;



require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
$mmAllPauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArray(38, 16);





$errorTextAf = '';


if (isset($_POST['frmVorname'])) {
  
  if (isset($_POST['frmAnreiseDate']) && empty($_POST['frmAnreiseDate'])) {
    $errorTextAf .= GAS_FEHLER_ANREISE . '<br />';
  }
  if (isset($_POST['frmAbreiseDate']) && empty($_POST['frmAbreiseDate'])) {
    $errorTextAf .= GAS_FEHLER_ABREISE . '<br />';
  }
  if (isset($_POST['frmAnzahlErwachsene']) && empty($_POST['frmAnzahlErwachsene'])) {
    $errorTextAf .= GAS_FEHLER_ANZAHL_ERWACHSENE . '<br />';
  }
  if (isset($_POST['frmAnrede']) && empty($_POST['frmAnrede'])) {
    $errorTextAf .= GAS_FEHLER_ANREDE . '<br />';
  }
  if (isset($_POST['frmSprache']) && empty($_POST['frmSprache'])) {
    $errorTextAf .= GAS_FEHLER_SPRACHE . '<br />';
  }
  if (isset($_POST['frmVorname']) && empty($_POST['frmVorname'])) {
    $errorTextAf .= GAS_FEHLER_VORNAME . '<br />';
  }
  if (isset($_POST['frmNachname']) && empty($_POST['frmNachname'])) {
    $errorTextAf .= GAS_FEHLER_NACHNAME . '<br />';
  }
  if (isset($_POST['frmMail']) && empty($_POST['frmMail'])) {
    $errorTextAf .= GAS_FEHLER_MAIL_NO . '<br />';
  }
  if (isset($_POST['frmMail']) && !empty($_POST['frmMail']) && !checkValitMail($_POST['frmMail'])) {
    $errorTextAf .= GAS_FEHLER_MAIL . '<br />';
  }
  
  
  if (isset($errorTextAf) && empty($errorTextAf)) {
    
    $curSiteFromText = '';
    if (isset($_POST['frmHiddenContentSiteIdFrom']) && !empty($_POST['frmHiddenContentSiteIdFrom'])) {
      $curSiteNameFromSend = $mmFunctionsObj->getCurSiteNameBySiteIdOnlyMM($_POST['frmHiddenContentSiteIdFrom']);
      $curSiteFromText = $curSiteNameFromSend;
    }
    
    $mailText = '
      Diese Anfrage ist auf www.hotel-gassner.at eingegangen.<br />
      <br />';
    if (isset($curSiteFromText) && !empty($curSiteFromText)) {
      $mailText .= 'Kunde kommt von Content Seite:&nbsp;&nbsp;&nbsp;'.$curSiteFromText.'<br /><br />';
    }
    $mailText .= 'Neue Kontaktformular Anfrage:<br />
      ---------------------------------------------------------------------------------<br />
      <br />
      Anrede: ' . $_POST['frmAnrede'] . '<br />
      Vorname: ' . $_POST['frmVorname'] . '<br />
      Nachname: ' . $_POST['frmNachname'] . '<br />
      Straße: ' . $_POST['frmStrasse'] . '<br />
      PLZ: ' . $_POST['frmPLZ'] . '<br />
      Ort: ' . $_POST['frmOrt'] . '<br />
      Land: ' . $_POST['frmLand'] . '<br />
      <br />
      Telefon: ' . $_POST['frmTel'] . '<br />
      Fax: ' . $_POST['frmFax'] . '<br />
      E-Mail: ' . $_POST['frmMail'] . '<br />
      <br />
      Sprache: '.$_POST['frmSprache'].'<br />
        
      <br />
      Zeitraum:<br />
      ---------------------------------------------------------------------------------<br />
      <br />
      Anreise: ' . $_POST['frmAnreiseDate'] . '<br />
      Abreise: ' . $_POST['frmAbreiseDate'] . '<br />
        
      <br />
      Alternativer Zeitraum:<br />
      ---------------------------------------------------------------------------------<br />
      <br />
      Alternative Anreise: ' . $_POST['frmAnreiseDateAlternat'] . '<br />
      Alternative Abreise: ' . $_POST['frmAbreiseDateAlternat'] . '<br />
        
      <br />
      Personen:<br />
      ---------------------------------------------------------------------------------<br />
      <br />
      Anzahl Erwachsene: ' . $_POST['frmAnzahlErwachsene'] . '<br />
      Anzahl Kinder: ' . $_POST['frmAnzahlKinder'] . '<br />
      Alter Kinder: ' . $_POST['frmAlterKinder'] . '<br />
        
      <br />
      Gewünschte(r) Zimmertype(n) und Anzahl (in Klammer):<br />
      ---------------------------------------------------------------------------------<br />
      <br /> 
      ';
      if (isset($_POST['frmEinzelzimmer']) && !empty($_POST['frmEinzelzimmer'])) {
        $mailText .= $_POST['frmEinzelzimmer'] . ' (' . $_POST['frmEinzelzimmerAnzahl'] . ')<br />';
      }
      if (isset($_POST['frmDoppelzimmer']) && !empty($_POST['frmDoppelzimmer'])) {
        $mailText .= $_POST['frmDoppelzimmer'] . ' (' . $_POST['frmDoppelzimmerAnzahl'] . ')<br />';
      }
      if (isset($_POST['frmWohlfuehlzimmer']) && !empty($_POST['frmWohlfuehlzimmer'])) {
        $mailText .= $_POST['frmWohlfuehlzimmer'] . ' (' . $_POST['frmWohlfuehlzimmerAnzahl'] . ')<br />';
      }
      if (isset($_POST['frmWohnstudio']) && !empty($_POST['frmWohnstudio'])) {
        $mailText .= $_POST['frmWohnstudio'] . ' (' . $_POST['frmWohnstudioAnzahl'] . ')<br />';
      }
      if (isset($_POST['frmSuite']) && !empty($_POST['frmSuite'])) {
        $mailText .= $_POST['frmSuite'] . ' (' . $_POST['frmSuiteAnzahl'] . ')<br />';
      }
      
      if (isset($_POST['frmDoppelZimmerEinz']) && !empty($_POST['frmDoppelZimmerEinz'])) {
        $mailText .= $_POST['frmDoppelZimmerEinz'] . ' (' . $_POST['frmDoppelZimmerEinzAnzahl'] . ')<br />';
      }
      if (isset($_POST['frmBauernhaus']) && !empty($_POST['frmBauernhaus'])) {
        $mailText .= $_POST['frmBauernhaus'] . ' (' . $_POST['frmBauernhausAnzahl'] . ')<br />';
      }
      
    $mailText .= '<br />
      Sommer Pauschalen:<br />
      ---------------------------------------------------------------------------------<br />
      <br />';
      
      foreach ($_POST as $keyElemS => $curPostElem) {
        if (stripos($keyElemS, 'frmSoPa') !== false) {
            $mailText .= $curPostElem . '<br />';
        }
      }
      
    $mailText .= '<br />
      Winter Pauschalen:<br />
      ---------------------------------------------------------------------------------<br />
      <br />';
      
      foreach ($_POST as $keyElemW => $curPostElemW) {
        if (stripos($keyElemW, 'frmWiPa') !== false) {
            $mailText .= $curPostElemW . '<br />';
        }
      }

    $mailText .= '
      <br />
      Bemerkung:<br />
      ---------------------------------------------------------------------------------<br />
      <br />
      ' . nl2br($_POST['frmText']) . '
    ';
    
    $mailText .= '
      <br /><br />
      Zusatz:<br />
      ---------------------------------------------------------------------------------<br />
      <br />
      Aufmerksam geworden durch: ' . $_POST['frmInfoWo'] . '<br />
    ';
    
    if (isset($_POST['frmInfoWo']) && ($_POST['frmInfoWo'] == 'Andere Medien' || $_POST['frmInfoWo'] == 'Folgende Webseite' || $_POST['frmInfoWo'] == 'Messe')) {
      $mailText .= 'Medie: ' . $_POST['frmInfoWoText'] . '<br /><br />';
    }
    else {
      $mailText .= '<br />';
    }
    
    if (isset($_POST['frmSendSommerP']) && !empty($_POST['frmSendSommerP'])) {
      $mailText .= $_POST['frmSendSommerP'] . '<br />';
    }
    if (isset($_POST['frmSendWinterP']) && !empty($_POST['frmSendWinterP'])) {
      $mailText .= $_POST['frmSendWinterP'] . '<br />';
    }
    if (isset($_POST['frmInfoGassner']) && !empty($_POST['frmInfoGassner'])) {
      $mailText .= $_POST['frmInfoGassner'] . '<br />';
    }
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: Kontaktformular <info@hotel-gassner.at>" . "\n";
    $mailSubject = 'Anfrage Webseite Hotel Gassner';
    //$mailTo = 'info@hotel-gassner.at';
    $mailTo = 'info@pixasoft.at';


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      $curDankeSeiteUri = $cmsObj->getCurentLinkBySiteIdUser(264);
      //header('Location: '.$curDankeSeiteUri);
      echo '<meta http-equiv="refresh" content="0; URL='.$curDankeSeiteUri.'" />';
      exit();
      //$mail_send_ok = 1;
    }
    else {
      //$mail_send_ok = 2;
    }
  }
  
}








$anreiseDatumAMM = '';
$abreiseDatumAMM = '';
$anzahlErwachseneAMM = '';
$anzahlKinderAMM = '';

if (isset($_POST['frmAnreiseDate']) && !empty($_POST['frmAnreiseDate'])) {
  $anreiseDatumAMM = $_POST['frmAnreiseDate'];
}
if (isset($_POST['frmAbreiseDate']) && !empty($_POST['frmAbreiseDate'])) {
  $abreiseDatumAMM = $_POST['frmAbreiseDate'];
}
if (isset($_POST['frmAnzahlErwachsene']) && !empty($_POST['frmAnzahlErwachsene'])) {
  $anzahlErwachseneAMM = $_POST['frmAnzahlErwachsene'];
}
if (isset($_POST['frmAnzahlKinder']) && !empty($_POST['frmAnzahlKinder'])) {
  $anzahlKinderAMM = $_POST['frmAnzahlKinder'];
}



$einzelzimmerSet = '';
$doppelzimmerSet = '';
$wohlfuhlzimmerSet = '';
$wohnstudioSet = '';
$suiteSet = '';
$bauernhausSet = '';

if (isset($_GET['_curSiteId']) && $_GET['_curSiteId'] == 32) {
  $einzelzimmerSet = ' checked="checked"';
}
if (isset($_GET['_curSiteId']) && $_GET['_curSiteId'] == 33) {
  $doppelzimmerSet = ' checked="checked"';
}
if (isset($_GET['_curSiteId']) && $_GET['_curSiteId'] == 34) {
  $wohlfuhlzimmerSet = ' checked="checked"';
}
if (isset($_GET['_curSiteId']) && $_GET['_curSiteId'] == 35) {
  $wohnstudioSet = ' checked="checked"';
}
if (isset($_GET['_curSiteId']) && $_GET['_curSiteId'] == 37) {
  $suiteSet = ' checked="checked"';
}
if (isset($_GET['_curSiteId']) && $_GET['_curSiteId'] == 29) {
  $bauernhausSet = ' checked="checked"';
}



$curSiteIdFromZw = '';
if (isset($_GET['_curSiteId']) && !empty($_GET['_curSiteId'])) {
  $curSiteIdFromZw = $_GET['_curSiteId'];
}

?>




<div class="frmAnfrageHolder">
    
  <div class="errorTextAusgabeAf"><?php echo $errorTextAf; ?></div>

  <form action="" method="post" onsubmit="return checkAnfrageDataAnfrageForm();">
    
    <input type="hidden" name="frmHiddenContentSiteIdFrom" id="frmHiddenContentSiteIdFrom" value="<?php echo $curSiteIdFromZw; ?>" />

    <div class="frmFieldsLeft">
      <div class="posUeberschrift"><?php echo GAS_KONT_ZEITRAUM; ?></div>

      <div class="frmAbstandAA"></div>

      <label><?php echo GAS_KONT_ANREISE; ?>:<span class="pflichtFeldStern">*</span></label><input class="smallTextField" type="text" name="frmAnreiseDate" id="frmAnreiseDate" readonly="readonly" value="<?php echo $anreiseDatumAMM; ?>" />
      <div class="frmAbstandAA"></div>

      <label><?php echo GAS_KONT_ABREISE; ?>:<span class="pflichtFeldStern">*</span></label><input class="smallTextField" type="text" name="frmAbreiseDate" id="frmAbreiseDate" readonly="readonly" value="<?php echo $abreiseDatumAMM; ?>" />

      <div class="posUeberschrift"><?php echo GAS_KONT_PERSONEN; ?></div>

      <div class="frmAbstandAA"></div>

      <label for="frmAnzahlErwachsene"><?php echo GAS_KONT_ANZAHL_ERWACHSENE; ?>:<span class="pflichtFeldStern">*</span></label><input class="smallTextField" type="text" name="frmAnzahlErwachsene" id="frmAnzahlErwachsene" value="<?php echo $anzahlErwachseneAMM; ?>" />

      <div class="frmAbstandAA"></div>

      <label for="frmAnzahlKinder"><?php echo GAS_KONT_ANZAHL_KINDER; ?>:</label><input class="smallTextField" type="text" name="frmAnzahlKinder" id="frmAnzahlKinder" value="<?php echo $anzahlKinderAMM; ?>" />

      <div class="frmAbstandAA"></div>

      <label for="frmAlterKinder"><?php echo GAS_KONT_ALTER_KINDER; ?>:</label><input class="smallTextField" type="text" name="frmAlterKinder" id="frmAlterKinder" />
    </div>



    <div class="frmFieldsRight">
      <div class="posUeberschrift"><?php echo GAS_KONT_ALT_ZEITRAUM; ?></div>

      <div class="frmAbstandAA"></div>

      <label><?php echo GAS_KONT_ANREISE; ?>:</label><input class="smallTextField" type="text" name="frmAnreiseDateAlternat" id="frmAnreiseDateAlternat" readonly="readonly" />
      <div class="frmAbstandAA"></div>

      <label><?php echo GAS_KONT_ABREISE; ?>:</label><input class="smallTextField" type="text" name="frmAbreiseDateAlternat" id="frmAbreiseDateAlternat" readonly="readonly" />

      <div class="posUeberschrift"><?php echo GAS_KONT_ZIMMERTYPEN_UE; ?>:</div>

      <div class="frmAbstandAA"></div>

      <input<?php echo $einzelzimmerSet; ?> type="checkbox" name="frmEinzelzimmer" id="frmEinzelzimmer" value="Einzelzimmer" /><label class="bigLblFrm" for="frmEinzelzimmer"><?php echo GAS_KONT_EINZELZIMMER; ?></label><input class="smallTextFieldC" type="text" name="frmEinzelzimmerAnzahl" id="frmEinzelzimmerAnzahl" />

      <div class="frmAbstandAA"></div>

      <input<?php echo $doppelzimmerSet; ?> type="checkbox" name="frmDoppelzimmer" id="frmDoppelzimmer" value="Doppelzimmer" /><label class="bigLblFrm" for="frmDoppelzimmer"><?php echo GAS_KONT_DOPPELZIMMER; ?></label><input class="smallTextFieldC" type="text" name="frmDoppelzimmerAnzahl" id="frmDoppelzimmerAnzahl" />

      <div class="frmAbstandAA"></div>

      <input type="checkbox" name="frmDoppelZimmerEinz" id="frmDoppelZimmerEinz" value="Doppelzimmer zur Einzelbenutzung" /><label class="bigLblFrm" for="frmDoppelZimmerEinz"><?php echo GAS_KONT_DOPPELZIMMER_EINZEL; ?></label><input class="smallTextFieldC" type="text" name="frmDoppelZimmerEinzAnzahl" id="frmDoppelZimmerEinzAnzahl" />

      <div class="frmAbstandAA"></div>

      <input<?php echo $wohlfuhlzimmerSet; ?> type="checkbox" name="frmWohlfuehlzimmer" id="frmWohlfuehlzimmer" value="Wohlfühlzimmer" /><label class="bigLblFrm" for="frmWohlfuehlzimmer"><?php echo GAS_KONT_WOHLZIMMER; ?></label><input class="smallTextFieldC" type="text" name="frmWohlfuehlzimmerAnzahl" id="frmWohlfuehlzimmerAnzahl" />

      <div class="frmAbstandAA"></div>

      <input<?php echo $wohnstudioSet; ?> type="checkbox" name="frmWohnstudio" id="frmWohnstudio" value="Wohnstudio" /><label class="bigLblFrm" for="frmWohnstudio"><?php echo GAS_KONT_WOHNSTUDIO; ?></label><input class="smallTextFieldC" type="text" name="frmWohnstudioAnzahl" id="frmWohnstudioAnzahl" />

      <div class="frmAbstandAA"></div>

      <input<?php echo $suiteSet; ?> type="checkbox" name="frmSuite" id="frmSuite" value="Suite" /><label class="bigLblFrm" for="frmSuite"><?php echo GAS_KONT_SUITE; ?></label><input class="smallTextFieldC" type="text" name="frmSuiteAnzahl" id="frmSuiteAnzahl" />

      <div class="frmAbstandAA"></div>

      <input<?php echo $bauernhausSet; ?> type="checkbox" name="frmBauernhaus" id="frmBauernhaus" value="Bauernhaus" /><label class="bigLblFrm" for="frmBauernhaus"><?php echo GAS_KONT_BAUERNHAUS; ?></label><input class="smallTextFieldC" type="text" name="frmBauernhausAnzahl" id="frmBauernhausAnzahl" />
    </div>



    <div class="clearer"></div>


    
    <div class="frmFieldsLeft">
      <div id="sommerPToggler"><?php echo GAS_KONT_SOMMERPAUSCHALEN; ?></div>
      <div id="sommerPHolder">
        <?php
        $_hansSommer = 0;
        
        foreach ($mmAllPauschaleListArr as $key => $value) {
          $isChecked = '';
          
          if (isset($_GET['_curSiteId']) && !empty($_GET['_curSiteId'])) {
            if (isset($key) && $key == $_GET['_curSiteId']) {
              $isChecked = ' checked="checked"';
            }
          }
          
          // Für Text Ausgabe
          // ***********************************************************************
          $curSelemInhaltArr = json_decode($value['detailElemData']['selemInhalt'], true);
          
          
          $show = false;
          $allFilterKats = $mmFunctionsObj->mmGetAllFilterkategoriesListFromOneDetailElementArray($value['detailElemData']['selemID']);
          $allFilterKatsArr = explode(';', $allFilterKats);
          if (isset($allFilterKatsArr) && is_array($allFilterKatsArr)) {
            foreach ($allFilterKatsArr as $valueFK) {
              if (isset($valueFK) && $valueFK == 5) {
                $show = true;
              }
            }
          }
          //echo $allFilterKats; // Winter 2    Sommer 5
          
          if (isset($show) && $show == true) {
            $_hansSommer++;
            echo '<input'.$isChecked.' type="checkbox" name="frmSoPa' . $_hansSommer . '" id="frmSoPa' . $_hansSommer . '" value="' . strip_tags($curSelemInhaltArr['elemText2']) . '" /><label class="bigLblFrm" style="vertical-align:middle; width:385px;" for="frmSoPa' . $_hansSommer . '">' . strip_tags($curSelemInhaltArr['elemText2']) . '</label>';
            echo '<div class="frmAbstandAA"></div>';
            echo '<div class="frmAbstandAA"></div>';
          }
        }
        ?>
      </div>
    </div>
    
    <div class="frmFieldsRight">
      <div id="winterPToggler"><?php echo GAS_KONT_WINTERPAUSCHALEN; ?></div>
      <div id="winterPHolder">
        <?php
        $_hansSommer = 0;
        
        foreach ($mmAllPauschaleListArr as $key => $value) {
          $isChecked = '';
          
          if (isset($_GET['_curSiteId']) && !empty($_GET['_curSiteId'])) {
            if (isset($key) && $key == $_GET['_curSiteId']) {
              $isChecked = ' checked="checked"';
            }
          }
          
          // Für Text Ausgabe
          // ***********************************************************************
          $curSelemInhaltArr = json_decode($value['detailElemData']['selemInhalt'], true);
          
          
          $showW = false;
          $allFilterKatsW = $mmFunctionsObj->mmGetAllFilterkategoriesListFromOneDetailElementArray($value['detailElemData']['selemID']);
          $allFilterKatsArrW = explode(';', $allFilterKatsW);
          if (isset($allFilterKatsArrW) && is_array($allFilterKatsArrW)) {
            foreach ($allFilterKatsArrW as $valueFKW) {
              if (isset($valueFKW) && $valueFKW == 2) {
                $showW = true;
              }
            }
          }
          
          
          if (isset($showW) && $showW == true) {
            $_hansWinter++;
            echo '<input'.$isChecked.' type="checkbox" name="frmWiPa' . $_hansWinter . '" id="frmWiPa' . $_hansWinter . '" value="' . strip_tags($curSelemInhaltArr['elemText2']) . '" /><label class="bigLblFrm" style="vertical-align:middle; width:385px;" for="frmWiPa' . $_hansWinter . '">' . strip_tags($curSelemInhaltArr['elemText2']) . '</label>';
            echo '<div class="frmAbstandAA"></div>';
            echo '<div class="frmAbstandAA"></div>';
          }
        }
        ?>
      </div>
    </div>



    <div class="clearer"></div>


    <div class="posUeberschrift"><?php echo GAS_KONT_DATEN_UE; ?></div>


    <div class="frmFieldsLeft">
      <div class="frmAbstandAA"></div>

      <label for="frmAnrede"><?php echo GAS_KONT_ANREDE; ?>:<span class="pflichtFeldStern">*</span></label><select name="frmAnrede" id="frmAnrede">
        <option value="Herr"><?php echo GAS_KONT_ANREDE_HERR; ?></option>
        <option value="Frau"><?php echo GAS_KONT_ANREDE_FRAU; ?></option>
        <option value="Familie"><?php echo GAS_KONT_ANREDE_FAMILIE; ?></option>
        <option value="Firma"><?php echo GAS_KONT_ANREDE_FIRMA; ?></option>
      </select>

      <div class="frmAbstandAA"></div>
      
      <?php
      $isEnglischChecked = '';
      if (isset($_POST['VCMS_POST_LANG']) && $_POST['VCMS_POST_LANG'] == 'en') {
        $isEnglischChecked = ' selected="selected"';
      }
      ?>

      <label for="frmSprache"><?php echo GAS_KONT_SPRACHE; ?>:<span class="pflichtFeldStern">*</span></label><select name="frmSprache" id="frmSprache">
        <option value="Deutsch"><?php echo GAS_KONT_SPRACHE_DE; ?></option>
        <option<?php echo $isEnglischChecked; ?> value="Englisch"><?php echo GAS_KONT_SPRACHE_EN; ?></option>
      </select>

      <div class="frmAbstandAA"></div>

      <label for="frmVorname"><?php echo GAS_KONT_VORNAME; ?>:<span class="pflichtFeldStern">*</span></label><input type="text" name="frmVorname" id="frmVorname" />

      <div class="frmAbstandAA"></div>

      <label for="frmNachname"><?php echo GAS_KONT_NACHNAME; ?>:<span class="pflichtFeldStern">*</span></label><input type="text" name="frmNachname" id="frmNachname" />

      <div class="frmAbstandAA"></div>

      <label for="frmStrasse"><?php echo GAS_KONT_STRASSE; ?>:</label><input type="text" name="frmStrasse" id="frmStrasse" />

      <div class="frmAbstandAA"></div>

      <label for="frmPLZ"><?php echo GAS_KONT_PLZ; ?>:</label><input type="text" name="frmPLZ" id="frmPLZ" />

      <div class="frmAbstandAA"></div>

      <label for="frmOrt"><?php echo GAS_KONT_ORT; ?>:</label><input type="text" name="frmOrt" id="frmOrt" />

      <div class="frmAbstandAA"></div>

      <label for="frmLand"><?php echo GAS_KONT_LAND; ?>:</label><input type="text" name="frmLand" id="frmLand" />

      <div class="frmAbstandAA"></div>

      <label for="frmTel"><?php echo GAS_KONT_TELEFON; ?>:</label><input type="text" name="frmTel" id="frmTel" />

      <div class="frmAbstandAA"></div>

      <label for="frmFax"><?php echo GAS_KONT_FAX; ?>:</label><input type="text" name="frmFax" id="frmFax" />

      <div class="frmAbstandAA"></div>

      <label for="frmMail"><?php echo GAS_KONT_MAIL; ?>:<span class="pflichtFeldStern">*</span></label><input type="text" name="frmMail" id="frmMail" />
    </div>




    <div class="frmFieldsRight">
      <div class="frmAbstandAA"></div>

      <label style="display:block; width:auto;" for="frmText"><?php echo GAS_KONT_BEMERKUNG; ?>:</label><textarea class="bigTextElem" name="frmText" id="frmText"></textarea>

      <div class="frmAbstandAA"></div>

      <label style="display:block; width:auto; font-weight:bold"><?php echo GAS_KONT_AUFMERKSAM; ?></label>
      <select name="frmInfoWo" id="frmInfoWo">
        <option value=""><?php echo GAS_KONT_AM_AUSWAHL; ?></option>
        <option value="Stammgast"><?php echo GAS_KONT_AM_STAMMGAST; ?></option>
        <option value="Freunde/Bekannte"><?php echo GAS_KONT_AM_FREUNDE; ?></option>
        <option value="Wanderhotels"><?php echo GAS_KONT_AM_WANDERHOTELS; ?></option>
        <option value="Tourismusbüro"><?php echo GAS_KONT_AM_TOURISMUS; ?></option>
        <option value="Empfehlung"><?php echo GAS_KONT_AM_EMPFEHLUNG; ?></option>
        <option value="Google"><?php echo GAS_KONT_AM_GOOGLE; ?></option>
        <option value="Facebook"><?php echo GAS_KONT_AM_FACEBOOK; ?></option>
        <option value="Zeitschriften"><?php echo GAS_KONT_AM_ZEITSCHRIFT; ?></option>
        <option value="Andere Medien"><?php echo GAS_KONT_AM_MEDIEN; ?></option>
        <option value="Folgende Webseite"><?php echo GAS_KONT_AM_WEBSITE; ?></option>
        <option value="Messe"><?php echo GAS_KONT_AM_MESSE; ?></option>
      </select>

      <div class="frmAbstandAA"></div>

      <input class="bigTextElem" type="text" name="frmInfoWoText" id="frmInfoWoText" />

      <div class="frmAbstandAA"></div>
      <div class="frmAbstandAA"></div>
      <div class="frmAbstandAA"></div>

      <input type="checkbox" name="frmSendSommerP" id="frmSendSommerP" value="Bitte senden Sie mir Sommer-Prospekte" /><label class="bigLblFrm" for="frmSendSommerP"><?php echo GAS_KONT_CHECKBOX_A; ?></label>

      <div class="frmAbstandAA"></div>

      <input type="checkbox" name="frmSendWinterP" id="frmSendWinterP" value="Bitte senden Sie mir Winter-Prospekte" /><label class="bigLblFrm" for="frmSendWinterP"><?php echo GAS_KONT_CHECKBOX_B; ?></label>

      <div class="frmAbstandAA"></div>

      <input type="checkbox" name="frmInfoGassner" id="frmInfoGassner" value="Ich möchte Informationen über die Gassner Geschenkgutscheine erhalten" /><label class="bigLblFrm" style="vertical-align:top" for="frmInfoGassner"><?php echo GAS_KONT_CHECKBOX_C; ?></label>
    </div>
    
    <div class="clearer"></div>
    
    <input type="submit" value="<?php echo GAS_KONT_SEND_BTN; ?>" />



    <div class="clearer"></div>

  </form>
</div>




<?php echo getLangJavascriptNow(); ?>




<script type="text/javascript">
function checkAnfrageDataAnfrageForm() {
  var errorTextAf = '';
  
  if ($('#frmAnreiseDate').val() == '') {
    $('#frmAnreiseDate').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_ANREISE+'<br />';
  }
  if ($('#frmAbreiseDate').val() == '') {
    $('#frmAbreiseDate').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_ABREISE+'<br />';
  }
  if ($('#frmAnzahlErwachsene').val() == '') {
    $('#frmAnzahlErwachsene').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_ANZAHL_ERWACHSENE+'<br />';
  }
  if ($('#frmAnrede').val() == '') {
    $('#frmAnrede').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_ANREDE+'<br />';
  }
  if ($('#frmSprache').val() == '') {
    $('#frmSprache').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_SPRACHE+'<br />';
  }
  if ($('#frmVorname').val() == '') {
    $('#frmVorname').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_VORNAME+'<br />';
  }
  if ($('#frmNachname').val() == '') {
    $('#frmNachname').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_NACHNAME+'<br />';
  }
  if ($('#frmMail').val() == '') {
    $('#frmMail').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_MAIL_NO+'<br />';
  }
  if ($('#frmMail').val() != '' && !checkMailAdressAnfrageFormHG($('#frmMail').val())) {
    $('#frmMail').addClass('inputErrorCode');
    errorTextAf += GAS_FEHLER_MAIL+'<br />';
  }
  
  if (errorTextAf != '') {
    $('.errorTextAusgabeAf').html(errorTextAf);
    $('html, body').animate({scrollTop: $('.errorTextAusgabeAf').offset().top - 150}, 500);
    return false;
  }
  else {
    return true;
  }
}



function checkMailAdressAnfrageFormHG(adress) {
  var validmailregex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.([a-z][a-z]+)|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
  return validmailregex.test(adress);
}



$(document).ready(function() {
  
  // Datepicker für Anfrageformular ********************************************
  // ***************************************************************************
  $('#frmAnreiseDate').datepicker({
    showOn: "both",
    minDate: "-0d",
    buttonImage: "templates/wildkogel/img/calendarIco.png",
    buttonImageOnly: true,
    dateFormat: "dd.mm.yy"
  });
  $('#frmAbreiseDate').datepicker({
    showOn: "both",
    minDate: "-0d",
    buttonImage: "templates/wildkogel/img/calendarIco.png",
    buttonImageOnly: true,
    dateFormat: "dd.mm.yy"
  });
  $('#frmAnreiseDateAlternat').datepicker({
    showOn: "both",
    minDate: "-0d",
    buttonImage: "templates/wildkogel/img/calendarIco.png",
    buttonImageOnly: true,
    dateFormat: "dd.mm.yy"
  });
  $('#frmAbreiseDateAlternat').datepicker({
    showOn: "both",
    minDate: "-0d",
    buttonImage: "templates/wildkogel/img/calendarIco.png",
    buttonImageOnly: true,
    dateFormat: "dd.mm.yy"
  });
  // ***************************************************************************
  
  
  
  // Focus für Anfrageformular *************************************************
  // ***************************************************************************
  $('.frmAnfrageHolder input').focus(function() {
    $(this).removeClass('inputErrorCode');
  });
  // ***************************************************************************
  
  
  
  // Toggler Pauschalen für Anfrageformular ************************************
  // ***************************************************************************
  $('#sommerPToggler').click(function() {
    $('#sommerPHolder').slideToggle(function() {
      if ($('#sommerPHolder').css('display') == 'none') {
        $('#sommerPToggler').removeClass('classTogglerUp');
      }
      else {
        $('#sommerPToggler').addClass('classTogglerUp');
      }
    });
  });
  $('#winterPToggler').click(function() {
    $('#winterPHolder').slideToggle(function() {
      if ($('#winterPHolder').css('display') == 'none') {
        $('#winterPToggler').removeClass('classTogglerUp');
      }
      else {
        $('#winterPToggler').addClass('classTogglerUp');
      }
    });
  });
  // ***************************************************************************
  
});
</script>