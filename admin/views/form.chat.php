<?php
$data = NULL;
$data['id'] = '';
$data['nombre'] = '';
$data['id_negocio'] = '';
$action = "save";
$select_options = "";
$negocios_list='';
$chat_list = '';
require_once("../_class/class.requerimiento.php");
$obj = new Requerimiento();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $negocios = $obj->getRequerimientoNegocios($id);
    foreach ($negocios as $negocio) {
      $negocios_list .= '<a class="collection-item negocios negocio_'.$negocio['id_negocio'].'" onclick="showChat('.$negocio['id_negocio'].')">'.$negocio['negocio'].'</a class="collection-item">';
      $chat = $obj->getChat($id, $negocio['id_negocio']);
      $chat_list .= '<div class="chats chat_negocio_'.$negocio['id_negocio']. '"><ul class="collection">';
      foreach ($chat as $mensaje) {
        if($mensaje['tipo_usuario'] == 0){$align = 'right-align';$usuario=$negocio['usuario'];}else{ $align = 'left-align';$usuario=$negocio['negocio'];}
        // strpos($mensaje['mensaje'], '<img') ? $mensaje = $mensaj
        $mensaje['mensaje'] = str_replace('tmp/','../tmp/' ,$mensaje['mensaje']);
        $chat_list .= '<li class="collection-item '.$align.'">
        <span class="sender">'.$usuario.':</span>
        <p>'.$mensaje['mensaje'].'</p>
        <span class="date">'.strftime('%d %B %Y', strtotime($mensaje['created_at'])).'</span>
        </li>';
      }
      $chat_list .= '</ul></div>';
    }
}
?>
  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title">Negocios</span>
        <br>
        <div class="row">
          <form id="frmTestimonio" name="frmTestimonio" class="col s12">
            <div class="collection negocio-list">
            <?php echo $negocios_list; ?>
          </div>
        </div>
        <div class="row">
          <h5>Chat</h5>
          <span>Negocio</span>
          <span style="float: right;">Usuario</span>
          <div class="chat col s12">
            <?php echo $chat_list; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="modal-action modal-close waves-effect blue btn onSave" data-form="#frmTestimonio" data-src="testimonio" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>

  <style media="screen">
  .chat{
    height: 200px !important;
    width: auto;
    border: 1px solid #f4f4f4;
    overflow-y: scroll;
  }
  .chat .collection-item, .chat .collection {
    /*border: none;*/
  }
  .chats{
    display: none;
  }

  p{
    margin:0px !important;
  }
  .sender, .date{
    font-size: 12px;
    color: #777;
  }
  .date{
    font-size: 10px;
  }
  .negocio-list{
    cursor: pointer;
  }

  img{
    display: inline !important;
  }
  </style>
  <script type="text/javascript">
    function showChat(id){
      $('.chats').hide();
      $('.chat_negocio_' + id).show();
      $('.negocios').removeClass('active');
      $('.negocio_' + id).addClass('active');
    }

    $('.materialboxed').materialbox();
  </script>
