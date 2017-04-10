<?php

require_once("class.helper.php");

class Service extends Helper {
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
    
    // Cotizacion
    var $id_negocio;
    var $id_cotizacion;
    
    // Direccion
    var $calle;
    var $ciudad;
    var $estado;
    var $municipio;
    var $cp;
    var $colonia;
    var $info;
    
    // Chat
    var $mensaje;
    var $tipo_usuario;
    var $id_usuario;
    var $id_requerimiento;
    
    // Registro
    var $zonas;
    var $servicios;
    var $telefono;
    var $informacion;
    
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
                $query = "INSERT INTO negocio (created_at,nombre,correo,contrasena,movil,telefono,informacion,status)
                VALUES (
                '".$this->created_at."',
                '".$this->nombre."',
                '".$this->correo."',
                '".$this->contrasena."',
                '".$this->movil."',
                '".$this->telefono."',
                '".$this->informacion."',
                '".$this->status."'
                )";
                // $this->execute($query);
                // $this->id = mysql_insert_id();
                $this->execute($query, true);
                $this->id = $this->getLastInserted();
                $query = 'INSERT INTO negocio_estadistica (id_negocio) VALUES ('.$this->id.')';
                break;
            case "enviarChat":
                $query = "INSERT INTO chat (id_requerimiento,id_usuario,id_negocio,mensaje,tipo_usuario,status,created_at)
                VALUES (
                '".$this->id_requerimiento."',
                '".$this->id_usuario."',
                '".$this->id_negocio."',
                '".$this->mensaje."',
                '".$this->tipo_usuario."',
                '".$this->status."',
                '".$this->created_at."'
                )";
                break;
            case "update":
                if($this->contrasena){
                    $query = "UPDATE negocio
                    SET
                    nombre='".$this->nombre."',
                    correo='".$this->correo."',
                    movil='".$this->movil."',
                    telefono='".$this->telefono."',
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
        case "cotizacion_visto":
            $query = "UPDATE negocio_requerimiento
            SET
            status='1'
            WHERE id_negocio=".$this->id. ' AND id_requerimiento ='.$this->id_requerimiento;
            break;
        case "borrarDireccion":
            $query = 'DELETE FROM usuario_direccion WHERE id = '.$this->id;
            break;
}
$lid = false;
if($key=="insert"){ $lid = true; }
$this->execute($query,$lid);
}

public function getUOID($id){
    $query = 'SELECT oid FROM usuario WHERE id = '.$id. ' AND status = 1';
    return $this->execute($query);
}
public function getNOID($id){
    $query = 'SELECT oid FROM negocio WHERE id = '.$id. ' AND status = 1';
    return $this->execute($query);
}
public function getNegocio($id){
    $query = 'SELECT * FROM negocio_suscripcion WHERE id_negocio = '.$id;
    
    $suscripcion = $this->execute($query);
    if ($suscripcion) {
        $query = 'SELECT * FROM negocio INNER JOIN negocio_suscripcion ON negocio.id = negocio_suscripcion.id_negocio
        WHERE negocio.id = '.$id.' AND negocio.status = 1 ORDER BY CAST(fecha_fin AS DATETIME) DESC LIMIT 1';
    } else {
        $query = 'SELECT * FROM negocio WHERE id ='.$id.' AND status = 1';
    }
    return $this->execute($query);
}

public function getUsuario($usuario, $requerimiento, $negocio){
    $query = 'SELECT * FROM compartir_chat WHERE id_usuario ='.$usuario.' AND id_requerimiento = '.$requerimiento.'
    AND id_negocio ='.$negocio;
    return $this->execute($query);
}

public function getDatosUsuario($id){
    $query = 'SELECT nombre, correo, movil, ciudad FROM usuario
    INNER JOIN cat_ciudad ON usuario.id_ciudad = cat_ciudad.id WHERE usuario.id='.$id;
    return $this->execute($query);
}

public function getUsuarioDireccion($id){
    $query = 'SELECT direccion FROM usuario_direccion WHERE id = '.$id;
    return $this->execute($query);
}

public function getLastInserted(){
    // return $this->lastInserted = mysql_insert_id();
    return $this->lastInserted;
}

public function isDuplicate($correo){
    $query = 'SELECT id FROM usuario WHERE correo="'.$correo.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}

# LOGIN: Validate if user exists.
public function isRegistered($user,$pass){
    $query = 'SELECT * FROM negocio WHERE correo = "'.$user.'" AND contrasena = "'.$pass.'" LIMIT 1';
    return $this->execute($query);
}

public function getSuscripcion($id){
    $query = 'SELECT * FROM negocio_suscripcion WHERE id_negocio = '.$id.' ORDER BY CAST(fecha_fin AS DATETIME) DESC LIMIT 1';
    return $suscripcion = $this->execute($query);
}

