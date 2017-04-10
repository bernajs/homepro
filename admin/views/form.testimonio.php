<?php
$data = NULL;
$data['id'] = '';
$data['testimonio'] = '';
$data['status'] = '';
$action = "save";
$select_options = "";
require_once("../_class/class.testimonio.php");
$obj = new Testimonio();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $item = $obj->getData($id);
    $data['testimonio'] = $item[0]['testimonio'];
    $data['status'] = $item[0]['status'];
    $action = "update";
}
?>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Testimonio</span>
        <br>
        <div class="row">
          <form id="frmTestimonio" name="frmTestimonio" class="col s12">
            <div class="card">
              <div class="card-content">
                <?php echo $data['testimonio'] ?>
              </div>
            </div>
            <br>
            <div class="col l1 offset-l10">
              <input type="checkbox" id="status" name="status" value="1">
              <label for="status">¿Aprobar?</label>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="modal-action modal-close waves-effect blue btn onSave" data-form="#frmTestimonio" data-src="testimonio" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>