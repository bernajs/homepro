<?php
$data = NULL;
$data['id'] = '';
$data['nombre'] = '';
$data['correo'] = '';
$data['movil'] = '';
$data['contrasena'] = '';
$data['id_zona'] = [];
$data['telefono'] = '';
$data['informacion'] = '';
$action = "save";
$select_options = "";
$select_options_servicio = "";
$tLastSuscripciones = "";
$tSuscripciones = "";
require_once("_class/class.negocio.php");
$objNegocio = new Negocio();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $negocio = $objNegocio->getNegocios($id);
    $data['nombre'] = $negocio[0]['nombre'];
    $data['contrasena'] = $negocio[0]['contrasena'];
    $data['correo'] = $negocio[0]['correo'];
    $data['movil'] = $negocio[0]['movil'];
    $data['telefono'] = $negocio[0]['telefono'];
    $data['informacion'] = $negocio[0]['informacion'];
    $data['id_zona'] = $negocio[0]['id_zona'];
    
    $action = "update";
    $id_negocio = $id;
    $lastSuscripciones = $objNegocio->getLastSuscripciones($id);
    $suscripciones = $objNegocio->getSuscripciones($id);
    $estadisticas = $objNegocio->getEstadisticas($id);
    $estadisticas = $estadisticas[0];
    
    
    //Ultimas 5 suscripciones
    
    function convertir_fecha($fecha){
        // Array de dias
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        // Array de meses
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        /*$dias[date('w', $fecha_inicio_string)]. " ".*/
        // Se convierte la fecha (que esta en string) a date()
        $fecha =  strtotime($fecha);
        
        $meses[date('n',$fecha)-1];
        $fecha_convertida = date('d', $fecha). " de ".$meses[date('n',$fecha)-1]. " del ".date('Y', $fecha);
        return $fecha_convertida;
    }
    
    // echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
    //Salida: Viernes 24 de Febrero del 2012
    setlocale(LC_ALL,"es_ES");
    if (count($lastSuscripciones) > 0) {
        $checked = '';
        $ultima_suscripcion = $lastSuscripciones[0];
        // echo strtotime($ultima_suscripcion['fecha_fin']);
        if(strtotime($ultima_suscripcion['fecha_fin']) > strtotime(date('Y-m-d'))){
            $checked='checked';
        }
        $switch = '<div class="switch">
        Suscripción<br>
        <label>
        Inactiva
        <input disabled '.$checked.' type="checkbox">
        <span class="lever"></span> Activa
        </label>
        </div>';
        foreach ($lastSuscripciones as $suscripcion) {
            // Se manda llamar el metodo convertir_fechacon la fecha a convertir como parametro
            $fecha_inicio = convertir_fecha($suscripcion['fecha_inicio']);
            $fecha_fin = convertir_fecha($suscripcion['fecha_fin']);
            $tLastSuscripciones.='<tr><td>'.$fecha_inicio.'</td><td>'.$fecha_fin.'</td></tr>';
        }
    }
    
    
    //Mostrar todas las suscripciones
    if (count($suscripciones) > 0) {
        foreach ($suscripciones as $suscripcion) {
            $fecha_inicio = convertir_fecha($suscripcion['fecha_inicio']);
            $fecha_fin = convertir_fecha($suscripcion['fecha_fin']);
            if (strtotime($suscripcion['fecha_fin']) > strtotime(date('Y-m-d'))) {
                $tSuscripciones.='<tr class="row'.$suscripcion['id'].'"><td>'.$fecha_inicio.'</td><td>'.$fecha_fin.'</td>
                <td>'.$suscripcion['comentarios'].'</td>
                <td><a class="waves-effect waves-light btn red darken-2 onClickDelete" data-id="'.$suscripcion['id'].'" data-src="suscripcion"><i class="material-icons">delete</i></a></td>
                </tr>';
            }else{
                $tSuscripciones.='<tr><td>'.$fecha_inicio.'</td><td>'.$fecha_fin.'</td>
                <td>'.$suscripcion['comentarios'].'</td>
                <td></td>
                </tr>';
            }
        }
    }
    $zonas = $objNegocio->getZonas($id);
    $zonas_negocio = $objNegocio->getZonaNegocio($id);
    #ZONAS
    // echo "<pre>";
    // print_r($zonas_negocio);
    
    if(count($zonas) > 0){
        foreach ($zonas as $zona) {
            $checked = '';
            foreach ($zonas_negocio as $zona_negocio) {
                if ($zona['id'] == $zona_negocio['id_zona']){
                    $checked = 'checked="checked" ';
                }
            }
            $select_options .= '<li><input type="checkbox" id="chk_zona'.$zona['id'].'" value="'.$zona['id'].'" name="id_zona[]" '.$checked.' /><label for="chk_zona'.$zona['id'].'">'.$zona['zona'].'</label></li>';
        }
    }
    
    $servicios = $objNegocio->getServicios();
    $servicios_negocio = $objNegocio->getServicioNegocio($id);
    if(count($servicios) > 0){
        foreach ($servicios as $servicio) {
            $checked = '';
            foreach ($servicios_negocio as $servicio_negocio) {
                if ($servicio['id'] == $servicio_negocio['id_servicio']){
                    $checked = 'checked="checked" ';
                }
            }
            $select_options_servicio .= '<li><input type="checkbox" id="chk_servicio'.$servicio['id'].'" value="'.$servicio['id'].'" name="id_servicio[]" '.$checked.' /><label for="chk_servicio'.$servicio['id'].'">'.$servicio['servicio'].'</label></li>';
        }
    }
    $lista_documentos = '';
    $directorio    = './uploads/negocio/negocio_'.$id;
    if(file_exists($directorio)) {
        $documentos = array_diff(scandir($directorio), array('.', '..'));
        foreach ($documentos as $documento) {
            // $lista_documentos .= '<div><a href="'.$directorio.'/'.$documento.'" target="_blank" class="collection-item">'.$documento.'</a><i class="right">send</i><div>';
            $lista_documentos .= '<tr class="row'.$documento.'">';
            $lista_documentos .= '<td><a href="'.$directorio.'/'.$documento.'" target="_blank">'.$documento.'</a></td>';
            $lista_documentos .= '<td class="actions">
            <a href="javascript:void(0);" class="btnTableDelete deleteDocument" data-id="'.$documento.'"><span class="hide">'.$documento.'</span><i class="material-icons">delete</i></a>';
        }
    }
}
?>


  <style>
    #zonas,
    #servicios {
      width: 200px;
      height: 300px;
      border: #e4e4e4 solid 1px;
      margin-bottom: 25px;
    }
    
    #zonas .holder,
    #servicios .holder {
      width: 100%;
      height: 300px;
      overflow-y: scroll;
    }
    
    .tbl_renovaciones {
      /*margin-left: 25px !important;*/
    }
    
    #lst_zonas,
    #servicios {
      margin-top: 0;
    }
    
    #lst_servicios li,
    #lst_zonas li {
      width: 49%;
      display: inline-block;
      margin-bottom: 5px;
    }
    
    .clear {
      clear: both;
      height: 0px;
    }
    
    .dz-error-mark,
    .dz-success-mark,
    .dz-filename {
      /*display: none !important;*/
    }
    
    .dz-preview {
      /*display: inline-block !important;*/
      /*padding: 5px !important;*/
    }
    
    .hide {
      display: none !important;
    }
  </style>

  <div class="row">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s3"><a href="#test1">Información general</a></li>
        <li class="tab col s3"><a href="#test2">Documentos</a></li>
        <li class="tab col s3"><a href="#test3">Suscripciones</a></li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div id="test1">
      <div class="card col l6 m6 s12 hoverable">
        <div class="card-content">
          <form id="frmNegocio" name="frmNegocio" class="">
            <div class="row">
              <div class="page-title col l6 s12">Información</div>
            </div>
            <div class="row">
              <div class="input-field col l6 s12">
                <i class="material-icons prefix">account_circle</i>
                <input id="nombre" name="nombre" type="text" value="<?php echo $data['nombre']; ?>">
                <label for="nombre" class="active">Nombre</label>
              </div>
              <div class="input-field col l6 s12">
                <i class="material-icons prefix">mail</i>
                <input id="correo" name="correo" type="text" value="<?php echo $data['correo']; ?>">
                <label for="correo" class="active">Correo</label>
              </div>
              <div class="input-field col l6 s12">
                <i class="material-icons prefix">mail</i>
                <input id="contrasena" name="contrasena" type="text" value="<?php echo $data['contrasena']; ?>">
                <label for="contrasena" class="active">Contraseña</label>
              </div>
              <div class="input-field col l6 s12">
                <i class="material-icons prefix">stay_current_portrait</i>
                <input id="movil" name="movil" type="number" value="<?php echo $data['movil']; ?>">
                <label for="movil" class="active">Móvil</label>
              </div>
              <div class="input-field col l6 s12">
                <i class="material-icons prefix">phone</i>
                <input id="telefono" name="telefono" type="number" value="<?php echo $data['telefono']; ?>">
                <label for="telefono" class="active">Teléfono</label>
              </div>
              <div class="input-field col l6 s12">
                <i class="material-icons prefix">info</i>
                <input id="informacion" name="informacion" type="text" value="<?php echo $data['informacion']; ?>">
                <label for="informacion" class="active">Información</label>
              </div>
              <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
              <div class="input-field col l12 s12">
                <div class="page-title">Zonas de Atención</div>
                <br class="clear">
                <ul id="lst_zonas">
                  <?php echo $select_options; ?>
                </ul>
              </div>

              <div class="input-field col l12 s12">
                <div class="page-title">Servicios</div>
                <br class="clear">
                <ul id="lst_servicios">
                  <?php echo $select_options_servicio; ?>
                </ul>
              </div>
              <div class="col s12">
                <a class="waves-effect btn blue onSave full-btn" data-form="#frmNegocio" data-src="negocio" data-action="<?php echo $action; ?>">Guardar</a>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card col l5 m5 s12 offset-l1 offset-m1 tbl_renovaciones hoverable">
        <div class="card-content">
          <div class="row">
            <div class="col s12">
              <!--<?php echo $switch; ?>-->
            </div>
            <div class="">
              <div class="page-title">Últimas 5 renovaciones</div>
              <table class="highlight">
                <thead>
                  <tr>
                    <th data-field="id">Fecha inicio</th>
                    <th data-field="id">Fecha fin</th>
                  </tr>
                </thead>
                <tbody>
                  <?php echo $tLastSuscripciones ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col s12 l2">
            <a class="waves-effect blue btn onClickModal" href="views/form.negocio_suscripcion.php?id=<?php echo $id_negocio; ?>"><i class="material-icons">add</i></a>
          </div>
        </div>
      </div>

      <div class="card col l5 m5 s12 offset-l1 offset-m1 tbl_renovaciones hoverable">
        <div class="card-content">
          <div class="row">
            <canvas id="myChart" width="50%" height="35%"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div id="test2">
      <div class="row">
        <div class="col s12">
          <div class="page-title">Arrastre el documento</div>
        </div>
        <div class="col s12 m12 l12">
          <div class="card">
            <div class="card-content">
              <div class="dropzone" id="dz_document">
                <!--<div class="dz-default dz-message"><span><img src="assets/images/upload.png" alt=""></span></div>-->
              </div>
            </div>
          </div>
        </div>
        <div class="col s12">
          <a class="waves-effect btn blue right upload">Subir</a>
        </div>
        <div class="col s12 l4 m6">
          <h5>Listado de documentos</h5>
          <div class="card">
            <div class="card-content">
              <?php if($lista_documentos): ?>
                <table class="display responsive-table highlight">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo $lista_documentos; ?>
                  </tbody>
                </table>
                <?php else: ?>
                  <h6>Este negocio no tiene nigún documento.</h6>
                  <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="test3">
      <div class="row">
        <div class="col s12">
          <div class="page-title">Suscripciones</div>
        </div>
        <div class="col s12 m12 l12">
          <div class="card">
            <div class="card-content">
              <table class="display responsive-table highlight">
                <thead>
                  <tr>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th>Comentarios</th>
                    <th>Cancelar suscripción</th>
                  </tr>
                </thead>
                <tbody>
                  <?php echo $tSuscripciones ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- MODAL FORM -->
    <div id="modal_form" class="modal"></div>

    <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>

    <script src="assets/plugins/dropzone/dropzone.min.js"></script>
    <script type="text/javascript " src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>

    <script>
      // var id = <?php echo $id ?>;
      Dropzone.autoDiscover = false;
      Dropzone.options.myAwesomeDropzone = false;
      $(document).ready(function() {
        var myDropzone = new Dropzone("div#dz_document", {
          url: "uploads/upload_document.php",
          addRemoveLinks: true,
          dictRemoveFile: 'Eliminar',
          autoProcessQueue: false,
          maxFilesize: 10,
          parallelUploads: 10
        });
        // Dropzone.autoDiscover = false;
        $('.upload').on('click', function(e) {
          // e.preventDefault();
          myDropzone.processQueue();
        });
        myDropzone.on('sending', function(file, xhr, formData) {
          formData.append('nid', <?php echo $id ?>);
        });

        myDropzone.on("complete", function(file) {
          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            alert('Los archivos se subieron correctamente.')
            location.href = '#test2';
            location.reload();
          }
        });
      });


      $('.deleteDocument').on('click', function(e) {
        var documento = $(this).text();
        var id = <?php echo $id ?>;
        documento = documento.replace('delete', '');
        swal({
          title: "",
          text: "Por favor confirme la eliminación del documento",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Eliminar",
          closeOnConfirm: false
        }, function() {
          $.ajax({
            dataType: 'json',
            data: {
              exec: "eliminar",
              documento: documento,
              id: id
            },
            type: 'POST',
            url: 'uploads/delete_document.php',
            success: function(r) {
              if (r.status == 202) {
                swal({
                  title: "",
                  text: "El documento se ha eliminado correctamente.",
                  type: "success",
                  confirmButtonText: "Aceptar",
                  confirmButtonColor: "#2C8BEB"
                }, function(isConfirm) {
                  if (isConfirm) {
                    location.href = '#test2';
                    location.reload();
                  }
                });
              } else {
                swal({
                  title: "",
                  text: "Hubo un error, por favor intentalo de nuevo.",
                  type: "error",
                  confirmButtonText: "Aceptar",
                  confirmButtonColor: "#2C8BEB"
                });
              }
            }
          })

        });
      });
    </script>


    <script>
      var cotizaciones = <?php echo($estadisticas['cotizaciones']); ?>;
      var btn_llamar = <?php echo($estadisticas['btn_llamar']); ?>;
      var ver_perfil = <?php echo($estadisticas['ver_perfil']); ?>;
      var ctx = document.getElementById("myChart").getContext('2d');
      // Chart.defaults.global.legend.display = false;
      var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ["Vista perfil", "Llamadas", "Cotizaciones", ],
          datasets: [{
            backgroundColor: [
              "#2196F3",
              "#2ECC71",
              "#91C0E7",
            ],
            data: [cotizaciones, btn_llamar, ver_perfil]
          }]
        }
      });
    </script>