<?php

require_once("class.helper.php");

class Negocio extends Helper {
    var $id;
    var $nombre;
    var $correo;
    var $contrasena;
    var $id_zona;
    var $id_servicio;
    var $informacion;
    var $movil;
    var $telefono;
    var $status;
    var $created_at;
    var $modified_at;
    var $lastInserted;
    var $oid;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO negocio (created_at,nombre,correo,contrasena,informacion,movil,status,telefono)
                VALUES (
                '".$this->created_at."',
                '".$this->nombre."',
                '".$this->correo."',
                '".$this->contrasena."',
                '".$this->informacion."',
                '".$this->movil."',
                '".$this->status."',
                '".$this->telefono."'
                )";
                $this->execute($query, true);
                
                $this->id = $this->lastInserted;
                $query = 'INSERT INTO negocio_estadistica (id_negocio) VALUES ('.$this->id.')';
                $this->execute($query);
                
                $zonas = (explode('|', $this->id_zona));
                for ($i=0; $i < (count($zonas)); $i++) {
                    if ($zonas[$i] != '') {
                        $query = "INSERT INTO negocio_zona (id_negocio,id_zona)
                        VALUES (
                        '".$this->id."',
                        '".$zonas[$i]."'
                        )";
                        $this->execute($query);
                }
            }
            
            $servicios = (explode('|', $this->id_servicio));
            for ($i=0; $i < (count($servicios)); $i++) {
                if ($servicios[$i] != '') {
                    $query = "INSERT INTO negocio_servicio (id_negocio,id_servicio)
                    VALUES (
                    '".$this->id."',
                    '".$servicios[$i]."'
                    )";
                    $this->execute($query);
                }
            }
            
            break;
        case "update":
            $query = "UPDATE negocio
            SET
            nombre='".$this->nombre."',
            correo='".$this->correo."',
            movil='".$this->movil."',
            telefono='".$this->telefono."',
            contrasena='".$this->contrasena."',
            informacion='".$this->informacion."'
            WHERE id=".$this->id;
            $this->execute($query);
            
            $query = "DELETE FROM negocio_zona WHERE id_negocio = ".$this->id;
            $this->execute($query);
            
            $query = "DELETE FROM negocio_servicio WHERE id_negocio = ".$this->id;
            $this->execute($query);
            // print_r($id_zona);
            $zonas = (explode('|', $this->id_zona));
            for ($i=0; $i < (count($zonas)); $i++) {
                if ($zonas[$i] != '') {
                    $query = "INSERT INTO negocio_zona (id_negocio,id_zona)
                    VALUES (
                    '".$this->id."',
                    '".$zonas[$i]."'
                    )";
                    $this->execute($query);
            }
        }
        $servicios = (explode('|', $this->id_servicio));
        for ($i=0; $i < (count($servicios)); $i++) {
            if ($servicios[$i] != '') {
                $query = "INSERT INTO negocio_servicio (id_negocio,id_servicio)
                VALUES (
                '".$this->id."',
                '".$servicios[$i]."'
                )";
                $this->execute($query);
            }
        }
        break;
    // case "delete": $query = "DELETE FROM negocio WHERE id=".$this->id;
    case "delete": $query = "DELETE FROM negocio WHERE id=".$this->id;
        $this->execute($query);
        break;
    case "approve":
        $query = "UPDATE negocio SET status = 1 WHERE id=".$this->id;
        $this->execute($query);
        break;
    case "update_onesignal_id":
        $query = "UPDATE negocio SET oid='".$this->oid."' WHERE id=".$this->id;
        $this->execute($query);
        break;
}
// $this->execute($query);
// if($key=="insert"){$this->lastInserted = mysql_insert_id();}
$lid = false;
if($key=="insert"){ $lid = true;
$this->execute($query,$lid); }
}

public function getLastInserted(){ return $this->lastInserted; }

public function getNegocios($id = NULL){
    $query = "SELECT * FROM negocio WHERE id > 0 AND status <> 0";
    if($id!=NULL) $query.=" AND id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}
public function getZonaNegocio($id){
    $query =  "SELECT id_zona FROM negocio_zona WHERE id_negocio=".$id;
    return $this->execute($query);
}
public function getZonas(){
    $query = "SELECT * FROM cat_zona WHERE id > 0";
    return $this->execute($query);
}

public function getServicios(){
    $query = "SELECT * FROM cat_servicio WHERE id > 0";
    return $this->execute($query);
}

public function getServicioNegocio($id){
    $query =  "SELECT id_servicio FROM negocio_servicio INNER JOIN cat_servicio ON cat_servicio.id=negocio_servicio.id_servicio WHERE id_negocio=".$id;
    return $this->execute($query);
}

public function getLastSuscripciones($id){
    $query = 'SELECT * FROM negocio_suscripcion WHERE id_negocio = '.$id.' ORDER BY CAST(fecha_fin as datetime) DESC';
    return $this->execute($query);
}

public function getSuscripciones($id){
    $query ="SELECT * FROM negocio_suscripcion WHERE id_negocio = ".$id.' ORDER BY CAST(fecha_fin as datetime) DESC';
    return $this->execute($query);
}

public function get_pendientes(){
    $query = 'SELECT * FROM negocio WHERE status = 0';
    return $this->execute($query);
}
public function isDuplicate($correo){
    $query = 'SELECT id FROM negocio WHERE correo="'.$correo.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}
}
?>