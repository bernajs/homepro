<?php
$data = NULL;
$data['id'] = '';
$data['ciudad'] = '';
$action = "save";
$select_options = "";
require_once("../_class/class.voto_ciudad.php");
$objCiudad = new Ciudad();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $ciudad = $objCiudad->getCiudades($id);
    $data['ciudad'] = $ciudad[0]['ciudad'];
    $action = "update";
}
?>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Ciudad</span>
        <br>
        <div class="row">
          <form id="frmCiudad" name="frmCiudad" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <i class="material-icons prefix">location_on</i>
                <input id="icon_prefix" type="text" class="isRequired" name="ciudad" value="<?php echo $data['ciudad']; ?>">
                <label for="icon_prefix">Ciudad</label>
              </div>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="waves-effect blue btn onSave" data-form="#frmCiudad" data-src="voto_ciudad" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>