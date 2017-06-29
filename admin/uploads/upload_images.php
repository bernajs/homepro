<?php
//print_r($_FILES);
$storeFolder = 'cotizacion';
if(!empty($_FILES)){
    #REMOVE ALL FILES
    $uid = $_POST['uid'];
    $img = $_POST['img'];
    //$files = glob(dirname( __FILE__ ) ."/". $storeFolder ."/*");
    //foreach($files as $file){ if(is_file($file)) unlink($file); }
    $cotizacionFolder = $storeFolder.'/usuario_'.$uid;
    if(!file_exists($cotizacionFolder)) {
        mkdir($cotizacionFolder, 0777, true);
    }
    #PROCESS UPLOAD
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) ."/". $cotizacionFolder.'/';
    // $date = explode(' ', date("Y-m-d H:i:s"));
    // $date = str_replace(array(' ', ':'),'-', $date);
    // $date = implode(' ', $date);
    // echo $date;
    // $datef = $date[0].''.$date[1];
    $filename =  $_FILES['file']['name'];
    $targetFile =  $targetPath.$img;
    echo $filename;
    // unlink($targetFile);
    move_uploaded_file($tempFile,$targetFile);
    // chmod($targetFile, 0777);
}
