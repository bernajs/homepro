<?php
session_start();
if(!isset($_SESSION["onSessionAdmin"]) || is_null($_SESSION["onSessionAdmin"])){ header("Location: login.php"); }
$uid = $_SESSION['uid'];
if($uid > 0){
    include('_class/class.admin.php');
    $Admin = new Admin();
    $permisos = $Admin->get_permisos($uid);
    $permisos = json_decode($permisos[0]['permisos']);
    // $permisos = json_decode($permisos);
}