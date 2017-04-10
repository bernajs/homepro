<?php

require_once("class.helper.php");

class Ciudad extends Helper {
    var $ciudad;
    var $created_at;
    var $status;
    var $modified_at;
    var $id;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO cat_ciudad (created_at,ciudad,status)
                VALUES (
                '".$this->created_at."',
                '".$this->ciudad."',
                '".$this->status."'
                )";
                break;
            case "update":
                $query = "UPDATE cat_ciudad
                SET
                ciudad='".$this->ciudad."',
                status='".$this->status."',
                modified_at='".$this->modified_at."'
                WHERE id=".$this->id;
                break;
            case "delete": $query = "DELETE FROM cat_ciudad WHERE id=".$this->id;
                break;
            
    }
    $lid = false;
    if($key=="insert"){ $lid = true; }
    $this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }

public function getCiudades($id = NULL){
    // $query = 'SELECT * FROM usuario WHERE id > 0';
    $query = 'SELECT * FROM cat_ciudad WHERE id > 0';
    if($id!=NULL) $query.=" AND id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
    
    // SELECT ciudad, id_negocio, zona FROM negocio_zona
    // INNER JOIN cat_zona ON negocio_zona.id_zona = cat_zona.id
    // INNER JOIN negocio ON negocio_zona.id_negocio = negocio.id
}
public function getVotoCiudades(){
    $query = 'SELECT * FROM voto_ciudad WHERE id > 0 AND status = 1';
    return $this->execute($query);
}
public function isDuplicate($ciudad){
    $query = 'SELECT id FROM cat_ciudad WHERE ciudad="'.$ciudad.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}
}
?>