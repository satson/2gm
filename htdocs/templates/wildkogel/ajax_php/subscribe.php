<?php
 
 
        require_once('../../../admin/inc/klassen/subscribe.inc.php');
         $subscribe = new subscribe();  
         
         foreach($_POST['group'] as $key => $value){
             
             $groupsArr[] = $value['value'];
             
         }
         
         
         
        echo   $subscribe->mailChimpSubscribe(array('email'=>$_POST['_email'],'group'=>$groupsArr,'name'=>$_POST['name'],'surname'=>$_POST['surname']));

