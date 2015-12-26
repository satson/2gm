<?php

$html = file_get_contents('http://wildkogel-arena.at/newsletterTemplate.php');
 require_once('/home/icdigyfv/htdocs/admin/inc/klassen/mailChimpApi.inc.php');
		$api = new MCAPI('4b194645f469f7a824f6b105fb3b0663-us12');
                
               

		if($api->templateUpdate('24581',array('html'=>$html))) {
                    $response = 'OK';
		} else { 
                    $response =  $api->errorMessage;
                }	
             echo $response;