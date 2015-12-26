<?php

class subscribe{
    
    
       public $mailChimpApiKey='4b194645f469f7a824f6b105fb3b0663-us12';
       public $mailChimpListId='0eff6ba7d7';
    
        public  function mailChimpSubscribe($data){
            
         
            
		if(!$data['email']){ return "No email address provided"; } 

		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $data['email'])) { 
			return "Email address is invalid"; 
		}
                
           
                
                
		require_once('/home/icdigyfv/htdocs/admin/inc/klassen/mailChimpApi.inc.php');
		$api = new MCAPI($this->mailChimpApiKey);
                
                $merge_vars = array('FNAME'=>$data['name'], 'LNAME'=>$data['surname']);
                
                
                
                if(in_array(1, $data['group'])){
                    if($api->listSubscribe('0eff6ba7d7', $data['email'], $merge_vars) === true) {
                       $response = 'Vielen Dank für Ihre Anmeldung. Sie erhalten in kürze eine E-Mail.';
                   } else { 
                       $response =  'Deine E-Mail Adresse ist schon im Newsletter eingetragen!';
                   }   
                    
                }

		
                
                
                
                if(in_array(2, $data['group'])){
                    if($api->listSubscribe('057fda416a', $data['email'], $merge_vars) === true) {
                       $response = 'Vielen Dank für Ihre Anmeldung. Sie erhalten in kürze eine E-Mail.';
                   } else { 
                       $response =  'Deine E-Mail Adresse ist schon im Newsletter eingetragen!';
                   }   
                    
                }
                
                return $response;
      
	}
	
	public function mailChimpUnsubscribe($data) {
		if(!$data['email']){ return "No email address provided"; } 

		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $data['email'])) { 
			return "Email address is invalid"; 
		}

		require_once('/var/www/system/library/MCAPI.class.php');
		$api = new MCAPI('YOUR_API_KEY');

		if($api->listUnsubscribe("YOUR_LIST", $data['email'])){
		  echo 'Success! Check your email to confirm sign up.';
          
			return 'Success! Check your email to confirm sign up.';
		} else { 
		  
          echo 'Error: ' . $api->errorMessage;  
			return 'Error: ' . $api->errorMessage; 
		}
	}

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

