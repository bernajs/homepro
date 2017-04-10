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
    var $imagenes;
    
    // Direccion
    var $direccion;
    var $calle;
    var $ciudad;
    var $estado;
    var $municipio;
    var $cp;
    var $colonia;
    var $info;
    var $ubicacion;
    
    // Chat
    var $mensaje;
    var $tipo_usuario;
    var $id_usuario;
    var $id_requerimiento;
    
    // Evaluar
    var $testimonio;
    var $calificacion;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
        switch($key){
            case "insert":
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
            case "fbregister":
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
            case "evaluar":
                $query = "INSERT INTO negocio_testimonio (id_negocio,id_usuario,id_requerimiento,tipo,testimonio,calificacion,status,created_at)
                VALUES (
                '".$this->id_negocio."',
                '".$this->id_usuario."',
                '".$this->id_requerimiento."',
                '".$this->tipo."',
                '".$this->testimonio."',
                '".$this->calificacion."',
                '".$this->status."',
                '".$this->created_at."'
                )";
                if($this->id_requerimiento > 0){
                    $this->execute($query);
                    $query = "UPDATE negocio_requerimiento
                    SET
                    status='1'
                    WHERE id_negocio=".$this->id_negocio. ' AND id_requerimiento='.$this->id_requerimiento;
            }
            break;
        case "compartir":
            $query = 'SELECT id FROM compartir_chat WHERE id_negocio = '.$this->id_negocio.' AND id_requerimiento = '.$this->id_cotizacion;
            $this->direccion = str_replace(array('"'),'',$this->direccion);
        if($this->correo){$this->correo=1;}else{$this->correo=0;}
        if($this->movil){$this->movil=1;}else{$this->movil=0;}
        if($this->direccion){$this->direccion = str_replace(array('[',']','\\'),'',$this->direccion);}else{$this->direccion = '';}
        $info = array('correo'=>$this->correo, 'telefono'=>$this->movil,'direccion'=>$this->direccion, 'ubicacion'=>$this->ubicacion);
        if($this->execute($query)){
            $query = "UPDATE compartir_chat
            SET
            info='".json_encode($info)."'
            WHERE id_negocio=".$this->id_negocio." AND id_requerimiento=".$this->id_cotizacion;
            // echo $query;
        }else{
            $query = "INSERT INTO compartir_chat (id_negocio,id_requerimiento,id_usuario,info,modified_at)
            VALUES (
            '".$this->id_negocio."',
            '".$this->id_cotizacion."',
            '".$this->id_usuario."',
            '".json_encode($info)."',
            '".$this->modified_at."'
            )";
        }
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
        
        $this->execute($query);
        $query = "UPDATE negocio_requerimiento
        SET
        modified_at='".$this->created_at."'
        WHERE id_requerimiento=".$this->id_requerimiento.' AND id_negocio='.$this->id_negocio;
        $this->execute($query);
        
        $query = "UPDATE requerimiento
        SET
        modified_at='".$this->created_at."'
        WHERE id=".$this->id_requerimiento;
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
    $query = "INSERT INTO negocio_requerimiento (id_negocio,id_requerimiento, modified_at)
    VALUES (
    '".$this->id_negocio."',
    '".$this->id_cotizacion."',
    '".$this->modified_at."'
    )";
    $this->execute($query);
    $query = "INSERT INTO compartir_chat (id_negocio,id_requerimiento,id_usuario,modified_at)
    VALUES (
    '".$this->id_negocio."',
    '".$this->id_cotizacion."',
    '".$this->id_usuario."',
    '".$this->modified_at."'
    )";
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
    'municipio'=>$this->municipio,'cp'=>$this->cp, 'colonia'=>$this->colonia);
    
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
    'municipio'=>$this->municipio,'cp'=>$this->cp, 'colonia'=>$this->colonia);
    
    $query = "UPDATE usuario_direccion
    SET
    direccion='".json_encode($this->info)."',
    modified_at='".$this->modified_at."'
    WHERE id=".$this->id;
    break;
case "borrarDireccion":
    $query = 'DELETE FROM usuario_direccion WHERE id = '.$this->id;
    break;
}
$lid = false;
if($key=="insert"){ $lid = true; }
$this->execute($query,$lid);
}

