<?php
include "connections/local.php";
$link = Conectarse();
$SQL_JUGADAS = "SELECT * FROM `ia` ;";
$sql = mysqli_query($link,$SQL_JUGADAS);
//echo "<pre>";
//var_dump($sql);
 //echo "</pre>";
  $idJugador = array();
  $idPartida = array();
  $enemigosTotal = array();
  $enemigosMuertos = array();
  $monedasObtenidas = array();
  $monedasTotal = array();
  $murio = array();
  $puntaje = array();
  $segundos = array();
  $puzzlesCompletados = array();
  $puzzlesEvadidos = array();
while($data= mysqli_fetch_array($sql)){
  $idPartida[] = intval($data[0]);
  $enemigosTotal[] = intval($data['enemigos_total']);
  $enemigosMuertos[] = intval($data['enemigos_muertos']);
  $monedasObtenidas[] = intval($data['monedas_obtenidas']);
  $monedasTotal[] = intval($data['monedas_total']);
}
$SQLSIZE = "SELECT MAX(X) FROM `ia`";
$size_arreglo1 = mysqli_query($link,$SQLSIZE);
while($data2= mysqli_fetch_array($size_arreglo1)){
  $size_arreglo = intval($data2[0]);
}
//echo "EL ARREGLO MIDE :"+$size_arreglo1  ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Juego Serio | Predicciones</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="dist/tf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="home.php" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php include "barra.php"?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Predicciones</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Predicciones</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
  <!-- <div>
    <p> 
      <?php
        $v1=$_GET['id'];
        echo $v1;
      ?>
    </p>
  </div> -->
<!--********************************INICIA FLOT ENEMIGOS***********************************-->
      <div class="container-fluid">
       <div class="row">
          <div class="col-12">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Predicción de Enemigos
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="line-chart" style="height: 300px;"></div>
              </div>
              <!-- /.card-body-->
            </div>

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
<!--********************************TERMINA FLOT ENEMIGOS***********************************-->
<!--********************************INICIA FLOT MONEDAS***********************************-->
        <div class="row">
          <div class="col-12">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Predicción de Monedas
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="line-chart_monedas" style="height: 300px;"></div>
              </div>
              <!-- /.card-body-->
            </div>

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
<!--********************************TERMINA FLOT MONEDAS***********************************-->
<!--********************************INICIA FLOT ***********************************-->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0-rc
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- FLOT CHARTS -->
<script src="plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="plugins/flot/plugins/jquery.flot.pie.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  var valX= <?php echo json_encode( $idPartida )?>;
//************** Se crean los arreglos ************************************************
  //Arreglos de enemigos
  var valY = <?php echo json_encode( $enemigosMuertos )?>;
  ////console.log(valY);
  var valY2 = <?php echo json_encode( $enemigosTotal )?>;
  ////console.log(valX);
////console.log(valY2);
  //Arreglos de Monedas
  var valmonedas1 = <?php echo json_encode( $monedasObtenidas  )?>;
  var valmonedas2 =<?php echo json_encode( $monedasTotal )?>;
//console.log(valX[200]);
//************** Se crean los arreglos para las tablas*********************************
  //Areglo tabla enemigos
  var sin = [],cos = [];
  //Arreglo tabla monedas
  var sinmoneda = [],cosmoneda = [];
  for (var i = 0; i < <?php echo $size_arreglo ?>; i += 5) {
    sin.push([valX[i],valY[i]]);
    
    cos.push([valX[i],valY2[i]]);
    sinmoneda.push([valX[i],valmonedas1[i]]);
    cosmoneda.push([valX[i],valmonedas2[i]]);
  }

/******************************LINEAS DE CADA GRAFICA ************************************/
/******************************LINEAS ENEMIGOS*****************************************/
  var line_data1 = {
    data : cos,
    color: '#3c8dbc'
  }
  var line_data2 = {
    data : sin,
    color: '#00c0ef'
  }
/******************************LINEAS ENEMIGOS*****************************************/
  var line_monedas1  = {
    data : sinmoneda,
    color: '#00c0ef'
  }
  var line_monedas2 = {
    data : cosmoneda,
    color: '#3c8dbc'
  }
  //console.log(sin);
/***********************Inicializamos todas las Graficas***********************************/
/****************Inicializamos la Grafica de enemigos**************************************/
  var grafica = new $.plot('#line-chart', [line_data1, line_data2], {
      grid:{ hoverable:true, borderColor:'#f3f3f3',borderWidth: 1,
      tickColor:'#f3f3f3'},series:{shadowSize: 0,lines:{show: true},
      points:{show:true}},lines:{fill:false,color:['#3c8dbc', '#f56954']},
      yaxis:{show: true},xaxis:{show: true},options:{responsive: false}
    })
  //Initialize tooltip on hover
  $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
    position:'absolute', display:'none', opacity:0.8}).appendTo('body')
  $('#line-chart').bind('plothover', function (event, pos, item) {
    if (item) { var x = item.datapoint[0].toFixed(2),y = item.datapoint[1].toFixed(2)
      $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
      .css({top : item.pageY + 5, left: item.pageX + 5}).fadeIn(200)} 
    else {$('#line-chart-tooltip').hide()}})
/****************Inicializamos la Grafica de monedas**************************************/
  var grafica_monedas = new $.plot('#line-chart_monedas', [line_monedas1, line_monedas2], {
      grid:{ hoverable:true, borderColor:'#f3f3f3',borderWidth: 1,
      tickColor:'#f3f3f3'},series:{shadowSize: 0,lines:{show: true},
      points:{show:true}},lines:{fill:false,color:['#3c8dbc', '#f56954']},
      yaxis:{show: true},xaxis:{show: true},options:{responsive: false}
    })
  //Initialize tooltip on hover
  $('<div class="tooltip-inner" id="line-chart-tooltip_monedas"></div>').css({
    position:'absolute', display:'none', opacity:0.8}).appendTo('body')
  $('#line-chart_monedas').bind('plothover', function (event, pos, item) {
    if (item) { var x = item.datapoint[0].toFixed(2),y = item.datapoint[1].toFixed(2)
      $('#line-chart-tooltip_monedas').html(item.series.label + ' of ' + x + ' = ' + y)
      .css({top : item.pageY + 5, left: item.pageX + 5}).fadeIn(200)} 
    else {$('#line-chart-tooltip_monedas').hide()}})

function labelFormatter(label, series) {
  return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
    + label
    + '<br>'
    + Math.round(series.percent) + '%</div>'
}

</script>

</body>
</html>
