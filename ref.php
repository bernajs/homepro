<?php
require_once("admin/_class/class.usuario.php");
$obj = new Usuario();
$oid = $_REQUEST['oid'];
$uid = $_REQUEST['uid'];
$device = $_REQUEST['device'];
if($device == null || $device == ''){$device = 'android';}
$obj->set_uid($uid)->set_oid($oid)->set_device($device)->db('update_onesignal_id');
print_r($_REQUEST);
echo 1;
?>
