<?php

require_once("class.helper.php");

class Servicio extends Helper {
    var $servicio;
    var $imagen;
    var $color;
    var $created_at;
    var $status;
    var $modified_at;
    var $tags;
    var $id;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO cat_servicio (created_at,servicio,imagen,color,tags,status)
                VALUES (
                '".$this->created_at."',
                '".$this->servicio."',
                '".$this->imagen."',
                '".$this->color."',
                '".$this->tags."',
                '".$this->status."'
                )";
                break;
            case "update":
                $query = "UPDATE cat_servicio
                SET
                servicio='".$this->servicio."',
                status='".$this->status."',
                imagen='".$this->imagen."',
                color='".$this->color."',
                tags='".$this->tags."',
                modified_at='".$this->modified_at."'
                WHERE id=".$this->id;
                break;
            case "delete": $query = "DELETE FROM cat_servicio WHERE id=".$this->id;
                break;
            
    }
    $lid = false;
    if($key=="insert"){ $lid = true; }
    $this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }


public function getServicioDetalle($id, $zona=null){
    $query = "SELECT servicio, imagen, nombre, correo, movil, telefono, informacion, negocio.id FROM negocio_servicio
    INNER JOIN cat_servicio ON negocio_servicio.id_servicio=cat_servicio.id
    INNER JOIN negocio ON negocio_servicio.id_negocio=negocio.id WHERE negocio_servicio.id_servicio=".$id;
    if($zona!=NULL) $query.=" INNER JOIN negocio_zona ON negocio_servicio.id_negocio=negocio_zona.id_negocio";
    return $this->execute($query);
}

public function servicioNegocio($id){
    $query = 'SELECT servicio FROM negocio_servicio
    INNER JOIN cat_servicio ON negocio_servicio.id_servicio=cat_servicio.id WHERE negocio_servicio.id_negocio='.$id;
    return $this->execute($query);
}

public function getData($id = NULL){
    $query = 'SELECT * FROM cat_servicio WHERE id > 0';
    if($id!=NULL) $query.=" AND id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}
public function isDuplicate($servicio){
    $query = 'SELECT id FROM cat_servicio WHERE servicio="'.$servicio.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}
}
?>