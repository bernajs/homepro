<?php
require_once("_class/class.negocio.php");
$objNegocio = new Negocio();
$tbody = '';
$negocio;
$accion = '';
$pendientes = false;
if (isset($_GET['pending'])) {
    $pendientes = true;
    $negocio = $objNegocio->get_pendientes();
} else {
    $negocio = $objNegocio->getNegocios();
}
for($i=0;$i<count($negocio);$i++){
    $id = $negocio[$i]['id'];
    if ($pendientes) {
        $accion  = '<a href="javascript:void(0)" class="onClickApprove btnTableApprove" data-id="'.$id.'" data-src="negocio"><i class="material-icons">check</i></a>';
    } else {
        $accion = '<a href="javascript:void(0)" class="onClickDelete btnTableDelete" data-id="'.$id.'" data-src="negocio"><i class="material-icons">delete</i></a>';
        $accion.='<a class="btnTableEdit" href="index.php?call=negocio_detalle&id='.$id.'"><i class="material-icons">edit</i></a></td>';
    }
    
    $tbody .= '<tr class="row'.$id.'">';
    $tbody .= '<td>'.$negocio[$i]['id'].'</td>';
    $tbody .= '<td>'.$negocio[$i]['nombre'].'</td>';
    $tbody .= '<td>'.$negocio[$i]['correo'].'</td>';
    $tbody .= '<td>'.$negocio[$i]['movil'].'</td>';
    $tbody .= '<td>'.$negocio[$i]['telefono'].'</td>';
    $tbody .= '<td class="actions">
    '.$accion;
    $tbody .= '</tr>';
}
?>

  <div class="row">
    <div class="col s12">
      <div class="page-title">Negocios</div>
    </div>
    <div class="col s12 m12 l12">
      <div class="card hoverable">
        <div class="card-content">
          <table id="example" class="display responsive-table datatable-example">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Móvil</th>
                <th>Teléfono</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php echo $tbody; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!--FAB button-->
  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="waves-effect waves-light btn-floating btn-large black onClickModal" href="views/form.negocio.php">
      <i class="large material-icons">add</i>
    </a>
  </div>