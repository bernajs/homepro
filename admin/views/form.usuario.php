<?php
$data = NULL;
$data['id'] = '';
$data['nombre'] = '';
$data['correo'] = '';
$data['movil'] = '';
$data['id_ciudad'] = '';
$data['ciudad'] = '';
$action = "save";
$titulo = "Agregar usuario";
$select_options = "";
require_once("../_class/class.usuario.php");
$objUsuario = new Usuario();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $titulo = "Editar usuario";
    $usuario = $objUsuario->getUsuarios($id);
    $data['nombre'] = $usuario[0]['nombre'];
    $data['correo'] = $usuario[0]['correo'];
    $data['movil'] = $usuario[0]['movil'];
    $data['ciudad'] = $usuario[0]['ciudad'];
    $data['id_ciudad'] = $usuario[0]['id_ciudad'];
    $action = "update";
    $ciudades = $objUsuario->getCiudades();
    foreach ($ciudades as $ciudad) {
        if($data['id_ciudad'] != $ciudad['id']){
            $select_options .= '<option value="'.$ciudad['id'].'">'.$ciudad['ciudad'].'</option>';
        }
    }
}else{
    $ciudades = $objUsuario->getCiudades();
    foreach ($ciudades as $ciudad) {
        $select_options .= '<option value="'.$ciudad['id'].'">'.$ciudad['ciudad'].'</option>';
    }
}
?>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title"><?php echo $titulo ?></span>
        <br>
        <div class="row">
          <form id="frmUsuario" name="frmUsuario" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <i class="material-icons prefix">account_circle</i>
                <input id="nombre" type="text" name="nombre" class="isRequired" value="<?php echo $data['nombre']; ?>">
                <label data-error="" for="nombre">Nombre</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">account_circle</i>
                <input id="correo" type="email" name="correo" class="isRequired" value="<?php echo $data['correo']; ?>">
                <label data-error="" for="correo">Correo</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">stay_current_portrait</i>
                <input id="movil" type="number" name="movil" class="isRequired" value="<?php echo $data['movil']; ?>">
                <label data-error="" for="movil" class="active">Teléfono</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">room</i>
                <select id="id_ciudad" name="id_ciudad">
                  <option value="<?php if($data['id_ciudad']){ echo $data['id_ciudad'];}?>" selected>
                    <?php echo $data['ciudad']; ?>
                  </option>
                  <?php print_r($select_options); ?>
                </select>
                <label>Ciudad</label>
              </div>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a class="waves-effect blue btn onSave" data-form="#frmUsuario" data-src="usuario" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>