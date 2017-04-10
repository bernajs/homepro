<?php
$data = NULL;
$data['id'] = '';
$data['zona'] = '';
$action = "save";
$select_options = "";
$titulo = "Agregar zona";
require_once("../_class/class.zona.php");
require_once("../_class/class.ciudad.php");
$obj = new Zona();
$objCiudad = new Ciudad();
$ciudades = $objCiudad->getCiudades();
$lista_ciudades;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $titulo = "Editar zona";
    $item = $obj->getData($id);
    $data['zona'] = $item[0]['zona'];
    $data['id_ciudad'] = $item[0]['id_ciudad'];
    $action = "update";
    
    foreach ($ciudades as $ciudad) {
        if ($ciudad['id'] ==  $data['id_ciudad']) {
            $lista_ciudades .= '<option value="'.$ciudad['id'].'" selected>'.$ciudad['ciudad'].'</option>';
        } else {
            $lista_ciudades .= '<option value="'.$ciudad['id'].'">'.$ciudad['ciudad'].'</option>';
        }
    }
}else{
    foreach ($ciudades as $ciudad) {
        $lista_ciudades .= '<option value="'.$ciudad['id'].'">'.$ciudad['ciudad'].'</option>';
    }
}
?>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title"><?php echo $titulo ?></span>
        <br>
        <div class="row">
          <form id="frmZona" name="frmZona" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <i class="material-icons prefix">aspect_ratio</i>
                <input id="icon_prefix" type="text" class="isRequired" name="zona" value="<?php echo $data['zona']; ?>">
                <label for="icon_prefix">Zona</label>
              </div>
              <div class="input-field col s6">
                <select name="id_ciudad" id="id_ciudad">
                  <?php echo $lista_ciudades; ?>
                </select>
              </div>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="waves-effect blue btn onSave" data-form="#frmZona" data-src="zona" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>