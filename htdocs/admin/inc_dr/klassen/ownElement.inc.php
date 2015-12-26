<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class ownElementsClass extends funktionsSammlung {
  
  private $siteElemArr = '';
  
  
  
  function __construct($siteElementArr) {
    $this->siteElemArr = $siteElementArr;
  } 
  
  

  public function setOwnElementDragDropHolder($prefix = '') {
    if (isset($this->siteElemArr) && is_array($this->siteElemArr)) {
      require_once('elemente_self.inc.php');
      $elemSelfObj = new cmsElementeSelf();
      return $elemSelfObj->setElemHolderInhaltLoad('curInElementHolder'.$this->siteElemArr['selemID'].$prefix, $this->siteElemArr['seitID'], 'noinherit');
    }
  }
  
}

?>