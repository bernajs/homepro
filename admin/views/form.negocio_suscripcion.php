<?php
$data = NULL;
$data['id'] = '';
$action = "save";
$select_options = "";
require_once("../_class/class.suscripcion.php");
$obj = new Suscripcion();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $action = "save";
}
?>

  <script>
    $('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 15, // Creates a dropdown of 15 years to control year
      format: 'yyyy-mm-dd',
      min: new Date() // Creates a dropdown of 15 years to control year
    });
  </script>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Agregar suscripción</span>
        <br>
        <div class="row">
          <form id="frmSuscripcion" name="frmSuscripcion" class="col s12">
            <div class="row">
              <div class="input-field">
                <i class="material-icons prefix">today</i>
                <input id="fecha_inicio" type="date" class="datepicker isRequired" name="fecha_inicio">
                <label for="fecha_inicio">Fecha inicio</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field">
                <i class="material-icons prefix">today</i>
                <input id="fecha_fin" type="date" class="datepicker isRequired" name="fecha_fin">
                <label for="fecha_fin">Fecha fin</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field">
                <i class="material-icons prefix">reorder</i>
                <input id="comentarios" type="text" class="validate" name="comentario">
                <label for="comentarios">Comentarios</label>
              </div>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="waves-effect blue btn onSave" data-form="#frmSuscripcion" data-src="suscripcion" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>