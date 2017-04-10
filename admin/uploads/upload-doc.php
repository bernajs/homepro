<?php
$storeFolder = 'docs/'.$_GET['uid'];   
//print_r($_FILES);
if(!empty($_FILES)){
  if(!file_exists(dirname( __FILE__ ) ."/". $storeFolder)){
    mkdir(dirname( __FILE__ ) ."/". $storeFolder, 0777, true);
  }
  #PROCESS UPLOAD
  $tempFile = $_FILES['file']['tmp_name'];                    
  $targetPath = dirname( __FILE__ ) ."/". $storeFolder ."/";  
  
  $filename = $_FILES['file']['name'];
  $targetFile =  $targetPath.$filename; 
  echo $targetFile;
  move_uploaded_file($tempFile,$targetFile); 
  chmod($targetFile, 0777);
}

