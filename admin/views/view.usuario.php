<?php
require_once("_class/class.usuario.php");
$objUsuario = new Usuario();
$usuario = $objUsuario->getUsuarios();
$tbody = '';
for($i=0;$i<count($usuario);$i++){
    $id = $usuario[$i]['id'];
    $tbody .= '<tr class="row'.$id.'">';
    $tbody .= '<td>'.$usuario[$i]['id'].'</td>';
    $tbody .= '<td>'.$usuario[$i]['nombre'].'</td>';
    $tbody .= '<td>'.$usuario[$i]['correo'].'</td>';
    $tbody .= '<td>'.$usuario[$i]['movil'].'</td>';
    $tbody .= '<td>'.$usuario[$i]['ciudad'].'</td>';
    $tbody .= '<td class="actions">
    <a href="javascript:void(0)" class="onClickDelete btnTableDelete" data-id="'.$id.'" data-src="usuario"><i class="material-icons">delete</i></a>
    <a class="onClickModal btnTableEdit" href="views/form.usuario.php?id='.$id.'"><i class="material-icons">edit</i></a></td>';
    $tbody .= '</tr>';
}

?>

  <div class="row">
    <div class="col s12">
      <div class="page-title">Usuarios</div>
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
                <th>Ciudad</th>
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
  <!--<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="waves-effect waves-light btn-floating btn-large black onClickModal" href="views/form.usuario.php">
      <i class="large material-icons">add</i>
    </a>
  </div>-->