public function getLastInserted(){
    return $this->lastInserted;/* = mysql_insert_id();*/
}

public function check_email($email){
    $query = 'SELECT nombre, correo, contrasena FROM usuario WHERE correo="'.$email.'" LIMIT 1';
    return $this->execute($query);
}
public function check_tel($tel){
    $query = 'SELECT id FROM usuario WHERE movil="'.$tel.'" LIMIT 1';
    return $this->execute($query);
}

public function getUOID($id){
    $query = 'SELECT oid FROM usuario WHERE id = '.$id. ' AND status = 1';
    return $this->execute($query);
}
public function getNOID($id){
    $query = 'SELECT oid FROM negocio WHERE id = '.$id. ' AND status = 1';
    return $this->execute($query);
}
// Servicios
public function getServicios($id){
    $data = array();
    $query = "SELECT * FROM cat_servicio WHERE id > 0 ORDER BY servicio ASC";
    $servicios = $this->execute($query);
    $cantidad_servicios;
    for ($i=0; $i < count($servicios); $i++) {
        $query = 'SELECT negocio_servicio.id FROM negocio_servicio INNER JOIN negocio ON negocio_servicio.id_negocio = negocio.id WHERE negocio.status = 1 AND id_servicio = '.$servicios[$i]['id'];
        array_push($servicios[$i], $this->execute($query));
    }
    return $servicios;
}

public function getZonas($id=null){
    $query = 'SELECT zona, cat_zona.id FROM usuario
    INNER JOIN cat_zona ON usuario.id_ciudad = cat_zona.id_ciudad
    WHERE usuario.id = '.$id;
    // $query = "SELECT * FROM cat_zona WHERE id > 0";
    // if($id){$query .= ' AND id='.$id;}
    return $this->execute($query);
}


public function getServicioNegocio($id){
    $query = "SELECT servicio, nombre, negocio.id FROM negocio_servicio
    INNER JOIN cat_servicio ON negocio_servicio.id_servicio=cat_servicio.id
    INNER JOIN negocio ON negocio_servicio.id_negocio=negocio.id WHERE negocio_servicio.id_servicio=".$id;
    return $this->execute($query);
}

public function getServicioNegocioCOPIA($id){
    $query = "SELECT servicio, imagen, nombre, correo, movil, telefono, informacion, negocio.id FROM negocio_servicio
    INNER JOIN cat_servicio ON negocio_servicio.id_servicio=cat_servicio.id
    INNER JOIN negocio ON negocio_servicio.id_negocio=negocio.id WHERE negocio_servicio.id_servicio=".$id;
    return $this->execute($query);
}

public function getNegocioFiltro($id_servicio=null, $id_zona=null, $id_usuario){
    $negocios;
    $zonas;
    $result = array();
    if ($id_servicio && $id_zona !=0) {
        $query = "SELECT DISTINCT servicio, zona, imagen, nombre, correo, movil, telefono, informacion, negocio.id FROM negocio_servicio
        INNER JOIN cat_servicio ON negocio_servicio.id_servicio=cat_servicio.id
        INNER JOIN negocio ON negocio_servicio.id_negocio=negocio.id
        INNER JOIN negocio_suscripcion ON negocio_suscripcion.id_negocio=negocio.id
        INNER JOIN negocio_zona ON negocio_zona.id_negocio = negocio.id
        INNER JOIN cat_zona ON cat_zona.id=".$id_zona."
        WHERE negocio_servicio.id_servicio=".$id_servicio.' AND negocio.status = 1 AND negocio_zona.id_zona='.$id_zona;
        // echo $query;
        $negocios = $this->execute($query);
        for ($i=0; $i < count($negocios); $i++) {
            $query = 'SELECT zona FROM negocio_zona
            INNER JOIN cat_zona ON negocio_zona.id_zona = cat_zona.id
            WHERE negocio_zona.id_negocio ='.$negocios[$i]['id']. ' ORDER BY cat_zona.id DESC';
            $zonas = $this->execute($query);
            array_push($negocios[$i], $zonas);
        }
    } else {
        if($id_servicio){
            $query = 'SELECT DISTINCT servicio, negocio.id, negocio.nombre, negocio.informacion FROM negocio_servicio INNER JOIN negocio ON negocio_servicio.id_negocio = negocio.id
            INNER JOIN cat_servicio ON cat_servicio.id = '.$id_servicio.'
            INNER JOIN negocio_suscripcion ON negocio_suscripcion.id_negocio=negocio.id
            INNER JOIN negocio_zona ON negocio_zona.id_negocio = negocio.id
            INNER JOIN cat_zona ON cat_zona.id = negocio_zona.id_zona
            INNER JOIN usuario ON usuario.id_ciudad = cat_zona.id_ciudad
            WHERE usuario.id ='.$id_usuario. ' AND negocio.status = 1 AND negocio_servicio.id_servicio='.$id_servicio;
            $negocios = $this->execute($query);
            for ($i=0; $i < count($negocios); $i++) {
                $query = 'SELECT zona FROM negocio_zona
                INNER JOIN cat_zona ON negocio_zona.id_zona = cat_zona.id
                WHERE negocio_zona.id_negocio ='.$negocios[$i]['id']. ' ORDER BY cat_zona.id DESC';
                $zonas = $this->execute($query);
                array_push($negocios[$i], $zonas);
            }
        }
    }
    return $negocios;
}


