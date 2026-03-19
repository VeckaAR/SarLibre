<?php 
include ("controller/controller.php");
?>


<section class="container-fluid p-4 col-lg-12">
	<div class="row justify-content-center"> 
    <div class="d-flex align-items-center col-sm-12 col-md-5 bg-primary text-white mr-1 pl-4">
      <a href="estadisticas.php">
      <div class="row bg-primary">
       <div class="col-sm-6 p-3 pl-5 pt-5">
        <h2>Informe inicial</h2>
        <div class="">
         <div class=""><h4>Ciclo Actual:</h4></div>
         <div class="">
           <h3><?php ObtenerCiclo(); ?></h3>
         </div>
       </div>
       <div class="">
         <div class=""><h4>Cantidad Alumno:</h4></div>
         <div class="">
           <h3><?php ObtenerCantAlumnos(); ?></h3>
         </div>
       </div>
       <div class="">
         <div class=""><h4>Total de Horas:</h4></div>
         <div class="">
           <h3><?php ObtenerCantHoras(); ?></h3>
         </div>
       </div>

     </div>
     <div class="col-sm-6 p-3">
      <img src="img/information.png" alt="">
    </div>
  </div>
  </a>
</div>
<div class="col-sm-12 col-md-5 ml-1">
  <div class="bg-warning text-white mb-1 p-4">
    <a href="informesGeneral.php" class="text-white">
      <div class="row">
        <div class="col-sm-5 col-md-4"><img src="img/calendar.png" alt="" width="100px"></div>
        <div class="col-sm-5 col-md-6"><h2>Informe por periodos</h2></div>
      </div>
    </a>
  </div>
  <br>
  <div class="bg-danger text-white mt-1 p-4">
    <a href="informesAlumno.php" class="text-white"><div class="row">
      <div class="col-sm-5 col-md-4"><img src="img/student.png" alt="" width="100px"></div>
      <div class="col-sm-5 col-md-6"><h2>Informe por alumnos</h2></div>
    </div>
  </a> 
</div>
<br>
<div class="bg-info text-white mt-1 p-4">
    <a href="matenimiento.php" class="text-white">
        <div class="row">
            <div class="col-sm-5 col-md-4"><img src="img/mtto.png" alt="" width="100px"></div>
            <div class="col-sm-5 col-md-6"><h2>Modulo de mantenimiento</h2></div>
        </div>
    </a>
</div>

  </a> 
</div>
</div>
</div>		
</section>
