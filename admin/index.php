<?php
include_once("../_inc/inc.admin.php");
include_once('_class/class.negocio.php');
$Negocio = new Negocio();

$pendientes = $Negocio->get_pendientes();
$active = '';
if(isset($_GET['call'])){
    $active =  $_GET['call'];
}
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <!-- Title -->
    <title>Homepro - Administrador</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css" />
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <!--Sweet alert-->
    <link href="assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />

    <!--Dropzone-->
    <link href="assets/plugins/dropzone/dropzone.min.css" rel="stylesheet">
    <link href="assets/plugins/dropzone/basic.min.css" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/spectrum.css" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div class="loader-bg"></div>
    <div class="loader">
      <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
        <div class="spinner-layer spinner-teal lighten-1">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
        <div class="spinner-layer spinner-yellow">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
        <div class="spinner-layer spinner-green">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="mn-content fixed-sidebar">
      <header class="mn-header navbar-fixed">
        <nav class="color-azul">
          <div class="nav-wrapper row">
            <section class="material-design-hamburger navigation-toggle">
              <a href="javascript:void(0)" data-activates="slide-out" class="button-collapse show-on-large material-design-hamburger__icon">
                <span class="material-design-hamburger__layer"></span>
              </a>
            </section>
            <div class="header-title col s3 m3">
              <span class="chapter-title">Administrador HomePro</span>
            </div>
          </div>
        </nav>
      </header>
      <aside id="slide-out" class="side-nav white fixed">
        <div class="side-nav-wrapper">
          <div class="sidebar-profile">
            <div class="sidebar-profile-image">
              <img src="assets/images/profile-image.png" class="circle" alt="">
            </div>
            <div class="sidebar-profile-info">
              <a href="javascript:void(0);" class="account-settings-link">
                <p>HomePro Admin</p>
                <span>homepro@gmail.com<i class="material-icons right">arrow_drop_down</i></span>
              </a>
            </div>
          </div>
          <div class="sidebar-account-settings">
            <ul>
              <li class="divider"></li>
              <li class="no-padding">
                <a class="waves-effect waves-grey" href="logout.php"><i class="material-icons">exit_to_app</i>Salir</a>
              </li>
            </ul>
          </div>
          <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="no-padding <?php if($active == 'dashboard' || !$active){echo 'active';} ?>"><a class="waves-effect waves-grey" href="index.php?call=dashboard"><i class="material-icons">settings_input_svideo</i>Dashboard</a></li>
            <?php if(in_array('negocio', $permisos)):?>
            <li class="no-padding <?php if($active == 'negocio'){echo 'active';} ?>"><a class="waves-effect waves-grey" href="index.php?call=negocio"><i class="material-icons">store</i>Negocios</a></li>
            <?php endif ?>
            <?php if(in_array('usuario', $permisos)):?>
            <li class="no-padding <?php if($active == 'usuario'){echo 'active';} ?>"><a class="waves-effect waves-grey" href="index.php?call=usuario"><i class="material-icons">supervisor_account</i>Usuarios</a></li>
            <?php endif ?>
            <?php if(in_array('admin', $permisos)):?>
            <li class="no-padding <?php if($active == 'admin'){echo 'active';} ?>"><a class="waves-effect waves-grey" href="index.php?call=admin"><i class="material-icons">supervisor_account</i>Administradores</a></li>
            <?php endif ?>
            <?php if(in_array('voto_ciudad', $permisos)):?>
            <li class="no-padding <?php if($active == 'voto_ciudad'){echo 'active';} ?>"><a class="waves-effect waves-grey" href="index.php?call=voto_ciudad"><i class="material-icons">location_city</i>Votos ciudades</a></li>
            <?php endif ?>
            <!--<li class="no-padding <?php if($active == 'testimonio'){echo 'active';} ?>"><a class="waves-effect waves-grey" href="index.php?call=testimonio"><i class="material-icons">subject</i>Testimonios</a></li>-->
            <li class="no-padding ">
              <a class="collapsible-header waves-effect waves-grey <?php if($active == 'ciudad' || $active == 'servicio' || $active == 'zona'){echo 'active';} ?>"><i class="material-icons">view_list</i>Catalogos<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
              <div class="collapsible-body">
                <ul>
                <?php if(in_array('ciudad', $permisos)):?>
                  <li class="no-padding <?php if($active == 'ciudad'){echo 'subactive';} ?>"><a class="waves-effect waves-grey" href="index.php?call=ciudad"><i class="material-icons">location_on</i>Ciudades</a></li>
                  <?php endif ?>
                  <?php if(in_array('servicio', $permisos)):?>
                  <li class="no-padding <?php if($active == 'servicio'){echo 'subactive';} ?>"><a class="waves-effect waves-grey" href="index.php?call=servicio"><i class="material-icons">assignment</i>Servicios</a></li>
                  <?php endif ?>
                  <?php if(in_array('zona', $permisos)):?>
                  <li class="no-padding <?php if($active == 'zona'){echo 'subactive';} ?>"><a class="waves-effect waves-grey" href="index.php?call=zona"><i class="material-icons">aspect_ratio</i>Zonas</a></li>
                  <?php endif ?>
                </ul>
              </div>
            </li>

            <li class="no-padding">
              <a class="collapsible-header waves-effect waves-grey <?php if($active == 'requerimiento' || $active == 'testimonio'){echo 'subactive';} ?>"><i class="material-icons">receipt</i>Reportes<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
              <div class="collapsible-body">
                <ul>
                  <li class="no-padding <?php if($active == 'chats'){echo 'subactive';} ?>"><a class="waves-effect waves-grey" href="index.php?call=chats"><i class="material-icons">forum</i>Chats</a></li>
                  <li class="no-padding <?php if($active == 'requerimiento'){echo 'subactive';} ?>"><a class="waves-effect waves-grey" href="index.php?call=requerimiento"><i class="material-icons">playlist_add</i>Requerimientos</a></li>
                  <li class="no-padding <?php if($active == 'testimonio'){echo 'subactive';} ?>"><a class="waves-effect waves-grey" href="index.php?call=testimonio"><i class="material-icons">subject</i>Testimonios</a></li>
                </ul>
              </div>
            </li>
            <?php if($pendientes): ?>
              <li class="no-padding <?php if($active == 'negocio' && $pending == true){echo 'active';} ?>"><a class="waves-effect waves-grey" href="index.php?call=negocio&pending=true"><i class="material-icons">store</i>Negocios nuevos <span class="new badge"><?php echo count($pendientes); ?></span></a></li>
              <?php endif ?>
          </ul>
          <div class="footer">
            <p class="copyright">HomePro ©</p>
          </div>
        </div>
      </aside>
      <main class="mn-inner">
        <?php

