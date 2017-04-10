<?php

require_once("class.helper.php");

class Admin extends Helper {
    var $nombre;
    var $correo;
    var $contrasena;
    var $permisos;
    var $created_at;
    var $status;
    var $modified_at;
    var $id;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO admin (created_at,nombre,correo,contrasena,permisos,status)
                VALUES (
                '".$this->created_at."',
                '".$this->nombre."',
                '".$this->correo."',
                '".$this->contrasena."',
                '".$this->permisos."',
                '".$this->status."'
                )";
                break;
            case "update":
                $query = "UPDATE admin
                SET
                nombre='".$this->nombre."',
                contrasena='".$this->contrasena."',
                permisos='".$this->permisos."',
                correo='".$this->correo."',
                status='".$this->status."',
                modified_at='".$this->modified_at."'
                WHERE id=".$this->id;
                break;
            case "delete": $query = "DELETE FROM admin WHERE id=".$this->id;
                break;
            
    }
    $lid = false;
    if($key=="insert"){ $lid = true; }
    $this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }

public function getData($id = NULL){
    $query = 'SELECT * FROM admin WHERE id > 0';
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

public function get_permisos($id){
    $query = 'SELECT permisos FROM admin WHERE id = '.$id;
    echo $query;
    return $this->execute($query);
}
public function isDuplicate($correo){
    $query = 'SELECT id FROM admin WHERE correo="'.$correo.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}
}
?>