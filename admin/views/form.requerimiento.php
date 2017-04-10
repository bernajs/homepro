<?php
$data = NULL;
$data['id'] = '';
$data['requerimiento'] = '';
$data['status'] = '';
$action = "save";
$select_options = "";
require_once("../_class/class.requerimiento.php");
$obj = new Requerimiento();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $item = $obj->getData($id);
    $data['nombre'] = $item[0]['nombre'];
    $data['descripcion'] = $item[0]['descripcion'];
    $data['servicio'] = $item[0]['servicio'];
    $data['status'] = $item[0]['status'];
    $action = "update";
}
?>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Requerimiento</span>
        <div class="row">
          <div class="col s6 l6">
            Usuario:
            <?php echo $data['nombre']; ?>
          </div>
          <div class="col s6 l6">
            Servicio:
            <?php echo $data['servicio']; ?>
          </div>
        </div>
        <div class="row">
          <form id="frmRequerimiento" name="frmRequerimiento" class="col s12">
            <div class="card">
              <div class="card-content">
                <?php echo $data['descripcion'] ?>
              </div>
            </div>
            <br>
            <!--<div class="col l1 offset-l10">
              <input type="checkbox" id="status" name="status" value="1">
              <label for="status">¿Eliminar?</label>
            </div>-->
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="modal-action modal-close waves-effect blue btn onSave" data-form="#frmRequerimiento" data-src="requerimiento" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>