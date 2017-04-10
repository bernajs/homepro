<?php

require_once("class.helper.php");

class Zona extends Helper {
    var $zona;
    var $created_at;
    var $status;
    var $modified_at;
    var $id;
    var $id_ciudad;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO cat_zona (created_at,zona,status,id_ciudad)
                VALUES (
                '".$this->created_at."',
                '".$this->zona."',
                '".$this->status."',
                '".$this->id_ciudad."'
                )";
                break;
            case "update":
                $query = "UPDATE cat_zona
                SET
                zona='".$this->zona."',
                status='".$this->status."',
                id_ciudad='".$this->id_ciudad."',
                status='".$this->status."',
                modified_at='".$this->modified_at."'
                WHERE id=".$this->id;
                break;
            case "delete": $query = "DELETE FROM cat_zona WHERE id=".$this->id;
                break;
            
    }
    $lid = false;
    if($key=="insert"){ $lid = true; }
    $this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }

public function getData($id = NULL){
    $query = 'SELECT cat_zona.id, zona, id_ciudad, ciudad FROM cat_zona INNER JOIN cat_ciudad ON cat_zona.id_ciudad=cat_ciudad.id';
    // $query = 'SELECT * FROM cat_zona WHERE id > 0';
    if($id!=NULL) $query.=" AND cat_zona.id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}

public function zonaNegocio($id){
    $query = 'SELECT zona FROM negocio_zona
    INNER JOIN cat_zona ON negocio_zona.id_zona=cat_zona.id WHERE negocio_zona.id_negocio='.$id;
    return $this->execute($query);
}
public function isDuplicate($zona){
    $query = 'SELECT id FROM cat_zona WHERE zona="'.$zona.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}
}
?>