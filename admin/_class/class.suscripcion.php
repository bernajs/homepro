<?php

require_once("class.helper.php");

class Suscripcion extends Helper {
    var $id_negocio;
    var $fecha_inicio;
    var $fecha_fin;
    var $comentarios;
    var $created_at;
    var $status;
    var $modified_at;
    var $id;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO negocio_suscripcion (created_at,id_negocio,fecha_inicio,fecha_fin,comentarios,status)
                VALUES (
                '".$this->created_at."',
                '".$this->id_negocio."',
                '".$this->fecha_inicio."',
                '".$this->fecha_fin."',
                '".$this->comentarios."',
                '".$this->status."'
                )";
                break;
            case "update":
                $query = "UPDATE negocio_suscripcion
                SET
                zona='".$this->zona."',
                status='".$this->status."',
                modified_at='".$this->modified_at."'
                WHERE id=".$this->id;
                break;
            case "delete":
                //No debe de hacer una baja real, debe ser una baja logica
                $query = "DELETE FROM negocio_suscripcion WHERE id=".$this->id;
                break;
            
    }
    $lid = false;
    if($key=="insert"){ $lid = true; }
    $this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }

public function getData($id = NULL){
    $query = 'SELECT * FROM negocio_suscripcion WHERE id > 0';
    if($id!=NULL) $query.=" AND id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}
public function isDuplicate($zona){
    $query = 'SELECT id FROM cat_zona WHERE zona="'.$zona.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}
}
?>