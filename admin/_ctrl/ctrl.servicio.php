<?php
session_start();
require_once('../_class/class.servicio.php');
$obj = new Servicio();
switch($_POST['exec']) {
    case "save":
        $data = $_POST['data'];
        if(!$obj->isDuplicate($data['servicio'])){
            $obj->set_servicio($data['servicio'])->
            set_status($data['status'])->
            set_color($data['color'])->
            set_imagen($data['img'])->
            set_created_at(date("Y-m-d H:i:s"))->
            db('insert');
            $result['status'] = 202;
            $result['id'] = $obj->getLastInserted();
    }else{
        $result['status'] = 409;
    }
    echo json_encode($result);
    break;
case "update":
    $data = $_POST['data'];
    $obj->set_servicio($data['servicio'])->
    set_status($data['status'])->
    set_imagen($data['img'])->
    set_color($data['color'])->
    set_modified_at(date("Y-m-d H:i:s"))->
    set_id($data['id'])->
    db('update');
    $result['status'] = 202;
    $result['id'] = $data['id'];
    echo json_encode($result);
    break;
case "delete":
    $data = $_POST['data'];
    $obj->set_id($data['id'])->db('delete');
    $result['status'] = 202;
    echo json_encode($result);
    break;
case "status": $obj->set_id($_POST['id'])->set_status($_POST['value'])->db('status');
    break;
case "get":
    $result = NULL;
    $data = $_POST['data'];
    $query = $obj->getCiudades($data['id']);
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
    $total = $obj->set_order('id DESC')->set_status(1)->getUsuarios();
    $buffer = $obj->set_order('id DESC')->set_status(1)->set_limit($data['filter']['limit'])->getUsuario();
    $result['total'] = count($total);
    $result['pages'] = ceil($result['total']/$data['filter']['limit']);
    $result['tbody'] = $buffer;
    $result['status'] = 202;
    echo json_encode($result);
    break;
}
?>