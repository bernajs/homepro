<?php

require_once("class.helper.php");

class Testimonio extends Helper {
    var $id_negocio;
    var $id_usuario;
    var $tipo;
    var $testimonio;
    var $status;
    var $created_at;
    var $modified_at;
    var $id;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO negocio_testimonio (created_at,id_negocio,status)
                VALUES (
                '".$this->created_at."',
                '".$this->id_negocio."',
                '".$this->status."'
                )";
                break;
            case "update":
                $query = "UPDATE negocio_testimonio
                SET
                status='".$this->status."'
                WHERE id=".$this->id;
                break;
            case "approve":
                $query = "UPDATE negocio_testimonio
                SET
                status='1'
                WHERE id=".$this->id;
                break;
            case "delete": $query = "DELETE FROM negocio_testimonio WHERE id=".$this->id;
                break;
            
    }
    $lid = false;
    if($key=="insert"){ $lid = true; }
    $this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }

public function getData($id = NULL){
    $query = "SELECT calificacion, usuario.nombre AS unombre, negocio.nombre AS nnombre, tipo, testimonio, negocio_testimonio.status, negocio_testimonio.id AS id FROM negocio_testimonio
    INNER JOIN negocio
    ON negocio_testimonio.id_negocio = negocio.id
    INNER JOIN usuario
    ON negocio_testimonio.id_usuario = usuario.id
    WHERE negocio_testimonio.status = 0";
    // $query = 'SELECT * FROM negocio_testimonio WHERE id > 0 AND leido = 0';
    if($id!=NULL) $query.=" AND negocio_testimonio.id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}

public function getNegocioTestimonio($id){
    $query = "SELECT usuario.nombre AS unombre, negocio.nombre AS nnombre, tipo, testimonio, negocio_testimonio.status, negocio_testimonio.id AS id FROM negocio_testimonio
    INNER JOIN negocio
    ON negocio_testimonio.id_negocio = negocio.id
    INNER JOIN usuario
    ON negocio_testimonio.id_usuario = usuario.id
    WHERE negocio_testimonio.status = 0";
    // $query = 'SELECT * FROM negocio_testimonio WHERE id > 0 AND leido = 0';
    if($id!=NULL) $query.=" AND negocio_testimonio.id_negocio=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}
}
?>