<?php
require_once("class.db.php");

abstract class Helper {
  public $arrayCollection;
  public $lastInserted;
  public $limit;
  public $order;
  public $between;
  public $search;
  public $search_field;
  public $sql;
  public $debug;
  public $link;
  
  public function __construct(){ }

  public function __call($name, $arguments) {
    if(substr($name,0,4) == 'set_'){
      $property = substr($name,4);
      $this->$property = $arguments[0];	
    }
    return $this;
  }
  
  public function execute($query,$lid = NULL){
    $this->arrayCollection = NULL;
    $this->link = $this->sql->CONNECT();
    $result = $this->link->query($query) or die($this->link->error);
	if($lid){ $this->lastInserted = $this->link->insert_id; }
	if(!is_bool($result)){
      while($row = $result->fetch_assoc()) { $this->arrayCollection[] = $row; }
	  $this->link->close();
	  return $this->arrayCollection;   	  
	}else{
	  $this->link->close();
	  return true;	
	}
  }
  
  public function db_close(){ mysql_close(); }
  
  public function __get($field) {
    if($field == 'name') {
      return $this->username;
    }
  }  
  
  public function __set($field, $value) {
    if($field == 'name') {
      $this->username = $value;
    }
  }  
  
  
  function NlToBr($inString){
    return str_replace("<br />", "",$inString);
  }
  
  function formatDate($date,$format){
	
  $aux = explode("-",$date);
  $mes = NULL;
  switch($aux[1]){
    case "01": $mes = "Enero"; 
	break;
    case "02": $mes = "Febrero"; 
	break;
    case "03": $mes = "Marzo"; 
	break;
    case "04": $mes = "Abril"; 
	break;
    case "05": $mes = "Mayo"; 
	break;
    case "06": $mes = "Junio";
	break;	
    case "07": $mes = "Julio";
	break;  
    case "08": $mes = "Agosto";
	break;
    case "09":  $mes = "Septiembre";
	break;
    case "10":  $mes = "Octubre";
	break;
    case "11":  $mes = "Noviembre";
	break;
    case "12":  $mes = "Diciembre";
	break;
  }
  switch($format){
    case "min": return $aux[2]."-".substr(strtoupper($mes),0,3)."-".$aux[0]; 
	break;
	case "med": return $aux[2]."-".$mes."-".$aux[0]; 
	break;
	case "max": return $aux[2]." de ".$mes." del ".$aux[0]; 
	break;
	case "alt": return $aux[2]." ".substr($mes,0,3);
	break;
  }
  
 
}

function formatDateTime($date,$format){
  $temp = explode(" ",$date);
  $aux = explode("-",$temp[0]);
  $mes = NULL;
  switch($aux[1]){
    case "01": $mes = "Enero"; 
	break;
    case "02": $mes = "Febrero"; 
	break;
    case "03": $mes = "Marzo"; 
	break;
    case "04": $mes = "Abril"; 
	break;
    case "05": $mes = "Mayo"; 
	break;
    case "06": $mes = "Junio";
	break;	
    case "07": $mes = "Julio";
	break;  
    case "08": $mes = "Agosto";
	break;
    case "09":  $mes = "Septiembre";
	break;
    case "10":  $mes = "Octubre";
	break;
    case "11":  $mes = "Noviembre";
	break;
    case "12":  $mes = "Diciembre";
	break;
  }
  switch($format){
    case "min": return $aux[2]."-".substr(strtoupper($mes),0,3)."-".$aux[0]." ".$temp[1]; 
	break;
	case "med": return $aux[2]."-".$mes."-".$aux[0]." ".$temp[1];
	break;
	case "max": return $aux[2]." de ".$mes." del ".$aux[0]." ".$temp[1];
	break;
	case "alt": return $aux[2]." ".substr($mes,0,3)." ".$aux[0];
	break;
  }
}

  public function getHours($datetime){
    $day2 = strtotime(date("Y-m-d H:i:s"));
    $day1 = strtotime($datetime);
    $diffHours = round(($day2 - $day1) / 3600);
	return $diffHours;
  }

  
}
?>