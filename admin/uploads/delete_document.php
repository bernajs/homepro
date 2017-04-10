<?php
$documento = $_POST['documento'];
$id = $_POST['id'];
$directorio = 'negocio/negocio_'.$id.'/';
$documentofinal = $directorio.$documento;

if (unlink($documentofinal)) {
    $result['status'] = 202;
    $result['redirect'] = 'index.php?call=negocio_detalle&id='.$id;
} else {
    $result['status'] = 0;
}
echo json_encode($result);