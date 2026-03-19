<?php 
  extract($_POST);  
  include('controller/controllerReserva.php');
  include('controller/WsManagement.php');
  include('controller/controller.php');
  //
  $ws = new WsManagement();
  $tmp = $ws->wsALumno($_POST['carnet'], $_POST['fecha1']);
  header('Content-Type: text/html; charset=utf-8');
 ?>

 <?php if ($tmp == null): ?>
  <br>
  <div>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-3">Alumno no encontrado</h1>
        <p class="lead">Verifique si ha escrito correctamente el carnet o no se encuentra inscrito en el ciclo actual</p>
      </div>
    </div>
  </div> 

<?php else: ?>
  <br>
  <div class="row mt-4 p-4 bg-info justify-content-center">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h3 class="text-white">Informe Alumnos</h3>
  <div>.</div></div>
   <div class="col-sm-12 col-md-2 col-xs-12">
    <span class="thumbnail">
      <?php if ($tmp->getImg()==""): ?>
        <img src="img/avatar.png">
      <?php else: ?>
        <img src='<?php echo "data:image/png;base64,".$tmp->getImg(); ?>' alt="...">  
      <?php endif ?>

    </span>
  </div>
  
  <div class="col-sm-6 col-md-3 col-xs-12 row justify-content-end">
   <label for="" class="col-md-3 col-sm-3 ">Carnet: </label>
   <h4 class="col-sm-9 col-md-9 col-xs-12 text-white"><?php echo $tmp->getCarnet();; ?></h4>
   <label for="" class="col-md-3 col-sm-3">Nombre: </label>
   <h4 class="col-sm-9 col-md-9 col-xs-12 text-white"><?php echo $tmp->getNombre(); ?></h4>
 </div>

 <div class="col-sm-6 col-md-4 row col-xs-12 justify-content-end">  

   <h4 class="text-white col-sm-9 col-lg-12 col-md-10"><?php echo $fecha1." - ".$fecha2; ?></h4>
   <label for="" class="col-md-3 col-sm-3">Entradas:</label>
   <h3 class="col-sm-9 text-white"><?php ObtenerCantEntradas($carnet, $fecha1, $fecha2); ?></h3>
   <label for="" class="col-md-3 col-sm-3">N Horas:</label>
   <h3 class="col-sm-9 text-white"><?php ObtenerHorasxAlumno($carnet, $fecha1, $fecha2); ?></h3>

 </div>
</div>
<br>
<div class="col-lg-12"></div>
<br>

          <div class="col-md-1"></div>
          <div class="col-md-10">
            <?php mostrarPorAlumno($carnet, $fecha1, $fecha2); ?>             
          </div>
          <div class="col-md-1"></div>
 	
 <?php endif ?>