if(isset($_GET['call'])){
    if(file_exists('views/view.'.$_GET['call'].'.php')){ include('views/view.'.$_GET['call'].'.php'); }else{ include('views/view.dashboard.php'); }
}else{
    include('views/view.dashboard.php');
}
?>
      </main>

      <!-- MODAL FORM -->
      <div id="modal_form" class="modal"></div>

      <div class="left-sidebar-hover"></div>



      <!-- Javascripts -->
      <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
      <script src="assets/plugins/materialize/js/materialize.min.js"></script>
      <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
      <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
      <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
      <script src="assets/js/alpha.min.js"></script>
      <script src="assets/js/pages/table-data.js"></script>
      <script src="assets/plugins/chart.js/chart.min.js"></script>
      <script src="js/app.js" type="text/javascript"></script>
      <script src="assets/js/spectrum.js" type="text/javascript"></script>


      <!--Dropzone-->
      <!--<script src="assets/plugins/dropzone/dropzone.min.js"></script>-->
      <!--<script src="assets/plugins/dropzone/dropzone-amd-module.min.js"></script>-->

      <script>
        $(document).ready(function() {
          // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
          $(".dropdown-button").dropdown();
          $('.modal-trigger').leanModal();


          $(document).on("click", "a.onClickModal", function(e) {
            e.preventDefault();
            $("#modal_form").load($(this).attr("href"), function() {
              Materialize.updateTextFields();
              $('select').material_select();
              $('#modal_form').openModal();
            });
          });

          $('.modal-forms').leanModal({
            complete: function() {
              alert('Closed');
            }
          });
        });
      </script>

      <!--Input masks-->
      <script src="assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
      <!--<script src="assets/js/pages/form-input-mask.js"></script>-->

      <!--Formularios-->
      <script src="assets/js/pages/form_elements.js"></script>
      <!--Sweet alert-->
      <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
      <!--<script src="assets/plugins/google-code-prettify/prettify.js"></script>-->


      <!-- Javascripts -->
      <!--<script src="assets/plugins/d3/d3.min.js"></script>-->
  </body>

  </html>
