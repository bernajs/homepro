<?php

require_once("class.helper.php");

class Requerimiento extends Helper {
    var $id_negocio;
    var $id_usuario;
    var $descripcion;
    var $fecha_atn;
    var $status;
    var $created_at;
    var $modified_at;
    var $id;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO requerimiento (created_at,id_usuario,descripcion,fecha_atn,status)
                VALUES (
                '".$this->created_at."',
                '".$this->id_usuario."',
                '".$this->descripcion."',
                '".$this->fecha_atn."',
                '".$this->status."'
                )";
                break;
            case "update":
                if ($this->status == 1) {
                    $query = "DELETE FROM requerimiento WHERE id=".$this->id;
            }
            break;
        case "delete": $query = "DELETE FROM requerimiento WHERE id=".$this->id;
            break;
        
}
$lid = false;
if($key=="insert"){ $lid = true; }
$this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }

public function getData($id = NULL){
    $query = "SELECT descripcion, fecha_atn, requerimiento.id, requerimiento.status, usuario.nombre, cat_servicio.servicio FROM requerimiento
    INNER JOIN usuario ON requerimiento.id_usuario = usuario.id
    INNER JOIN cat_servicio ON requerimiento.id_servicio = cat_servicio.id
    WHERE requerimiento.id > 0";
    // $query = 'SELECT * FROM requerimiento WHERE id > 0 AND leido = 0';
    if($id!=NULL) $query.=" AND requerimiento.id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}
}
?>