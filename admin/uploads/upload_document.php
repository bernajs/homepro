<?php
//print_r($_FILES);
$storeFolder = 'negocio';
print_r($_FILES);
if(!empty($_FILES)){
    #REMOVE ALL FILES
    $nid = $_POST['nid'];
    //$files = glob(dirname( __FILE__ ) ."/". $storeFolder ."/*");
    //foreach($files as $file){ if(is_file($file)) unlink($file); }
    $negocioFolder = $storeFolder.'/negocio_'.$nid;
    if(!file_exists($negocioFolder)) {
        mkdir($negocioFolder, 0777, true);
    }
    #PROCESS UPLOAD
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) ."/". $negocioFolder.'/';
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