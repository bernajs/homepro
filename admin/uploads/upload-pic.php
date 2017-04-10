<?php
$storeFolder = 'servicios';
//print_r($_FILES);
print_r($_FILES);
if(!empty($_FILES)){
    #REMOVE ALL FILES
    //$files = glob(dirname( __FILE__ ) ."/". $storeFolder ."/*");
    //foreach($files as $file){ if(is_file($file)) unlink($file); }
    
    #PROCESS UPLOAD
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) ."/". $storeFolder ."/";
    // $date = explode(' ', date("Y-m-d H:i:s"));
    // $date = str_replace(array(' ', ':'),'-', $date);
    // $date = implode(' ', $date);
    // echo $date;
    // $datef = $date[0].''.$date[1];
    $filename =  $_FILES['file']['name'];
    $targetFile =  $targetPath.$filename;
    // unlink($targetFile);
    move_uploaded_file($tempFile,$targetFile);
    // chmod($targetFile, 0777);
}