public function isDuplicate($correo){
    $query = 'SELECT id FROM usuario WHERE correo="'.$correo.'" LIMIT 1';
    $result = $this->execute($query);
    if(count($result)>0){ return true; }else{ return false; }
}

# LOGIN: Validate if user exists.
public function isRegistered($user,$pass){
    $query = 'SELECT * FROM usuario WHERE correo = "'.$user.'" AND contrasena = "'.$pass.'" AND status = 1 LIMIT 1';
    return $this->execute($query);
}
public function isAdmin($user,$pass){
    $query = 'SELECT * FROM admin WHERE correo = "'.$user.'" AND contrasena = "'.$pass.'" AND status = 1 LIMIT 1';
    return $this->execute($query);
}

// Metodo para crear la cotizacion en la tabla requerimiento, retorna el id que se genero
public function cotizar($id_usuario, $id_servicio, $cotizacion, $fecha, $created_at, $imagenes){
    // $img = str_replace('"','\'', $imagenes);
    if($imagenes == '""'){$imagenes = '';};
    $query = "INSERT INTO requerimiento (id_usuario, id_servicio, descripcion, fecha_atn, created_at, modified_at, imagen) VALUES
    (".$id_usuario.",".$id_servicio.",'".$cotizacion."','".$fecha."', '".$created_at."', '".$created_at."', '".json_encode($imagenes)."');";
    $this->execute($query, true);
    return $this->lastInserted;/* = mysql_insert_id();*/
}

public function cotizacion_estadistica($id){
    $query = 'UPDATE negocio_estadistica SET cotizaciones = cotizaciones + 1 WHERE id_negocio='.$id;
    $this->execute($query);
}


