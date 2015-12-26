<?php
 require_once '../inc/mailchimpApi.php';
 
 $json='{
    "apikey": "4b194645f469f7a824f6b105fb3b0663-us12",
    "type": "regular",
    "options": {
        "list_id": "057fda416a",
        "subject": "Täglicher Schnee- & Wetterbericht",
        "from_email": "example from_email",
        "from_name": "Wildkogel-Arena",
        "to_name": "*|FNAME|*",
        "title": "Newsletter '.date('Y-m-d').'",
    }
}';
 
 $arr = json_decode($json,true);
 
 
 $arr =  array(
     'apikey'=>'4b194645f469f7a824f6b105fb3b0663-us12',
     'type'  => 'regular',
     'options'=>array(
         'list_id'    =>'057fda416a',
         'subject'    =>'Täglicher Schnee- & Wetterbericht',
         'from_email' =>'info@wildkogel-arena.at',
         'from_name'  =>'Wildkogel-Arena',
         'to_name'    =>'*|FNAME|*',
         'title'      =>'Täglicher Schneebericht '.date('Y-m-d').'',
         'template_id'=>'24581'
     ),
     'content'=>array( 
         'html'=>''
     )
 );
 
 
 $api = new \Drewm\MailChimp('4b194645f469f7a824f6b105fb3b0663-us12');
 $response = $api->call('/campaigns/create',$arr);
 
 $campaignId = $response['id'];
 
 $arr = array(
    'apikey'        => '4b194645f469f7a824f6b105fb3b0663-us12',
    'cid'           => $campaignId,
    'schedule_time' => date('Y-m-d').' '.'08:30:00'
 );
 
$response = $api->call('/campaigns/schedule',$arr);
 

