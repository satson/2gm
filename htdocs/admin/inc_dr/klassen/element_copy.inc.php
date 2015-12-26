<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsElementeCopy extends funktionsSammlung {
  
  public function saveTheCurentCopyElementNow($selemID) {
    $_SESSION['VCMS_ELEM_COPY_ID'] = $selemID;
    return true;
  }
  
}

?>