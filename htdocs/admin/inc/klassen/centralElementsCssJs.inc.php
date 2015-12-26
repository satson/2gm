<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsCentralElementsCssJs extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen für CSS Datei bauen
  // ***************************************************************************
  public function buildOwnCentralElemsCssFile($cmsCentralPath) {
    $return = '';
    
    $curElementCount = $this->createNewOwnCentralElemsCssFile($cmsCentralPath);
    
    if ($curElementCount > 0) {
      $return .= '<link rel="stylesheet" href="css/centralElements.css" type="text/css" />';
    }
    
    return $return;
  }
  
  
  
  private function createNewOwnCentralElemsCssFile($cmsCentralPath) {
    $fileInhalt = '';
    
    $sqlText = 'SELECT * FROM velement WHERE elemCentralFolder <> ""';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlCount = mysql_num_rows($sqlErg);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (file_exists($cmsCentralPath.$row['elemCentralFolder'].'/element.css')) {
        $fileInhalt .= file_get_contents($cmsCentralPath.$row['elemCentralFolder'].'/element.css');
      }
    }
    
    file_put_contents('css/centralElements.css', $fileInhalt);
    
    return $sqlCount;
  }
  // ***************************************************************************
  // ENDE - Funktionen für CSS Datei bauen
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für JS Datei bauen
  // ***************************************************************************
  public function buildOwnCentralElemsJsFile($cmsCentralPath) {
    $return = '';
    
    $curElementCount = $this->createNewOwnCentralElemsJsFile($cmsCentralPath);
    
    if ($curElementCount > 0) {
      $return .= '<script type="text/javascript" src="js/centralElements.js"></script>';
    }
    
    return $return;
  }
  
  
  
  private function createNewOwnCentralElemsJsFile($cmsCentralPath) {
    $fileInhalt = '';
    
    $sqlText = 'SELECT * FROM velement WHERE elemCentralFolder <> ""';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlCount = mysql_num_rows($sqlErg);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (file_exists($cmsCentralPath.$row['elemCentralFolder'].'/element.js')) {
        $fileInhalt .= file_get_contents($cmsCentralPath.$row['elemCentralFolder'].'/element.js');
      }
    }
    
    file_put_contents('js/centralElements.js', $fileInhalt);
    
    return $sqlCount;
  }
  // ***************************************************************************
  // ENDE - Funktionen für JS Datei bauen
  // ***************************************************************************
  
}

?>