// Historial
public function getCotizaciones($id){
    $query = 'SELECT negocio_requerimiento.status, id_requerimiento, servicio, negocio_requerimiento.modified_at, id_negocio, id_usuario, id_servicio, descripcion, fecha_atn FROM negocio_requerimiento
    INNER JOIN requerimiento ON negocio_requerimiento.id_requerimiento = requerimiento.id
    INNER JOIN cat_servicio ON requerimiento.id_servicio = cat_servicio.id
    WHERE negocio_requerimiento.id_negocio = '.$id. ' ORDER BY negocio_requerimiento.modified_at DESC';
    $cotizaciones =  $this->execute($query);
    $mensajes = array();
    if ($cotizaciones) {
        for ($i=0; $i < count($cotizaciones); $i++) {
            $query = 'SELECT id_requerimiento FROM chat WHERE id_requerimiento='.$cotizaciones[$i]['id_requerimiento'].' AND id_negocio ='.$cotizaciones[$i]['id_negocio'].'
            AND id_usuario ='.$cotizaciones[$i]['id_usuario'].' AND tipo_usuario = 0 AND status = 0';
            $msj = $this->execute($query);
            array_push($mensajes, $msj);
        }
    }
    $arreglo = array('cotizaciones' => $cotizaciones, 'msj'=>$mensajes);
    return $arreglo;
}

public function getLlamadas($id){
    $query = 'SELECT usuario_llamada.id, nombre, usuario_llamada.created_at AS modified_at FROM usuario_llamada
    INNER JOIN usuario ON usuario_llamada.id_usuario = usuario.id WHERE usuario_llamada.id_negocio = '.$id. ' ORDER BY usuario_llamada.created_at DESC';
    return $this->execute($query);
}

// Chat
public function getChat($id_requerimiento, $id_negocio, $id_usuario){
    $query = 'SELECT * FROM chat WHERE id_requerimiento='.$id_requerimiento.' AND id_negocio ='.$id_negocio.' AND id_usuario ='.$id_usuario.' ORDER BY CAST(chat.created_at as datetime) ASC';
    return $this->execute($query);
}

public function readChatNegocio($id_requerimiento, $id_negocio, $id_usuario){
    $query = 'UPDATE chat SET status = 1 WHERE id_requerimiento = '.$id_requerimiento.' AND id_negocio ='.$id_negocio.' AND id_usuario ='.$id_usuario. ' AND tipo_usuario = 0';
    $this->execute($query);
    $query = 'UPDATE negocio_requerimiento SET status = 1 WHERE id_requerimiento = '.$id_requerimiento.' AND id_negocio ='.$id_negocio;
    $this->execute($query);
}

// Registro
public function getZonas(){
    $query = 'SELECT * FROM cat_zona WHERE id > 0 AND status = 1';
    return $this->execute($query);
}

public function getServicios(){
    $query = 'SELECT * FROM cat_servicio WHERE id > 0 AND status =1';
    return $this->execute($query);
}

public function getEstadisticas($id){
    $query = 'SELECT * FROM negocio_estadistica WHERE id_negocio = '.$id;
    return $this->execute($query);
}

public function getCalificacion($id){
    $query = 'SELECT AVG(calificacion) AS calificacion FROM negocio_testimonio WHERE status = 1 AND id_negocio = '.$id;
    return $this->execute($query);
}

public function getTestimonio($id){
    $query = "SELECT usuario.nombre AS unombre, negocio.nombre AS nnombre, tipo, testimonio, calificacion, negocio_testimonio.status, negocio_testimonio.id AS id FROM negocio_testimonio
    INNER JOIN negocio
    ON negocio_testimonio.id_negocio = negocio.id
    INNER JOIN usuario
    ON negocio_testimonio.id_usuario = usuario.id
    WHERE negocio_testimonio.status = 1";
    // $query = 'SELECT * FROM negocio_testimonio WHERE id > 0 AND leido = 0';
    if($id!=NULL) $query.=" AND negocio_testimonio.id_negocio=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}

public function getCotizacionDetalle($id){
    $query = 'SELECT descripcion, fecha_atn, imagen FROM requerimiento WHERE id ='.$id;
    return $this->execute($query);
}

public function isValidEmail($email){
    $query = 'SELECT correo FROM negocio WHERE correo = "'.$email.'" AND status = 1 LIMIT 1';
    return $this->execute($query);
}

public function servzona($zonas, $servicios, $id_negocio){
    foreach($zonas as $zona) {
        $query = 'INSERT INTO negocio_zona (id_negocio, id_zona) VALUES ('.$id_negocio.','.$zona['id'].')';
        $this->execute($query);
    }
    foreach($servicios as $servicio) {
        $query = 'INSERT INTO negocio_servicio (id_negocio, id_servicio, status) VALUES ('.$id_negocio.','.$servicio['id'].', 1)';
        $this->execute($query);
    }
}
}
?>