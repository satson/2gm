<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/
 


class cmsOrderModul extends funktionsSammlung {
  
  
  public function getOrders($where){
   
     $return = '';
     $sqlText = 'SELECT * FROM vseitenorders '.$where;
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $orderArr[$rowPr['id_order']] = array('title'=>$rowPr['title'],'client'=>$rowPr['client_name'],'client_email'=> $row['client_email'],'status'=>$rowPr['status']);
      $orderArr[$rowPr['id_order']]['files'] = $this->getFilesInOrder($rowPr['id_order']);
    }
    
    
    
    return $orderArr;
   
  }
  
  public function getFilesInOrder($idOrder){
    
     $sqlText = 'SELECT id_of,id_order_of,id_file,bildFile FROM `vseitenorderfiles` JOIN vbilder ON id_file = bildID WHERE  id_order_of = '.$idOrder.'';
      $sqlErg = $this->dbAbfragen($sqlText);
      $filesArr = [];
      while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $filesArr[] = array('file'=>'user_upload/thumb_200/'.$rowPr['bildFile'],'id'=>$rowPr['id_of'],'name'=>$rowPr['bildFile'],'id_order'=>$rowPr['id_order_of'],'id_file'=>$rowPr['id_file']);
      }

      
    
      return  $filesArr;
      
      
  }
  
  public function getSelectListOrders(){
   
   $return = '';
   $orders = $this->getOrders();
   
   $return .= '<option value="">Wybierz</option>';
   
   foreach($orders as $key => $value){
    
     $return .= '<option value="'.$key.'">'.$value['title'].'</option>';
    
   }
   
   return $return;
   
  }
  
  public function getListOrders($where){
   
      
   $query = mysql_query("SELECT * FROM vhomepage  WHERE hpID=1");
   $row = mysql_fetch_array($query);
   $days = $row['hpOrderExpiredDay'];
   
   $return = '';
   $orders = $this->getOrders($where);
   
   $statusArr = array(1=>'New',2=>'Sended',3=>'Downloaded',4=>'Expired');
    
   foreach($orders as $key => $value){
    
     $return .= '<li>
	
		<div class="tab-orders tab-order-color'.$value['status'].'" id="order-'.$key.'">'.$value['title'].' <span id="status-'.$key.'"> ['.$statusArr[$value['status']].']</span>	</div>
	
		<div class="order-content">
			
			
				<ul class="order-info">
					<li>
						<p class="title">Information:</p> <p>[step4]</p>
					</li>
					<li>
						<p class="title">Email:</p> <p>[step4]</p>
					</li>
					
					<div style="clear:both;">
				</ul>
			
				<ul class="order-elements">';
                                foreach ($value['files'] as $key1 => $value1){
					$return .= '<li>
						<div class="order-element-img">
						
								<div class="vFrontImgVerwaltHolder"><div class="vFrontImgElement" data-id="1014">
									<div class="vFrontImgElementPic"><img src="'.$value1['file'].'" alt="" title=""></div>
									
									<div class="vFrontImgElementMenu">
									 
									  <div class="vFrontVerwPicElemShow" title="Anzeigen" data-img="user_upload/'.$value1['name'].'" rel="'.$key.'"></div>
									  <div class="clearer"></div>
									</div>
								  </div></div>
						
						</div>
						<div class="order-element-koment">
						
						<h4>File name: '.$value1['name'].'</h4>
						<p class="text"><strong>Comment:</strong> [step4]</p>
						
						</div>
						<div class="order-element-delete" data-id="'.$value1['id'].'" data-idfile="'.$value1['id_file'].'" data-idorder="'.$value1['id_order'].'" ><div></div></div>
						<div style="clear:both;">
					</li>';
                                }
					$return.='
					
					<div style="clear:both;">
				
				</ul>
				
				<ul class="order-list-form">
				
				<h4>Send order to user</h4>
				
				<li>
				<textarea placeholder="Type in an individual comment" name="comment" id="comment-'.$value1['id_order'].'"></textarea>
				</li>
				<li>Expire link after: <input type="text" name="days" id="days-'.$value1['id_order'].'"  value="'.$days.'"> days</li>
                                <li>Email: <input type="email" name="email" id="email-'.$value1['id_order'].'" class="require"></li>
				<li><input type="submit" class="zipFiles" data-idorder="'.$value1['id_order'].'" value="Zip files and send now"></li>
				
				</ul>
				
			
		</div>
		
		
	
	
	</li>';
    
   }
    
   return $return;
   
  }
  
    public function showHpOrderListWindowNow() {
    $return = '<div class="vFrontModulShopList">';
    $return .= '
	
	<div id="vFrontModulOrderNewBtn">
	
	<ul class="order-filters-top">
	
	<li>
	Status filter: <select id="ordersStatus"><option value="0">Choose</option><option value="1">New1</option><option value="2">Sended2</option><option value="3">Downloaded3</option><option value="4">Expired4</option></select>
	</li>
	<li>
	Find the order: <input type="text"  id="searchText">
        <input type="submit"  id="searchTextButton">
	</li>
	</ul>
	
	</div>
	
	';
    $return .= '<div class="clearer"></div>';
    $return .= '<div class="vFrontModulShopListHolder">';
	
	$return .= '
	
	<ul class="order-system-popup-list" id="ordersList">';
	
	
         $return .= $this->getListOrders();
	
	
	
	$return .= '</ul>
	
	';
	
   
    $return .= '</div>';
    $return .= '</div>';
    
    return $return;
  }
  
  public function saveFileToOrder($idOrder,$files,$newOrder=null,$type){
   
   $filesArr = explode(';',$files);
   
   if($newOrder != null){
  
     $query = mysql_query("INSERT INTO vseitenorders SET title='$newOrder'");
     $idOrder = mysql_insert_id();
   } 
   
    foreach($filesArr as $key => $value){
     
      $query = mysql_query("SELECT * FROM vseitenorderfiles WHERE id_file='$idOrder',id_file='$value'");
     
      if(mysql_num_rows($query) == 0){
        $query = mysql_query("INSERT INTO vseitenorderfiles SET id_order_of ='$idOrder',id_file='$value',type_file ='$type'");
      } 
  
    }
    
    echo 'ok';
    
   
  }
  
  
  public function deleFileInOrder($id,$idFile,$idOrder){
      
     $query = mysql_query("SELECT * FROM vseitenorderfiles WHERE id_of='$id' AND id_file='$idFile' AND id_order_of='$idOrder'"); 
  
     
     if(mysql_num_rows($query)==1){
         
        $query = mysql_query("DELETE FROM vseitenorderfiles WHERE id_of='$id' AND id_file='$idFile' AND id_order_of='$idOrder'");   
        
        if($query){
            echo 'ok';
        }else{
            echo 'fail'; 
        }
        
        
     }else{
         
         echo 'fail';
         
     }
     
      
      
      
  }
  
  
  public function sendFileToUser(){
     
     require_once('../../inc/klassen/phpmailer/class.phpmailer.php');
      
     $idOrder = mysql_escape_string($_POST['id']);
     $email  = mysql_escape_string($_POST['email']);     
     $days  =  mysql_escape_string($_POST['days']);  
     $comment = mysql_escape_string($_POST['comment']);
     
     
     $filesArr = $this->getFilesInOrder($idOrder);
      
     $mail = new PHPMailer;
    
    //$mail->isSendmail();
    $mail->setFrom('info@wildkogel-arena.at', 'info@wildkogel-arena.at');
    $mail->addAddress($email, $email);
    $mail->Subject = 'Zip files';
    $mail->msgHTML('Zip files');
   // $mail->AltBody = 'This is a plain-text message body';
   
    
    try {
         $zip = new ZipArchive;
         $fileName = 'my_order_'.$idOrder.'.zip';
         $codeOrder = $this->alphaID($idOrder.mktime(),false,false,  mktime().$idOrder).'-'.$idOrder;
         $zipFile  = '/home/icdigyfv/htdocs/user_upload_files/'.$fileName;
         $zipLink  =  'http://wildkogel-arena.at/get/'.$codeOrder; 
        if ($zip->open($zipFile,  ZipArchive::CREATE) ===TRUE) {
            
            foreach ($filesArr as $key => $value) {
                           
                $zip->addFile('/home/icdigyfv/htdocs/user_upload/'.$value['name'],$value['name']);
            }
            $zip->close();
            
            $expire = date('Y-m-d H:i:s', strtotime("+".$days." days"));
            
            $body.= 'Zip link: <a href="'.$zipLink.'">'.$zipLink.'</a><br>';  
            //$body.= 'Expire link after: '.$days.'<br>';   
            $body.= 'Expire date: '.$expire.'<br>';
            $body.= 'Comment: '.$comment.'<br>';   
            
            $mail->msgHTML($body);
            
           if ($mail->send()) {
               
               
               $query = mysql_query("UPDATE vseitenorders SET status = 2,expire_date='$expire',code='$codeOrder',zipFileName='$fileName' WHERE id_order='$idOrder'");
              echo 'OK';
           } else {
                echo "failed";
           }

        } else {
            echo 'Failed!';
        }
    } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
      
      
  }
  
  public function downloadFile($code){
   
      $codeArr = explode('-',$code);
      $code1   = $codeArr[0];
      $idOrder = $codeArr[1];
    
      $query = mysql_query("SELECT * FROM vseitenorders WHERE code = '$code' AND id_order='$idOrder' AND expire_date>CURRENT_TIMESTAMP()")or die(mysql_error());
      
      
      
      if(mysql_num_rows($query) == 1){
          
        $row = mysql_fetch_array($query);
        
        $fileName = $row['zipFileName'];
         $data = file_get_contents('user_upload_files/'.$fileName); // Read the file's contents
         
         $query = mysql_query("UPDATE vseitenorders SET status = 3 WHERE id_order='$idOrder'");
      
       // echo '/home/uzzdawwl/sunkid/user_upload_files/'.$fileName;
        $this->forceDownload($fileName,$data);
        
        return true;
          
      }else{
          
          return false;
          
      }
      
      
  }
  
  public function saveSettings($days){
    
      $query = mysql_query("UPDATE vhomepage SET hpOrderExpiredDay='$days' WHERE hpID=1");
      
      if($query){
          return true;
      }else{
          
          return false;
      }
      
      
  }
  
  function getSettingsForm(){
      
      $query = mysql_query("SELECT * FROM vhomepage  WHERE hpID=1");
      $row = mysql_fetch_array($query);
      $days = $row['hpOrderExpiredDay'];
      
      $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">Order settings</div>';
       $return .='<div class="vFrontFrmHolder"><label for="vFrontHpSeAllName">Expired days:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="days" id="vFrontHpSeAllName" value="'.$days.'">

           
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         
         <input style="width:150px;" type="submit" value="Speichern" class="saveSetting" data-id="1"></div>';
      
      return $return;
      
  }
  
 
  public function  alphaID($in, $to_num = false, $pad_up = false, $pass_key = null)
{
	$out   =   '';
	$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$base  = strlen($index);

	if ($pass_key !== null) {
		// Although this function's purpose is to just make the
		// ID short - and not so much secure,
		// with this patch by Simon Franz (http://blog.snaky.org/)
		// you can optionally supply a password to make it harder
		// to calculate the corresponding numeric ID

		for ($n = 0; $n < strlen($index); $n++) {
			$i[] = substr($index, $n, 1);
		}

		$pass_hash = hash('sha256',$pass_key);
		$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

		for ($n = 0; $n < strlen($index); $n++) {
			$p[] =  substr($pass_hash, $n, 1);
		}

		array_multisort($p, SORT_DESC, $i);
		$index = implode($i);
	}

	if ($to_num) {
		// Digital number  <<--  alphabet letter code
		$len = strlen($in) - 1;

		for ($t = $len; $t >= 0; $t--) {
			$bcp = bcpow($base, $len - $t);
			$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
		}

		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$out -= pow($base, $pad_up);
			}
		}
	} else {
		// Digital number  -->>  alphabet letter code
		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$in += pow($base, $pad_up);
			}
		}

		for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
			$bcp = bcpow($base, $t);
			$a   = floor($in / $bcp) % $base;
			$out = $out . substr($index, $a, 1);
			$in  = $in - ($a * $bcp);
		}
	}

	return $out;
}


