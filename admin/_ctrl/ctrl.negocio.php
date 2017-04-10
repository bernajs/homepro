<?php
session_start();
error_reporting(1);
require_once('../_class/class.negocio.php');
$obj = new Negocio();
switch($_POST['exec']) {
    case "save":
        $data = $_POST['data'];
        if(!$obj->isDuplicate($data['correo'])){
            $obj->set_nombre($data['nombre'])->
            set_correo($data['correo'])->
            set_movil($data['movil'])->
            set_telefono($data['telefono'])->
            set_id_zona($data['id_zona['])->
            set_id_servicio($data['id_servicio['])->
            set_contrasena($data['contrasena'])->
            set_informacion($data['informacion'])->
            set_status($data['1'])->
            set_created_at(date("Y-m-d H:i:s"))->
            db('insert');
            $result['status'] = 202;
            #ZONAS
    }else{
        $result['status'] = 409;
    }
    echo json_encode($result);
    break;
case "update":
    $data = $_POST['data'];
    $obj->set_nombre($data['nombre'])->
    set_correo($data['correo'])->
    set_movil($data['movil'])->
    set_telefono($data['telefono'])->
    set_id_zona($data['id_zona['])->
    set_id_servicio($data['id_servicio['])->
    set_contrasena($data['contrasena'])->
    set_informacion($data['informacion'])->
    set_status($data['status'])->
    set_modified_at(date("Y-m-d H:i:s"))->
    set_id($data['id'])->
    db('update');
    //$zonas = $data['id_zona[]'];
    //print_r($zonas);
    $result['status'] = 202;
    echo json_encode($result);
    break;
case "delete":
    $data = $_POST['data'];
    $obj->set_id($data['id'])->db('delete');
    $result['status'] = 202;
    echo json_encode($result);
    break;
case "approve":
    $data = $_POST['data'];
    $obj->set_id($data['id'])->db('approve');
    $result['status'] = 202;
    echo json_encode($result);
    break;
case "status": $obj->set_id($_POST['id'])->set_status($_POST['value'])->db('status');
    break;
case "get":
    $result = NULL;
    $data = $_POST['data'];
    $query = $obj->getNegocios($data['id']);
    if($query){
        $result['data'] = $query[0];
        $result['status'] = 202;
}else{
    $result['status'] = 404;
}
echo json_encode($result);
break;
case "datagrid":
    $data = $_POST['data'];
    $total = $obj->set_order('id DESC')->set_status(1)->getNegocios();
    $buffer = $obj->set_order('id DESC')->set_status(1)->set_limit($data['filter']['limit'])->getUsuario();
    $result['total'] = count($total);
    $result['pages'] = ceil($result['total']/$data['filter']['limit']);
    $result['tbody'] = $buffer;
    $result['status'] = 202;
    echo json_encode($result);
    break;
}
?>