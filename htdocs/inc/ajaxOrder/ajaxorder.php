<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


require_once('../db_connect.inc.php');
require_once('../functionsAll.inc.php');

require_once('../../admin/inc/klassen/order.inc.php');

if (isset($_POST['_art']) && !empty($_POST['_art'])) {

  switch ($_POST['_art']) {
    
   case 'setCommentToItem':
       $_SESSION['comment'][$_POST['itemKey']] = $_POST['comment'];
       
   break;    
    
    case 'addItem':
   
        $itemInBasket = false;
        $type   = $_POST['type'];
        $siteId = $_POST['siteid'];
        $fileId = $_POST['fileId'];
        $dropId = $_POST['dropid'];
        $target = $_POST['target'];
    
        if($type == 'site'){
            $_SESSION['basket'][$siteId][$siteId.'-'.$siteId] = array('id'=>$siteId,'target'=>$target,'type'=>$type,'itemkey' => $siteId.'-'.$siteId) ; 
        }elseif($type == 'dropdown'){
            $_SESSION['basket'][$siteId][$siteId.'-'.$dropId] = array('id'=>$dropId,'target'=>$target,'type'=>$type,'dropdown'=>$dropId,'itemkey'=>$siteId.'-'.$dropId) ;
        }else{
            $_SESSION['basket'][$siteId][$siteId.'-'.$fileId] =  array('id'=>$fileId,'target'=>$target,'type'=>$type,'fileid'=>$fileId,'itemkey'=>$siteId.'-'.$fileId) ;
        }
        $orders = new cmsOrderModul();
        echo $orders->countItemBasket();
        
    break; 
    
    case 'deleteItem':
        
       $itemKey   = $_POST['itemkey'];
        $siteIdArr = explode('-',$_POST['siteid']) ;
        
        
        foreach($_SESSION['basket'][$siteIdArr[0]] as $key => $value){
        
            if($key== $itemKey){
                
                unset($_SESSION['basket'][$siteIdArr[0]][$itemKey]);
                
            }
            
        }
        
        $orders = new cmsOrderModul();
        echo $orders->countItemBasket();
    break;    
     
    case 'listOrderItems':
   
      $orders = new cmsOrderModul();
      echo $orders->buildBasket();
        
    break;   


  }

}

?>