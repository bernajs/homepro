<?php
require_once("_class/class.requerimiento.php");
$obj = new Requerimiento();
$data = $obj->getData();
$tbody = '';
for($i=0;$i<count($data);$i++){
    $id = $data[$i]['id'];
    $tbody .= '<tr class="row'.$id.'">';
    $tbody .= '<td>'.$data[$i]['id'].'</td>';
    $tbody .= '<td>'.$data[$i]['nombre'].'</td>';
    $tbody .= '<td>'.$data[$i]['descripcion'].'</td>';
    $tbody .= '<td>'.$data[$i]['servicio'].'</td>';
    $tbody .= '<td>'.$data[$i]['fecha_atn'].'</td>';
    $tbody .= '<td class="actions">
    <a href="javascript:void(0)" class="onClickDelete btnTableDelete" data-id="'.$id.'" data-src="requerimiento"><i class="material-icons">delete</i></a>
    <a class="onClickModal btnTableEdit" href="views/form.requerimiento.php?id='.$id.'"><i class="material-icons">edit</i></a></td>';
    $tbody .= '</tr>';
}
?>

  <div class="row">
    <div class="col s12">
      <div class="page-title">Requerimientos</div>
    </div>
    <div class="col s12 m12 l12">
      <div class="card hoverable">
        <div class="card-content">
          <table id="example" class="display responsive-table datatable-example">
            <thead>
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Requerimiento</th>
                <th>Servicio</th>
                <th>Fecha</th>
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