public function forceDownload($filename = '', $data = '')
	{
    
   
		if ($filename == '' OR $data == '')
		{
			return FALSE;
		}

		// Try to determine if the filename includes a file extension.
		// We need it in order to set the MIME type
		if (FALSE === strpos($filename, '.'))
		{
                   
			return FALSE;
		}

		// Grab the file extension
		$x = explode('.', $filename);
		$extension = end($x);

		// Load the mime types
		$mimes = $this->getMimes();
           
		// Set a default mime if we can't find it
		if ( ! isset($mimes[$extension]))
		{
			$mime = 'application/octet-stream';
		}
		else
		{
			$mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
		}
            

		// Generate the server headers
		if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== FALSE)
		{
			header('Content-Type: "'.$mime.'"');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header("Content-Transfer-Encoding: binary");
			header('Pragma: public');
			header("Content-Length: ".strlen($data));
		}
		else
		{
			header('Content-Type: "'.$mime.'"');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header("Content-Transfer-Encoding: binary");
			header('Expires: 0');
			header('Pragma: no-cache');
			header("Content-Length: ".strlen($data));
		}

		exit($data);
	}

        
        private function getMimes(){
           
            
         return   $mimes = array(	'hqx'	=>	'application/mac-binhex40',
				'cpt'	=>	'application/mac-compactpro',
				'csv'	=>	array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
				'bin'	=>	'application/macbinary',
				'dms'	=>	'application/octet-stream',
				'lha'	=>	'application/octet-stream',
				'lzh'	=>	'application/octet-stream',
				'exe'	=>	array('application/octet-stream', 'application/x-msdownload'),
				'class'	=>	'application/octet-stream',
				'psd'	=>	'application/x-photoshop',
				'so'	=>	'application/octet-stream',
				'sea'	=>	'application/octet-stream',
				'dll'	=>	'application/octet-stream',
				'oda'	=>	'application/oda',
				'pdf'	=>	array('application/pdf', 'application/x-download'),
				'ai'	=>	'application/postscript',
				'eps'	=>	'application/postscript',
				'ps'	=>	'application/postscript',
				'smi'	=>	'application/smil',
				'smil'	=>	'application/smil',
				'mif'	=>	'application/vnd.mif',
				'xls'	=>	array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
				'ppt'	=>	array('application/powerpoint', 'application/vnd.ms-powerpoint'),
				'wbxml'	=>	'application/wbxml',
				'wmlc'	=>	'application/wmlc',
				'dcr'	=>	'application/x-director',
				'dir'	=>	'application/x-director',
				'dxr'	=>	'application/x-director',
				'dvi'	=>	'application/x-dvi',
				'gtar'	=>	'application/x-gtar',
				'gz'	=>	'application/x-gzip',
				'php'	=>	'application/x-httpd-php',
				'php4'	=>	'application/x-httpd-php',
				'php3'	=>	'application/x-httpd-php',
				'phtml'	=>	'application/x-httpd-php',
				'phps'	=>	'application/x-httpd-php-source',
				'js'	=>	'application/x-javascript',
				'swf'	=>	'application/x-shockwave-flash',
				'sit'	=>	'application/x-stuffit',
				'tar'	=>	'application/x-tar',
				'tgz'	=>	array('application/x-tar', 'application/x-gzip-compressed'),
				'xhtml'	=>	'application/xhtml+xml',
				'xht'	=>	'application/xhtml+xml',
				'zip'	=>  array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
				'mid'	=>	'audio/midi',
				'midi'	=>	'audio/midi',
				'mpga'	=>	'audio/mpeg',
				'mp2'	=>	'audio/mpeg',
				'mp3'	=>	array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
				'aif'	=>	'audio/x-aiff',
				'aiff'	=>	'audio/x-aiff',
				'aifc'	=>	'audio/x-aiff',
				'ram'	=>	'audio/x-pn-realaudio',
				'rm'	=>	'audio/x-pn-realaudio',
				'rpm'	=>	'audio/x-pn-realaudio-plugin',
				'ra'	=>	'audio/x-realaudio',
				'rv'	=>	'video/vnd.rn-realvideo',
				'wav'	=>	array('audio/x-wav', 'audio/wave', 'audio/wav'),
				'bmp'	=>	array('image/bmp', 'image/x-windows-bmp'),
				'gif'	=>	'image/gif',
				'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
				'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
				'jpe'	=>	array('image/jpeg', 'image/pjpeg'),
				'png'	=>	array('image/png',  'image/x-png'),
				'tiff'	=>	'image/tiff',
				'tif'	=>	'image/tiff',
				'css'	=>	'text/css',
				'html'	=>	'text/html',
				'htm'	=>	'text/html',
				'shtml'	=>	'text/html',
				'txt'	=>	'text/plain',
				'text'	=>	'text/plain',
				'log'	=>	array('text/plain', 'text/x-log'),
				'rtx'	=>	'text/richtext',
				'rtf'	=>	'text/rtf',
				'xml'	=>	'text/xml',
				'xsl'	=>	'text/xml',
				'mpeg'	=>	'video/mpeg',
				'mpg'	=>	'video/mpeg',
				'mpe'	=>	'video/mpeg',
				'qt'	=>	'video/quicktime',
				'mov'	=>	'video/quicktime',
				'avi'	=>	'video/x-msvideo',
				'movie'	=>	'video/x-sgi-movie',
				'doc'	=>	'application/msword',
				'docx'	=>	'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'xlsx'	=>	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'word'	=>	array('application/msword', 'application/octet-stream'),
				'xl'	=>	'application/excel',
                'xls'	=>	array('application/octet-stream','application/excel','application/vnd.ms-excel'),
				'eml'	=>	'message/rfc822',
				'json' => array('application/json', 'text/json'),
                  'flv'    =>    array('video/x-flv', 'flv-application/octet-stream', 'application/octet-stream'),
                   'FLV' =>    array('video/x-flv', 'flv-application/octet-stream', 'application/octet-stream'),    
			);
         
            
        }
        
        
        ///////////////////front orders basket////////////////////////////
        
        
        public function getItems(){
            
           
                       
            foreach($_SESSION['basket'] as $key => $value){
                  foreach($value as $key1 => $value1){
                
                       switch($value1['type']){
                            case 'site':
                            
                            $dataArr[$value1['target']][$key1] =  $this->getSite($key,$value1['itemkey']);
                            break;
                             case 'dropdown':

                            $dataArr[$value1['target']][$key1]  =  $this->getDropDown($key,$value1['dropdown'],$value1['itemkey']);
                            break;
                            case 'file':
                            //  print_r($_SESSION['basket']);
                             $dataArr[$value1['target']][$key1]  = $this->getFile($key,$value1['fileid'],$value1['itemkey']); 
                            break;
                      }
                  }

            }
         
            return $dataArr;
        }
        
        public function buildBasket($tpl = 'cart'){
                            
            $confCart = array('title'=>array('id_element'=>12,'item'=>'elemText1'),'desc'=>array('id_element'=>75,'item'=>'elemText2'),'img'=>array('id_element'=>74,'item'=>'gallery'));
            $basketArr = $this->getItems($type);
            
                            
            
            
            $confCart[12] = array('title'=>'elemText2','title1'=>'elemText1','desc'=>'elemText3','img'=>'gallery');
            $confCart[18] = array('title'=>'elemText2','title1'=>'elemText1','desc'=>'elemText3','img'=>'gallery');
            $confCart[14] = array('title'=>'elemText3','title1'=>'elemText1','desc'=>'elemText4','img'=>'gallery');
            $confCart[20] = array('title'=>'elemText1','title1'=>'elemText1','desc'=>'1','img'=>'gallery');
            $confCart[9]  = array('title'=>'elemText1','title1'=>'elemText1','desc'=>'elemText2','img'=>'background');
            
            foreach($basketArr as $key => $value){
                if($key != ''){
                
                $query = mysql_query("SELECT * FROM vtabbasket WHERE id='$key'");
                $row = mysql_fetch_array($query);
                $tabName = $row['name'];
               
                if($tpl == 'cart'){

                $html.='<div  id="tab-'.$key.'">';
		$html .='<h2 class="merklisteItemHeader" >'.$tabName.'</h2>';
                foreach ($value as $key1 => $value1){
                            
                    
                    if(key($value1) != ''){
                            
                   if($value1['type']=='site'){
                            
                        $title = $value1[key($value1)]['text']->{$confCart[key($value1)]['title']};
                        $title1 = $value1[key($value1)]['text']->{$confCart[key($value1)]['title1']};
                        
                        $desc =  $value1[key($value1)]['text']->{$confCart[key($value1)]['desc']};
                        $desc = (strlen($desc) > 300)?substr(strip_tags( $desc), 0,300).'...':$desc;
                        $desc = '<p>'.$desc.'</p>';
                        $img = $value1[key($value1)][$confCart[key($value1)]['img']][0]['bildFile'];
                        $imgTitle = $value1[$confCart['img']['id_element']][$confCart['img']['item']][0]['bildTitel']; 
                        $url = $value1[key($value1)]['url'];
                   }elseif ($value1['type'] == 'dropdown') {
                   
                        $title = $value1[key($value1)]['text']->elemText1;
                        $desc = '';
                        $img = ($value1[key($value1)]['gallery'][0]['bildFile'])?$value1[key($value1)]['gallery'][0]['bildFile']:$value1[key($value1)]['image'][0]['bildFile'];
                        $imgTitle = $value1[key($value1)][$confCart['img']['item']][0]['bildTitel'];
                         $url = $value1[key($value1)]['url'];
                   }elseif($value1['type'] == 'file'){
                      // print_r($value1);
                       $img = $value1[key($value1)]['image'];
                       $title = $value1[key($value1)]['text'];
                       $url = $value1[key($value1)]['url'];
                   }
                   
                   
                }
                    
                    $html.='<div class="merklisteItem"><div class="merklisteItemContent" id="'.$value1['itemkey'].'">
					
					<div class="merklisteLeftPanel">
						<div class="panel panelLarge panelPhoto giveMeBackground">';
                                                if($img != ''){
                                                  if(key($value1) == 9 ){
                                                       $html.='<img class="hereIsYourBackgroud imageBigBanner " src="/user_upload/'.$img.'" title="'.$imgTitle.'">';
                                                  }else{
                                                      $html.='<img class="hereIsYourBackgroud " src="/user_upload/'.$img.'" title="'.$imgTitle.'">';
                                                  }                                                    						  
                                                }
						$html.= '<div class="panelTitle">
								'.$title1.'
							</div>
						</div>
					</div>';
                            
                                       if($_POST['VCMS_POST_LANG'] == 'de' || $_POST['VCMS_POST_LANG'] == ''){
                                           $html.= '<div class="merklisteRightPanel">
						<span class="panelClose"></span>
						<h2>'.$title.'</h2>
						'.$desc.'
						<div class="merklistItemLinks">
						<a href="/de/'.$url.'" class="firstMerklisteItemLink" target="_blank">mehr Informationen</a>
						<a href="javascript:void(0)" class="secondMerklisteItemLink">Notiz hinzufügen</a>
                                                <a href="javascript:void(0)"  data-idsite="'.$key1.'" data-type="'.$value1['type'].'" data-itemkey="'.$value1['itemkey'].'" class="loschen">löschen</a>
						</div>
						<div class="kommentarBox">
							<textarea placeholder="Bitte geben Sie hier Ihren Text ein..." data-itemkey="'.$value1['itemkey'].'" class="comment" id="note-'.$value1['itemkey'].'">'.$_SESSION['comment'][$value1['itemkey']].'</textarea>
							<span class="kommentarBoxClose" >schließen</span>
						</div>
					</div>';
                                       }elseif($_POST['VCMS_POST_LANG'] == 'en'){
                                           
                                           $html.= '<div class="merklisteRightPanel">
						<span class="panelClose"></span>
						<h2>'.$title.'</h2>
						'.$desc.'
						<div class="merklistItemLinks">
						<a href="/en/'.$url.'" class="firstMerklisteItemLink" target="_blank">More information</a>
						<a href="javascript:void(0)" class="secondMerklisteItemLink">Add note</a>
                                                <a href="javascript:void(0)"  data-idsite="'.$key1.'" data-type="'.$value1['type'].'" data-itemkey="'.$value1['itemkey'].'" class="loschen">Delete</a>
						</div>
						<div class="kommentarBox">
							<textarea placeholder="Bitte geben Sie hier Ihren Text ein..." data-itemkey="'.$value1['itemkey'].'" id="note-'.$value1['itemkey'].'" class="comment">'.$_SESSION['comment'][$value1['itemkey']].'</textarea>
							<span class="kommentarBoxClose" data-itemKey="'.$value1['itemkey'].'">Close</span>
						</div>
					</div>';
                                       }        
					
                                        

                                     $html.= '</div><div style="clear:both;" ></div></div>
                                        ';
                }
                
                }else{
                    
                    
                    $html.='<div class="merklisteItem">';
                foreach ($value as $key1 => $value1){
                 
                   if($value1['type']=='site'){
                            
                        $title = $value1[key($value1)]['text']->{$confCart[key($value1)]['title']};
                        $title1 = $value1[key($value1)]['text']->{$confCart[key($value1)]['title1']};
                        
                        $desc =  $value1[key($value1)]['text']->{$confCart[key($value1)]['desc']};
                        $desc = (strlen($desc) > 300)?substr(strip_tags( $desc), 0,300).'...':$desc;
                        $desc = '<p>'.$desc.'</p>';
                        $img = $value1[key($value1)][$confCart[key($value1)]['img']][0]['bildFile'];
                        $imgTitle = $value1[$confCart['img']['id_element']][$confCart['img']['item']][0]['bildTitel']; 
                        $url = $value1[key($value1)]['url'];
                   }elseif ($value1['type'] == 'dropdown') {
                   
                        $title = $value1[key($value1)]['text']->elemText1;
                        $desc = '';
                        $img = ($value1[key($value1)]['gallery'][0]['bildFile'])?$value1[key($value1)]['gallery'][0]['bildFile']:$value1[key($value1)]['image'][0]['bildFile'];
                        $imgTitle = $value1[key($value1)][$confCart['img']['item']][0]['bildTitel'];
                         $url = $value1[key($value1)]['url'];
                   }elseif($value1['type'] == 'file'){
                      // print_r($value1);
                       $img = $value1[key($value1)]['image'];
                       $title = $value1[key($value1)]['text'];
                       $url = $value1[key($value1)]['url'];
                   }
                   
                    
                    $html.='<div class="merklisteItemContent" id="'.$value1['itemkey'].'">
                        <div class="itemContentUpper"><div class="upperLeft">';
                                if($img == ''){
                                   //$html.=' <img src="http://sunkid.2getmore-server.com//admin/img/noImg.png">'; 
                                }else{
                                   // $html.=' <img src="http://sunkid.2getmore-server.com//user_upload/thumb_200/'.$img.'" title="'.$imgTitle.'">';
                                }
                                
                                
                                if($_POST['VCMS_POST_LANG'] == ''){
                                    $lang = 'de';
                                }else{
                                    $lang = $_POST['VCMS_POST_LANG'];
                                }
                                
                                   
				$html.='</div>
				<div class="upperCenter">
                                    <h2><a href="http://wildkogel-arena.at/'.$lang.'/'.$url.'">'.$title.'</a></h2>
				    <p>'.$desc.'</p>';
                                        if($_SESSION['comment'][$value1['itemkey']] !=''){
                                            
                                         $html.=	'<p>'
                                                 . 'Kommentar: '.$_SESSION['comment'][$value1['itemkey']].'</p>';   
                                            
                                        }


					$html.=	'</div>
						
					</div>
                                        
                                        </div>';
                    
                }
                    
                }
                
                $html.='</div></div>';
            }
            }
           
            if($tpl == 'cart'){
                $filtr[] = 'Positionen Filtern nach: alles <a href="javascript:void(0):" data-tabid="all" class="filterTabs"> Anzeigen </a>';
                $query = mysql_query("SELECT * FROM vtabbasket");
                
                while($row = mysql_fetch_array($query)){ 
                    if(key_exists($row['id'], $basketArr)){
                    $filtr[]='<a href="javascript:void(0):" data-tabid="'.$row['id'].'" class="filterTabs"> '.$row['name'].' </a>';
                    }
                }

                return json_encode(array('html'=>$html,'filtr'=>implode('|',$filtr) )) ;
            }else{
               return  $html;  
            }
           
            
        }
        
        
        
        public function getSite($idSite,$itemKey=''){
                       
            $elementsArr = array(9,12,14,18,20);      
            require_once 'site.class.php';
            
            
                            
           
            $siteObj = new siteLibrary();
            foreach($elementsArr as $key => $value){
               $data = $siteObj->mmGetSiteListDataArrayOnce($idSite,$value);
               
               if(!empty($data['detailElemData'])){
                   $siteArr[$value][] = $data; 
               } 
              
            }
                 
            
            foreach($siteArr as $key => $value){
                foreach($value as $key1 => $value1){
                    
                    if($value1['seitBackImages'] != ''){
                        $imagesArr = explode(';',$value1['seitBackImages']);
                        $idBg = $imagesArr[0];
                        $query = mysql_query("SELECT * FROM vbilder WHERE  bildID = '$idBg'");
                        $row = mysql_fetch_array($query);
                        $bg[0]['bildFile'] = $row['bildFile'];
                   
                    }
                    
                    $return[$value1['detailElemData']['elemID']] = array('url'=>$value1['seitTextUrl'],'text'=>  json_decode($value1['detailElemData']['selemInhalt']),'gallery'=>$value1['detailElemData']['gallery'],'background'=>$bg);
                    $return['type'] = 'site';
                }   $return['itemkey'] = $itemKey;
            }
        
          
          
            return $return; 
        }
                
           
             
            
     
        
        
        
        public function  getDropDown($idSite,$idDropDown='',$itemKey=''){
            
            $dropConfig = array();
            require_once 'site.class.php';
          
            $siteObj = new siteLibrary();
            $drop =  $siteObj->getElemDataBySelemId($idSite,$idDropDown);
            
            $site = $siteObj->getCurSiteNameBySiteIdOnlyMM($idSite);
             
            if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
                $siteL = $siteObj->getSiteByLang($idSite,$_POST['VCMS_POST_LANG']);
                $site['name'] = ($siteL['name']!='')?$siteL['name']:$site['name'];
                $site['url'] = ($siteL['url']!='')?$siteL['url']:$site['url'];
            }
          
            $query = mysql_query("SELECT * FROM `vseitenelemente` WHERE selemDataName='curInElementHolder$idDropDown' AND selemConfig LIKE '%picGal%' AND selemID != '$idDropDown' ORDER BY selemPosition ASC LIMIT 1");
            if(mysql_num_rows($query)){
                
                $row = mysql_fetch_array($query);
                $selemId= $row['selemID'];
                
                $subDrop =  $siteObj->getElemDataBySelemId($idSite,$selemId);
          
            }
          
            $return[$idDropDown] = array('url'=>$site['url'],'text'=>  json_decode($drop['selemInhalt']),'gallery'=>$subDrop['gallery'],'images'=>$subDrop['images'],'siete_name'=>$site['name']);
            $return['type'] = 'dropdown';
            $return['itemkey'] = $itemKey;
          
            return $return;
        }
        
        
        public function getFile($idSite,$idFile,$itemkey){
          
             require_once 'site.class.php';
          
            $siteObj = new siteLibrary();
            $img =  $siteObj->getPicOnceDataByIdMM($idFile);
            
            $site = $siteObj->getCurSiteNameBySiteIdOnlyMM($idSite);
             
            if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
                $siteL = $siteObj->getSiteByLang($idSite,$_POST['VCMS_POST_LANG']);
                $site['name'] = ($siteL['name']!='')?$siteL['name']:$site['name'];
                $site['url'] = ($siteL['url']!='')?$siteL['url']:$site['url'];
            }
           
            $return[$idFile] = array('url'=>$site['url'],'text'=> $img['bildTitel'],'gallery'=>$subDrop['gallery'],'image'=>$img['bildName'],'siete_name'=>$site['name']);
           
           $return['type'] = 'file'; 
           $return['itemkey'] = $itemkey;  
           
         
           
            return $return;
        }
        
        
       public function listTabBasket(){
      
      
          $return = '<div class="vFrontHpSeAuflistung">';
          
          $return .= '<div class="vFrontHpSeAuflistungUnUe">Basket Tabs</div>';
          $return .= '<div id="vFrontNewTab">Neues Tab</div><div class="clearer"></div>';
    
            $sqlTextS = "SELECT * FROM vtabbasket ";
            $sqlErgS = $this->dbAbfragen($sqlTextS);
    
            while($rowElE = mysql_fetch_array($sqlErgS, MYSQL_ASSOC)) {
              $return .= '<div class="vFrontHpSeAuflistungLiLay">';
              $return .= '<div class="vFrontHpSeAuflistungLiLayName"  >' . $rowElE['name'] . '-'.$rowElE['type'].'</div>';
              //$return .= '<div class="vFrontEditTab" data-id="' . $rowElE['id'] . '" title="Bearbe
                $return .= '<div id="vFrontDelTab" data-id="' . $rowElE['id'] . '" title="Löschen"></div>';

              $return .= '</div>';
            }
          
          $return.='</div>';
              
      
      return $return;
      
  }
  
  
  public function addTabBasket(){
    
          $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">New Tab</div><div class="vFrontFrmHolder"><label for="vFrontHpSeSiteLayoutName">Name:</label>
         <div class="vFrontLblAbstand"></div>
         <input type="text" name="tabName" id="nameTab" style="width:275px;" />

         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><label for="vFrontHpSeSiteLayoutDatei">Type:</label>
         <div class="vFrontLblAbstand"></div>
        
 <input type="radio" name="typeTab" value="order" id="vFrontHpSeSiteLayoutDatei" checked="checked" /> Order
 <input type="radio" name="typeTab" value="request" id="vFrontHpSeSiteLayoutDatei"  /> Request


         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:135px;" type="submit" value="Speichern" id="vFrontSaveNewTab" />
         <input style="width:135px; background-color:#C0392B; margin-left:15px;" type="submit" value="Abbrechen" id="vFrontCanceNewTab" /></div>';
              
      
      return $return;
      
  }
  
  
  public function getOrderToEmail(){
    $body = $this->buildBasket('mail'); 
    return  $body;
  }
  
  
  public function saveOrderTab($name){
                            
     $items =  $this->getItems();
     $query = mysql_query("SELECT * FROM `vtabbasket` WHERE type='order'");
     while($row = mysql_fetch_array($query)){
         $itemsArr[] = $items[$row['id']];
     }       

     foreach($itemsArr as $key => $value){
         foreach($value as $key1 => $value1){
              if($value1['type'] == 'file'){        
                      $imagesArr[] = $key1;
               }elseif($value1['type'] == 'dropdown'){
                   $idDrop = key($value1);
                   $query = mysql_query("SELECT * FROM `vseitenelemente` WHERE selemDataName='curInElementHolder$idDrop'  AND selemID != '$key1' AND elemID=90");
                    if(mysql_num_rows($query)){

                      while($row = mysql_fetch_array($query)){
                          $idGallery = $row['selemPicGal'];
                          $query1  = mysql_query("SELECT * FROM vbildergalerien WHERE galID = $idGallery");
                          $row1    = mysql_fetch_array($query1);
                          $images = explode(';',$row1['galBilder']) ;
                       
                          foreach($images as $key3 => $value3){
                              $imagesArr[] = $value3;
                          }
                      }      
                   }
               } 
         }

     }
;
     $query = mysql_query("INSERT INTO vseitenorders SET title='$name'");
     $idOrder = mysql_insert_id();

     foreach($imagesArr as $key => $value){
        $idFileArr = explode('-',$value);
        $idFile = $idFileArr[1];
         
        $query = mysql_query("INSERT INTO vseitenorderfiles SET id_order_of ='$idOrder',id_file='$idFile',type_file ='$type'");
     }
   
}
  
  
  
  
  
  
  public function saveNewTab() {
      $name = mysql_escape_string($_POST['nameTab']);
      $type = mysql_escape_string($_POST['typeTab']);
      
      $query = mysql_query("INSERT INTO vtabbasket SET name='$name',type='$type'");
      
      if($query){
          echo 'ok';
      }else{
          return false;
      }
      
  }
  
  public function deleteTab() {
              
      $id = mysql_escape_string($_POST['id']);
      
      $query = mysql_query("DELETE FROM vtabbasket WHERE id='$id'");
      
      if($query){
          echo 'ok';
      }else{
          return false;
      }
      
  }
  
   public function countItemBasket(){
     //  print_r($_SESSION['basket']);
       
       $i=0;
       foreach($_SESSION['basket'] as $key => $value){
           foreach($value as $eky1 => $value1){
                if(!empty($value1)){
                    $i++;
                }
            }    
       }
      return $i;   
   }   
      
   
   public function checkOrderTypes(){
                            
       foreach($_SESSION['basket'] as $key => $value){
           foreach($value as $eky1 => $value1){
              $targets[] = $value1['target'];             
            }    
       }
       
       $return = '';
       $targetArr = array_unique($targets);
       if(!empty($targetArr)){
          foreach($targetArr as $key => $value){
                            
            $query = mysql_query("SELECT * FROM `vtabbasket` WHERE id='$value'");
            $row   = mysql_fetch_array($query);
            $return[]= $row['type'];
          } 
          
          return json_encode($return); 
       }
       
       return;
      
   }
   
      
  }


?>