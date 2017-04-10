<?php
require_once("_class/class.servicio.php");
$obj = new Servicio();
$servicio = $obj->getData();
$tbody = '';
for($i=0;$i<count($servicio);$i++){
    $id = $servicio[$i]['id'];
    $tbody .= '<tr class="row'.$id.'">';
    $tbody .= '<td>'.$servicio[$i]['id'].'</td>';
    $tbody .= '<td>'.$servicio[$i]['servicio'].'</td>';
    $tbody .= '<td class="actions">
    <a href="javascript:void(0)" class="onClickDelete btnTableDelete" data-id="'.$id.'" data-src="servicio"><i class="material-icons">delete</i></a>
    <a class="onClickModal btnTableEdit" href="views/form.servicio.php?id='.$id.'"><i class="material-icons">edit</i></a></td>';
    $tbody .= '</tr>';
}
?>

  <div class="row">
    <div class="col s12">
      <div class="page-title">Servicios</div>
    </div>
    <div class="col s12 m12 l12">
      <div class="card hoverable">
        <div class="card-content">
          <table id="example" class="display responsive-table datatable-example">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
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
    <a class="waves-effect waves-light btn-floating btn-large black onClickModal" href="views/form.servicio.php">
      <i class="large material-icons">add</i>
    </a>
  </div>