// USUARIO
public function getUsuario($id){
    $query = 'SELECT * FROM usuario WHERE id='.$id;
    return $this->execute($query);
}
public function getUsuarios($id = NULL){
    $query = 'SELECT * FROM cat_ciudad INNER JOIN usuario ON usuario.id_ciudad = cat_ciudad.id WHERE usuario.id > 0';
    if($id!=NULL) $query.=" AND usuario.id=".$id."";
    if($this->status!=NULL) $query .= " AND status=".$this->status;
    if($this->search!=NULL) $query .= " AND ".$this->search_field." LIKE '%".$this->search."%'";
    if($this->order!=NULL) $query .= " ORDER BY ".$this->order;
    if($this->limit!=NULL) $query .= " LIMIT ".$this->limit;
    return $this->execute($query);
}
public function getCiudades(){
    $query = "SELECT * FROM cat_ciudad WHERE id > 0";
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


public function getFavoritos($id){
    $query = 'SELECT nombre, negocio.id FROM usuario_favorito
    INNER JOIN negocio ON usuario_favorito.id_negocio=negocio.id
    WHERE usuario_favorito.id_usuario='.$id;
    $zonas = array();
    $servicios = array();
    $negocios =  $this->execute($query);
    
    for ($i=0; $i < count($negocios); $i++) {
        array_push($zonas, $this->NegocioZonas($negocios[$i]['id']));
        array_push($servicios, $this->NegocioServicios($negocios[$i]['id']));
    }
    $data = array('negocios' => $negocios, 'zonas'=> $zonas, 'servicios'=> $servicios);
    return $data;
}

public function getCotizacionDetalle($id){
    $query = 'SELECT servicio, negocio_requerimiento.status, negocio.id AS id_negocio, requerimiento.id AS id_requerimiento, descripcion, fecha_atn, negocio.nombre AS negocio,
    negocio_requerimiento.modified_at
    FROM requerimiento
    INNER JOIN usuario ON requerimiento.id_usuario=usuario.id
    INNER JOIN negocio_requerimiento ON negocio_requerimiento.id_requerimiento=requerimiento.id INNER JOIN negocio ON negocio_requerimiento.id_negocio=negocio.id
    INNER JOIN cat_servicio ON requerimiento.id_servicio = cat_servicio.id
    WHERE requerimiento.id = '.$id.' ORDER BY CAST(negocio_requerimiento.modified_at as datetime) DESC';
    $cotizaciones = $this->execute($query);
    $mensajes = array();
    foreach ($cotizaciones as $cotizacion) {
        $query = 'SELECT id FROM chat WHERE id_requerimiento = '.$cotizacion['id_requerimiento']. '
        AND id_negocio = '.$cotizacion['id_negocio'].' AND status = 0 AND tipo_usuario = 1';
        array_push($mensajes, $this->execute($query));
    }
    $data =  array("negocios"=> $cotizaciones, "mensajes"=>$mensajes);
    return ($data);
}

public function getCotizaciones($id){
    $query = 'SELECT requerimiento.id, descripcion, fecha_atn, requerimiento.modified_at, servicio FROM requerimiento
    INNER JOIN cat_servicio ON requerimiento.id_servicio = cat_servicio.id
    WHERE id_usuario = '.$id . ' ORDER BY modified_at DESC';
    $cotizaciones = $this->execute($query);
    $mensajes = array();
    if($cotizaciones){
        foreach ($cotizaciones as $cotizacion) {
            $query = 'SELECT id FROM chat WHERE id_requerimiento = '.$cotizacion['id']. '
            AND status = 0 AND tipo_usuario = 1';
            array_push($mensajes, $this->execute($query));
        }
    }
    $data = array("cotizaciones"=> $cotizaciones, "mensajes"=>$mensajes);
    return $data;
}

// NEGOCIO

public function getNegocio($id){
    $query = 'SELECT nombre, movil FROM negocio WHERE id='.$id;
    return $this->execute($query);
}

public function isFbRegistered($fid){
    $query = 'SELECT id FROM usuario WHERE fid = '.$fid;
    return $this->execute($query);
}

public function getNegocios($id_servicio, $id_zona){
    if ($id_servicio && $id_zona) {
        $query = 'SELECT nombre FROM negocio INNER JOIN negocio_servicio ON negocio.id=negocio_servicio.id_negocio
        INNER JOIN negocio_zona ON negocio.id=negocio_zona.id_negocio WHERE negocio_servicio.id_servicio ='.$id_servicio. ' AND negocio_zona.id_zona='.$id_zona;
    } else {
        if($id_servicio){
            $query = 'SELECT nombre FROM negocio INNER JOIN negocio_servicio ON negocio.id=negocio_servicio.id_negocio
            WHERE negocio_servicio.id_servicio ='.$id_servicio;
        }else if($id_zona){
            $query = 'SELECT nombre FROM negocio INNER JOIN negocio_zona ON negocio.id=negocio_zona.id_negocio
            WHERE negocio_zona.id_zona ='.$id_zona;
        }
    }
    return $this->execute($query);
}
public function negocioTestimonios($id){
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

public function visita($id){
    $query = 'UPDATE negocio_estadistica SET ver_perfil = ver_perfil + 1 WHERE id_negocio='.$id;
    $this->execute($query);
}

public function llamada($id){
    $query = 'UPDATE negocio_estadistica SET btn_llamar = btn_llamar + 1 WHERE id_negocio='.$id;
    $this->execute($query);
}

public function llamadaUsuario($id_usuario, $id_negocio, $fecha){
    $query = 'INSERT INTO usuario_llamada (id_usuario, id_negocio, created_at) VALUES ('.$id_usuario.' ,'.$id_negocio.', "'.$fecha.'")';
    $this->execute($query);
}
public function getLlamadas($id){
    $query = 'SELECT usuario_llamada.id, nombre, usuario_llamada.created_at AS modified_at FROM usuario_llamada
    INNER JOIN negocio ON usuario_llamada.id_negocio = negocio.id WHERE usuario_llamada.id_usuario = '.$id. ' ORDER BY usuario_llamada.created_at DESC';
    return $this->execute($query);
}
public function negocioZonas($id){
    $query = 'SELECT zona FROM negocio_zona
    INNER JOIN cat_zona ON negocio_zona.id_zona=cat_zona.id WHERE negocio_zona.id_negocio='.$id;
    return $this->execute($query);
}

public function negocioServicios($id){
    $query = 'SELECT servicio FROM negocio_servicio
    INNER JOIN cat_servicio ON negocio_servicio.id_servicio=cat_servicio.id WHERE negocio_servicio.id_negocio='.$id;
    return $this->execute($query);
}

public function negocioFavorito($id_usuario, $id_negocio){
    $query = 'SELECT id FROM usuario_favorito WHERE id_usuario='.$id_usuario.' AND id_negocio = '.$id_negocio.' LIMIT 1';
    return $this->execute($query);
}

// Ciudades
public function getVotoCiudades(){
    $query = 'SELECT * FROM voto_ciudad WHERE id > 0 AND status = 1';
    return $this->execute($query);
}

public function newVotoCiudad($id_ciudad, $correo, $fecha){
    $query = 'UPDATE voto_ciudad SET votos = (votos + 1) WHERE id ='.$id_ciudad;
    $this->execute($query);
    $query = 'INSERT INTO voto_correo (id_ciudad, correo, created_at) VALUES ('.$id_ciudad.',"'.$correo.'", "'.$fecha.'")';
    $this->execute($query);
}


public function correoVotoCiudad($id_ciudad, $correo){
    $query = 'SELECT id FROM voto_correo WHERE id_ciudad='.$id_ciudad.' AND correo="'.$correo.'"';
    return $this->execute($query);
}
// Chat
public function getChat($id_requerimiento, $id_negocio){
    $query = 'SELECT mensaje, tipo_usuario, servicio, chat.created_at FROM chat
    INNER JOIN requerimiento ON requerimiento.id = '.$id_requerimiento.'
    INNER JOIN cat_servicio ON cat_servicio.id = requerimiento.id_servicio
    WHERE chat.id_requerimiento = '.$id_requerimiento.' AND chat.id_negocio ='.$id_negocio.' ORDER BY CAST(chat.created_at as datetime) ASC';
    return $this->execute($query);
}
public function getChatNuevos($id_requerimiento, $id_negocio){
    $query = 'SELECT * FROM chat WHERE id_requerimiento = '.$id_requerimiento.' AND id_negocio ='.$id_negocio.' AND tipo_usuario = 1 AND status = 0';
    return $this->execute($query);
}

public function getCompartir($id){
    $usuario;
    $query = 'SELECT usuario_direccion.id, nombre, correo, movil, direccion FROM usuario
    INNER JOIN usuario_direccion ON usuario.id = usuario_direccion.id_usuario
    WHERE usuario.id = '.$id;
    // echo $query;
    $usuario = $this->execute($query);
    if($usuario){return $usuario;}else{ $query = 'SELECT  nombre, correo, movil FROM usuario WHERE id = '.$id; return $this->execute($query);}
}

public function readChatUsuario($id_requerimiento, $id_negocio){
    $query = 'UPDATE chat SET status = 1 WHERE id_requerimiento = '.$id_requerimiento.' AND id_negocio ='.$id_negocio. ' AND tipo_usuario = 1';
    $this->execute($query);
}
public function getNegociosSuscripcion(){
    $query = 'SELECT id_negocio FROM `negocio_suscripcion` WHERE CAST(fecha_fin AS DATE) < CAST(CURRENT_TIMESTAMP AS DATE)';
    $negocios = $this->execute($query);
    
    if($negocios){
        foreach ($negocios as $negocio) {
            $query = 'UPDATE negocio SET status = 0 WHERE id='.$negocio['id_negocio'];
            $this->execute($query);
        }
    }
}

}
?>