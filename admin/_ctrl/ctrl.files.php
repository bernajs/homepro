<?php
switch($_POST['exec']) {
  case "delete": 
    $data = $_POST['data'];
    unlink("../".$data['path']);
	$result['status'] = 202;
	echo json_encode($result);
  break;
}
?>
