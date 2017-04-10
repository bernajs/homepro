<?php
require_once("_class/class.testimonio.php");
$obj = new Testimonio();
$data = $obj->getData();
$tbody = '';
// print_r($data);
foreach ($data as $testimonio) {
    $calificacion = $testimonio['calificacion'];
    $estrellas='';
    for ($i=0; $i < 5; $i++) {
        if ($i < $calificacion) {
            $estrellas .= '<span class="tiny material-icons on valign">grade</span>';
        } else {
            $estrellas .= '<span class="tiny material-icons off valign">grade</span>';
        }
    }
    // echo $calificacion;
    $tbody.='<div class="box row'.$testimonio['id'].'">
    <div class="card horizontal hoverable">
    <div class="card-stacked">
    <div class="card-content">
    <div class="row">
    <div class="col s12 m12 l12">
    <h6 class=""><b>'.$testimonio['unombre'].'</b></h6>
    <h6 class="valign-wrapper"><span class="lbl-calificacion">Calificacion: </span>'.$estrellas.'</h6>
    <h6 class="">Negocio: '.$testimonio['nnombre'].'
    </h6>
    </div>
    </div>
    <div class="col s10 m10 l10">
    <p class="">Testimonio: '.$testimonio['testimonio'].'
    </p>
    </div>
    </div>
    <div class="card-action">
    <a class="waves-effect waves-light btn blue darken-3 onClickApprove" data-id="'.$testimonio['id'].'" data-src="testimonio"><i class="material-icons">check</i></a>
    <a class="waves-effect waves-light btn red darken-2 onClickDelete" data-id="'.$testimonio['id'].'" data-src="testimonio"><i class="material-icons">delete</i></a>
    </div>
    </div>
    </div>
    </div>';
    // <a class="waves-effect waves-light btn blue darken-3 onClickModal" href="views/form.testimonio.php?id='.$testimonio['id'].'"><i class="material-icons">edit</i></a>
}
?>

  <style>
    .card-content {
      padding: 5px !important;
    }
    .lbl-calificacion{
      margin-right: 5px !important;
    }
    
    .card-content p {
      padding-left: 10px !important;
    }
    
    .flex-box {
      display: flex !important;
      flex-wrap: wrap !important;
      align-items: baseline !important;
      /*justify-content: space-between !important;*/
      /*align-content: flex-start !important;*/
    }
    
    .box {
      padding: 5px !important;
      width: 33.333% !important;
    }
    
    .box div,
    p {
      width: 100% !important;
      overflow: auto !important;
    }
    
    p {
      display: inline-block !important;
    }
    
    .on {
      color: #F3C46B !important;
    }
    
    .off {
      color: lightgray !important;
    }

    .on, .off{
      /*position: absolute !important;*/
      /*top: 30px !important;*/
    }
    
    @media (max-width: 736px) {
      .box {
        padding: 5px !important;
        width: 100% !important;
      }
    }
  </style>
  <div class="row">
    <div class="col s12">
      <div class="page-title">Testimonios</div>
    </div>
  </div>

  <div class="flex-box">
    <?php echo $tbody ?>
  </div>