<?php
$data = NULL;
$data['id'] = '';
$data['nombre'] = '';
$data['correo'] = '';
$data['contrasena'] = '';
$data['permisos'] = '';
$data['status'] = '';
$action = "save";
$select_options = "";
require_once("../_class/class.admin.php");
$Admin = new Admin();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $admin = $Admin->getData($id);
    $data['nombre'] = $admin[0]['nombre'];
    $data['correo'] = $admin[0]['correo'];
    $data['contrasena'] = $admin[0]['contrasena'];
    $data['permisos'] = json_decode($admin[0]['permisos']);
    $data['status'] = $admin[0]['status'];
    $action = "update";
    $permisos = $data['permisos'];
    // $permisos = array(0 => 'negocio', 1 =>'usuario', 2 =>'voto_ciudad', 3 => 'ciudad', 4=>'servicio', 5=>'requerimiento', 6=> 'testimonio',7=>'aprobar_negocio');
}
?>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Administrador</span>
        <br>
        <div class="row">
          <form id="frmAdmin" name="frmAdmin" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <i class="material-icons prefix">location_on</i>
                <input id="nombre" type="text" class="isRequired" name="nombre" value="<?php echo $data['nombre']; ?>">
                <label for="nombre">Nombre</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">location_on</i>
                <select multiple name="permisos" id="permisos">
                  <option value="usuario" <?php if(in_array( 'usuario',$permisos)){echo 'selected';} ?>>Usuarios</option>
                  <option value="negocio" <?php if(in_array( 'negocio',$permisos)){echo 'selected';} ?>>Negocios</option>
                  <option value="voto_ciudad" <?php if(in_array( 'voto_ciudad',$permisos)){echo 'selected';} ?>>Votos ciudades</option>
                  <option value="ciudad" <?php if(in_array( 'ciudad',$permisos)){echo 'selected';} ?>>Ciudad</option>
                  <option value="servicio" <?php if(in_array( 'servicio',$permisos)){echo 'selected';} ?>>Servicios</option>
                  <option value="requerimiento" <?php if(in_array( 'requerimiento',$permisos)){echo 'selected';} ?>>Requerimientos</option>
                  <option value="testimonio" <?php if(in_array( 'testimonio',$permisos)){echo 'selected';} ?>>Testimonios</option>
                  <option value="aprobar_negocio" <?php if(in_array( 'aprobar_negocio',$permisos)){echo 'selected';} ?>>Aprobar negocios</option>
                </select>
                <label for="permisos">Permisos</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">location_on</i>
                <input id="correo" type="text" class="isRequired" name="correo" value="<?php echo $data['correo']; ?>">
                <label for="correo">Correo</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">location_on</i>
                <input id="contrasena" type="text" class="isRequired" name="contrasena" value="<?php echo $data['contrasena']; ?>">
                <label for="contrasena">Contrasena</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">location_on</i>
                <select name="status" id="status">
                  <option value="0" <?php if($data[ 'status']==0 ){echo 'selected';} ?>>Inactivo</option>
                  <option value="1" <?php if($data[ 'status']==1 ){echo 'selected';} ?>>Activo</option>
                </select>
                <label for="status">Estado</label>
              </div>
              <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="waves-effect blue btn onSave" data-form="#frmAdmin" data-src="admin" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>