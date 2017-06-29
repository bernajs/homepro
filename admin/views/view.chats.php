<?php
require_once("_class/class.requerimiento.php");
$obj = new Requerimiento();
$chats = $obj->getData();
$tbody = '';
for($i=0;$i<count($chats);$i++){
    $id = $chats[$i]['id'];
    $tbody .= '<tr class="row'.$id.'">';
    $tbody .= '<td>'.$chats[$i]['id'].'</td>';
    $tbody .= '<td>'.$chats[$i]['nombre'].'</td>';
    $tbody .= '<td>'.$chats[$i]['descripcion'].'</td>';
    $tbody .= '<td class="actions">
    <a class="onClickModal btnTableEdit" href="views/form.chat.php?id='.$id.'"><i class="material-icons">visibility</i></a></td>';
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
                <th>Requerimiento</th>
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
