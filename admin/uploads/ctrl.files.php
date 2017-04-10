<?php
switch($_POST['exec']) {
  case "delete": 
    $data = $_POST['data'];
    unlink("../".$data['path']);
	echo "../".$data['path'];
	$result['status'] = 202;
  break;
}
?>
