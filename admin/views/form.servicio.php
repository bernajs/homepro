<?php
$data = NULL;
$data['id'] = '';
$data['servicio'] = '';
$data['color'] = '';
$data['imagen'] = '';
$data['tags'] = '';
$action = "save";
$select_options = "";
$titulo ="Agregar servicio";
require_once("../_class/class.servicio.php");
$obj = new Servicio();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $titulo = "Editar servicio";
    $item = $obj->getData($id);
    $data['servicio'] = $item[0]['servicio'];
    $data['color'] = $item[0]['color'];
    $data['imagen'] = $item[0]['imagen'];
    $data['tags'] = $item[0]['tags'];
    $action = "update";
    $img = 'servicio_'.$id.'_'.$data['imagen'];
}
?>

  <div class="modal-content">
    <div class="card">
      <div class="card-content">
        <span class="card-title"><?php echo $titulo ?></span>
        <br>
        <div class="row">
          <form id="frmServicio" name="frmServicio" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <i class="material-icons prefix">account_circle</i>
                <input id="servicio" type="text" name="servicio" class="isRequired" value="<?php echo $data['servicio']; ?>">
                <label data-error="" for="servicio">Servicio</label>
              </div>
              <div class="input-field col s6">
                <!--<i class="material-icons prefix">account_circle</i>-->
                <span data-error="" for="color">Color</span>
                <input id="color" type="color" name="color" class="isRequired" value="<?php echo $data['color']; ?>">
              </div>
              <div class="input-field col s12">
                <i class="material-icons prefix">account_circle</i>
                <input  type="text" id="tags" name="tags" class="isRequired materialize-textarea" value="<?php echo $data['tags']; ?>"></textarea>
                <label data-error="" for="tags">Tags</label>
              </div>
            </div>
            <div class="file-field input-field">
              <div class="dropzone" id="dz_imagen">
                <!--<div class="dz-default dz-message"><span><img src="assets/images/upload.png" alt=""></span></div>-->
              </div>
            </div>
            <input type="hidden" name="img" id="img" value="<?php echo $data['imagen']; ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" id="status" name="status" value="1" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a class="waves-effect blue btn onSave" data-form="#frmServicio" data-src="servicio" data-action="<?php echo $action; ?>">Aceptar</a>
    <a class="modal-action modal-close waves-effect red btn" style="margin-right: 5px;">Cancelar</a>
  </div>

  <!--<script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>-->

  <script src="assets/plugins/dropzone/dropzone.min.js"></script>
  <script>
    // $('a.onSave').on('click', function(e) {
    Dropzone.autoDiscover = false;
    Dropzone.options.myAwesomeDropzone = false;
    var id_servicio;
    var myDropzone = new Dropzone("div#dz_imagen", {
      url: "uploads/upload_img_servicio.php",
      addRemoveLinks: true,
      dictRemoveFile: 'Eliminar',
      autoProcessQueue: false,
      maxFilesize: 10,
      maxFiles: 1
    });

    // this.on('addedfile', function(file) {
    //   if (this.files.length > 1) {
    //     this.removeFile(this.files[0]);
    //   }
    // });
    if (myDropzone) {
      change_photo();
    }

    myDropzone.on('addedfile', function(file) {
      if (this.files.length > 1) {
        this.removeFile(this.files[0]);
      }
      $('#img').val(file.name);
    });
    myDropzone.on('sending', function(file, xhr, formData) {
      formData.append('id', id_servicio);
    });

    myDropzone.on("complete", function(file) {
      // if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
      // }
    });

    function upload(id) {
      // if (myDropzone.files.length) {
      // console.log('si entra');
      id_servicio = id;
      myDropzone.processQueue();
      // }
    }

    function change_photo() {
      <?php if($data['imagen']): ?>
      $('.dz-default span').empty().html('<img src="uploads/servicios/<?php echo $img; ?>" alt="" style="width: 20%; height:auto;"/>');
      <?php endif ?>
    }

    // $('#color').spectrum();
    // });
  </script>
