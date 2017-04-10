<?php
$data = NULL;
$data['id'] = '';
$data['nombre'] = '';
$data['correo'] = '';
$data['movil'] = '';
$data['id_zona'] = '';
$data['zona'] = '';
$data['telefono'] = '';
$data['informacion'] = '';
// $data['contrasena'] = '';
$action = "save";
$select_options = "";
$select_options_servicio = "";
require_once("../_class/class.negocio.php");
$objNegocio = new Negocio();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $negocio = $objNegocio->getNegocios($id);
    $data['nombre'] = $negocio[0]['nombre'];
    $data['correo'] = $negocio[0]['correo'];
    $data['movil'] = $negocio[0]['movil'];
    $data['telefono'] = $negocio[0]['telefono'];
    $data['informacion'] = $negocio[0]['informacion'];
    $data['id_zona'] = $negocio[0]['id_zona'];
    $data['zona'] = $negocio[0]['zona'];
    // $data['contrasena'] = $negocio[0]['contrasena'];
    $action = "update";
}else{
    $zonas = $objNegocio->getZonas();
    if(count($zonas) > 0){
        foreach ($zonas as $zona) {
            $select_options .= '<li><input type="checkbox" id="chk_zona'.$zona['id'].'" value="'.$zona['id'].'" name="id_zona[]" '.$checked.' /><label for="chk_zona'.$zona['id'].'">'.$zona['zona'].'</label></li>';
        }
    }
    
    $servicios = $objNegocio->getServicios();
    if(count($servicios) > 0){
        foreach ($servicios as $servicio) {
            $select_options_servicio .= '<li><input type="checkbox" id="chk_servicio'.$servicio['id'].'" value="'.$servicio['id'].'" name="id_servicio[]" '.$checked.' /><label for="chk_servicio'.$servicio['id'].'">'.$servicio['servicio'].'</label></li>';
        }
    }
}
?>

  <style>
    #zonas,
    #servicios {
      width: 200px;
      height: 300px;
      border: #e4e4e4 solid 1px;
      margin-bottom: 25px;
    }
    
    #zonas .holder,
    #servicios .holder {
      width: 100%;
      height: 300px;
      overflow-y: scroll;
    }
    
    .tbl_renovaciones {
      margin-left: 25px !important;
    }
    
    #lst_zonas,
    #servicios {
      margin-top: 0;
    }
    
    #lst_servicios li,
    #lst_zonas li {
      width: 49%;
      display: inline-block;
      margin-bottom: 5px;
    }
    
    .clear {
      clear: both;
      height: 0px;
    }
  </style>

  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Negocio</span>
        <br>
        <div class="row">
          <form id="frmNegocio" name="frmNegocio" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <i class="material-icons prefix">account_circle</i>
                <input id="nombre" type="text" class="isRequired" name="nombre" value="<?php echo $data['nombre']; ?>">
                <label for="nombre">Nombre</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">mail</i>
                <input id="correo" type="text" class="isRequired" name="correo" value="<?php echo $data['correo']; ?>">
                <label for="correo">Correo</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">stay_current_portrait</i>
                <input id="movil" name="movil" class="isRequired" type="number" value="<?php echo $data['movil']; ?>">
                <label for="movil" class="active">Móvl</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">phone</i>
                <input id="telefono" name="telefono" class="isRequired" type="number" value="<?php echo $data['telefono']; ?>">
                <label for="telefono" class="active">Teléfono</label>
              </div>
              <div class="input-field col s6">
                <i class="material-icons prefix">info</i>
                <input id="informacion" name="informacion" class="isRequired" type="text" value="<?php echo $data['informacion']; ?>">
                <label for="informacion" class="active">Información</label>
              </div>
              <div class="input-field col s12">
                <div class="input-field col l12 s12">
                  <div class="page-title">Zonas de Atención</div>
                  <br class="clear">
                  <ul id="lst_zonas">
                    <?php echo $select_options; ?>
                  </ul>
                </div>
              </div>
            </div>

            <div class="input-field col s12">
              <div class="input-field col l12 s12">
                <div class="page-title">Servicios</div>
                <br class="clear">
                <ul id="lst_servicios">
                  <?php echo $select_options_servicio; ?>
                </ul>
              </div>
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        </form>
      </div>
    </div>
  </div>
  </div>

  <div class="modal-footer">
    <a class="waves-effect blue btn onSave" data-form="#frmNegocio" data-src="negocio" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>