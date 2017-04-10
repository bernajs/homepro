<?php

require_once("class.helper.php");

class Usuario extends Helper {
    // Usuario
    var $nombre;
    var $correo;
    var $contrasena;
    var $created_at;
    var $id_ciudad;
    var $fid;
    var $movil;
    var $status;
    var $modified_at;
    var $id;
    var $oid;
    
    // Cotizacion
    var $id_negocio;
    var $id_cotizacion;
    
    // Direccion
    var $calle;
    var $ciudad;
    var $estado;
    var $municipio;
    var $cp;
    var $pais;
    var $info;
    var $uid;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $this->status = 1;
                $query = "INSERT INTO usuario (created_at,nombre,correo,contrasena,id_ciudad,fid,movil,status)
                VALUES (
                '".$this->created_at."',
                '".$this->nombre."',
                '".$this->correo."',
                '".$this->contrasena."',
                '".$this->id_ciudad."',
                '".$this->fid."',
                '".$this->movil."',
                '".$this->status."'
                )";
                break;
            case "update":
                if($this->contrasena){
                    $query = "UPDATE usuario
                    SET
                    nombre='".$this->nombre."',
                    correo='".$this->correo."',
                    id_ciudad='".$this->id_ciudad."',
                    movil='".$this->movil."',
                    contrasena='".$this->contrasena."',
                    modified_at='".$this->modified_at."'
                    WHERE id=".$this->id;
            }else{
                $query = "UPDATE usuario
                SET
                nombre='".$this->nombre."',
                correo='".$this->correo."',
                id_ciudad='".$this->id_ciudad."',
                movil='".$this->movil."',
                modified_at='".$this->modified_at."'
                WHERE id=".$this->id;
            }
            break;
        case "delete": $query = "DELETE FROM usuario WHERE id=".$this->id;
            break;
        case "cotizacion":
            $negocios = (explode('|', $this->id_negocio));
            for ($i=0; $i < (count($negocios)); $i++) {
                if ($negocios[$i] != '') {
                    $query = "INSERT INTO negocio_requerimiento (id_negocio,id_requerimiento)
                    VALUES (
                    '".$negocios[$i]."',
                    '".$this->id_cotizacion."'
                    )";
                    $this->execute($query);
            }
        }
        
        
        $query = "";
        break;
    case "agregarFavoritos":
        $query = "INSERT INTO usuario_favorito (id_usuario, id_negocio)
        VALUES (
        '".$this->id."',
        '".$this->id_negocio."'
        )";
        break;
    case "borrarFavorito":
        $query = 'DELETE FROM usuario_favorito WHERE id_usuario = '.$this->id.' AND id_negocio = '.$this->id_negocio;
        break;
    case 'agregarDireccion':
        // Crea en json con los datos del billing
        $this->info =array('calle' => $this->calle, 'ciudad' => $this->ciudad, 'estado' => $this->estado,
        'municipio'=>$this->municipio,'cp'=>$this->cp, 'pais'=>$this->pais);
        
        $query = "INSERT INTO usuario_direccion (direccion,id_usuario,status, created_at)
        VALUES (
        '".json_encode($this->info)."',
        '".$this->id."',
        '".$this->status."',
        '".$this->created_at."'
        )";
        break;
    case 'actualizarDireccion':
        // Crea en json con los datos del billing
        $this->info =array('calle' => $this->calle, 'ciudad' => $this->ciudad, 'estado' => $this->estado,
        'municipio'=>$this->municipio,'cp'=>$this->cp, 'pais'=>$this->pais);
        
        $query = "UPDATE usuario_direccion
        SET
        direccion='".json_encode($this->info)."',
        modified_at='".$this->modified_at."'
        WHERE id=".$this->id;
        break;
    case "borrarDireccion":
        $query = 'DELETE FROM usuario_direccion WHERE id = '.$this->id;
        break;
    case "update_onesignal_id":
        $query = "UPDATE usuario SET oid='".$this->oid."' WHERE id=".$this->uid;
        break;
}
$lid = false;
if($key=="insert"){ $lid = true; }
$this->execute($query,$lid);
}

public function getLastInserted(){ return $this->lastInserted; }


public function getData($id){
    $query = "SELECT * FROM usuario WHERE id=".$id;
    return $this->execute($query);
}

public function getUsuarios($id = NULL){
    // $query = 'SELECT * FROM usuario WHERE id > 0';
    $query = 'SELECT * FROM cat_ciudad INNER JOIN usuario ON usuario.id_ciudad = cat_ciudad.id WHERE usuario.id > 0';
    if($id!=NULL) $query.=" AND usuario.id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
    
    // SELECT nombre, id_negocio, zona FROM negocio_zona
    // INNER JOIN cat_zona ON negocio_zona.id_zona = cat_zona.id
    // INNER JOIN negocio ON negocio_zona.id_negocio = negocio.id
}
public function getCiudades(){
    $query = "SELECT * FROM cat_ciudad WHERE id> 0";
    return $this->execute($query);
}

public function getDirecciones($id){
    $query = "SELECT * FROM usuario_direccion WHERE id_usuario = ".$id;
    return $this->execute($query);
}

public function getDireccion($id){
    $query = 'SELECT * FROM usuario_direccion WHERE id = '.$id;
    return $this->execute($query);
}

public function isDuplicate($correo){
    $query = 'SELECT id FROM usuario WHERE correo="'.$correo.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}

public function getFavorito($id_usuario, $id_negocio){
    $query = 'SELECT id FROM usuario_favorito WHERE id_usuario='.$id_usuario.' AND id_negocio = '.$id_negocio.' LIMIT 1';
    return $this->execute($query);
}

public function getFavoritos($id){
    $query = 'SELECT nombre, negocio.id FROM usuario_favorito
    INNER JOIN negocio ON usuario_favorito.id_negocio=negocio.id
    WHERE usuario_favorito.id_usuario='.$id;
    return $this->execute($query);
}

# LOGIN: Validate if user exists.
public function isRegistered($user,$pass){
    $query = 'SELECT * FROM usuario WHERE correo = "'.$user.'" AND contrasena = "'.$pass.'" AND status = 1 LIMIT 1';
    return $this->execute($query);
}

// Metodo para crear la cotizacion, retorna el id que se genero
public function cotizar($id_usuario, $id_servicio, $cotizacion, $fecha){
    $query = 'INSERT INTO requerimiento (id_usuario, id_servicio, descripcion, fecha_atn) VALUES ('.$id_usuario.','.$id_servicio.',"'.$cotizacion.'","'.$fecha.'");';
    $this->execute($query);
    return $this->lastInserted = mysql_insert_id();
}

public function isValidEmail($email){
    $query = 'SELECT correo FROM usuario WHERE correo = "'.$email.'" AND status = 1 LIMIT 1';
    return $this->execute($query);
}
}
?>