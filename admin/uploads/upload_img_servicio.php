<?php
//print_r($_FILES);
$storeFolder = '/servicios';
if(!empty($_FILES)){
    $id = $_POST['id'];
    // $negocioFolder = $storeFolder.'/servicio_'.$nid.'_';
    if(!file_exists($storeFolder)) {
        mkdir($storeFolder, 0777, true);
    }
    #PROCESS UPLOAD
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) ."/". $storeFolder.'/servicio_'.$id.'_';
    $filename =  $_FILES['file']['name'];
    $targetFile =  $targetPath.$filename;
    move_uploaded_file($tempFile,$targetFile);
}