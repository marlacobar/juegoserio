<?php
$recibio = 0;
$arrayRecibidoEnemigos1 = [];
$arrayRecibidoEnemigos2 = [];
$arrayRecibidoMonedas1 = [];
$arrayRecibidoMonedas2 = [];
if(isset($_POST['enemigos1'])){
  $arrayRecibidoEnemigos1=json_decode($_POST["enemigos1"], true );
  $arrayRecibidoEnemigos2=json_decode($_POST["enemigos2"], true );
  $arrayRecibidoMonedas1=json_decode($_POST["monedas1"], true );
  $arrayRecibidoMonedas2=json_decode($_POST["monedas2"], true );
  @$recibio = 1;
}
else{
  @$recibio = 0;
}
  $IdMaximo = 0;
  $url2 = "https://modulargame-5ef83-default-rtdb.firebaseio.com/usuarios.json";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url2);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response2 = curl_exec($ch);
  curl_close($ch);
  $url = "https://modulargame-5ef83-default-rtdb.firebaseio.com/resultados.json";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch);
  $data = json_decode($response,true);
  $data2 = json_decode($response2,true);
  foreach ($data2 as $key2 => $value){
      if($IdMaximo< $key2)
          $IdMaximo = $key2;
  }
  $level;
  $nivel_maximo = 1;
  $contador_nivel = 1;
  foreach ($data as $key => $value) {
      if ( @$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel] > $nivel_maximo){
          $nivel_maximo = @$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel];
      }
  }
  $id_jugador;
  $id_partida;
  $enemigos ;
  $enemigos_muertos ;
  $monedas_obtenidas;
  $monedas_total;
  $murio;
  $puntaje;
  $tiempo;
  // echo "<BR>El Nivel Maximo pasado es ".$nivel_maximo."<BR>";
  while ($contador_nivel <= $nivel_maximo){
    $contador = 1;
    foreach ($data as $key => $value) {
      if ($data[$key]["resultadoJugadores"]){
        foreach (@$data[$key]["resultadoJugadores"] as $jugador => $value) {
          foreach(@$data[$key]["resultadoJugadores"][$jugador]["niveles"] as $nivel => $value ){  
            if ($nivel ==  $contador_nivel){
              if (@$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosMuertos"] >= 1 ){
                $enemigos_muertos[]=$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosMuertos"];
                @$enemigos[]=$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosTotal"];
                @$monedas_obtenidas[]=$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["monedasObtenidas"];
                @$monedas_total[]=$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["monedasTotal"];
                @$murio[]=$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["murio"];
                @$puntaje[]=$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["puntaje"];
                @$tiempo[]=$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["segundos"];
              }
            }                       
          }   
          $contador ++;
        }   
      }
    }
    $matriz= sizeof($enemigos);
    @$level[@$contador_nivel] = array (
      'enemigos_muertos' => array (@$enemigos_muertos), 
      'enemigos_total'=> array (@$enemigos), 
      'monedas_obtenidas'=> array (@$monedas_obtenidas), 
      'monedas_total'=> array (@$monedas_total), 
      'murio'=> array (@$murio), 
      'puntaje'=> array (@$puntaje), 
      'tiempo'=> array (@$tiempo)
    );
    $contador_nivel ++;
  }
  // OBTENER EL ID DEL JUGADOR
  $idJugador=$_GET['id'];
  $username
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
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js"></script>
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
    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
          <span class="info-box-icon bg-lightblue"><i class="fas fa-gamepad"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Partidas Jugadas</span>
            <span class="info-box-number">
              <?php
                $count= 0;
                foreach ($data as $key => $value) {
                  foreach ($data[$key]["resultadoJugadores"] as $jugador => $value) {

                    if($idJugador == $data[$key]["resultadoJugadores"][$jugador]["idJugador"]) {
                      $count++;
                    }                  
                  }
                }
                echo $count;
              ?>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
          <span class="info-box-icon bg-lightblue"><i class="far fa-chart-bar"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Tendencia al Riesgo</span>
            <span class="info-box-number">
              <?php
                $count= 0;
                echo $count;
              ?>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
          <span class="info-box-icon bg-lightblue"><i class="fas fa-gamepad"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Niveles Completados</span>
            <span class="info-box-number">
              <?php
                $count= 0;
                foreach ($data as $key => $value) {
                  foreach ($data[$key]["resultadoJugadores"] as $jugador => $value) {
                    if($idJugador == $data[$key]["resultadoJugadores"][$jugador]["idJugador"]) {
                      // print_r($data[$key]["resultadoJugadores"][$jugador]["ultimoNivel"]);
                      foreach ($data[$key]["resultadoJugadores"][$jugador]["niveles"] as $nivel => $value) {
                        if($data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel] != null) {
                          // print_r($data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["murio"]);
                          // echo " - ";
                          if($data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["murio"] == 0) {
                            $count++;
                          }
                        }
                      }
                    }
                  }
                }
                echo $count;
              ?>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>


    <div class="row">
      <!-- Left col -->
      <div class="card card-lightblue">
        <div class="card-header">
          <h3 class="card-title">Enemigos</h3>

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
          <div class="chart">
            <canvas id="enemiesBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
<!--********************************INICIA FLOT ENEMIGOS***********************************-->
      <div class="container-fluid">
       <div class="row">
          <div class="col-12">
            <!-- Line chart -->
            <div class="card card-lightblue card-outline">
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
            <div class="card card-lightblue card-outline">
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
  var partida = [];
  for (i=1; i<= <?php echo @$matriz?>; i++){
      partida.push(i);
  }
  var valX= partida;
//************** Se crean los arreglos ************************************************
  //Arreglos de enemigos
  var valY = <?php echo json_encode( $enemigos_muertos )?>;
  var valY2 = <?php echo json_encode( $enemigos )?>;

  //Arreglos de Monedas
  var valmonedas1 = <?php echo json_encode( $monedas_obtenidas )?>;
  var valmonedas2 =<?php echo json_encode( $monedas_total )?>;

//************** Se crean los arreglos para las tablas*********************************
  //Areglo tabla enemigos
  var sin = [],cos = [];
  //Arreglo tabla monedas
  var sinmoneda = [],cosmoneda = [];
  if ( <?php echo $recibio;?> == 1){
    cos = <?php echo json_encode( $arrayRecibidoEnemigos1 )?>;
    sin = <?php echo json_encode( $arrayRecibidoEnemigos2 )?>;
    cosmoneda = <?php echo json_encode( $arrayRecibidoMonedas1 )?>;
    sinmoneda = <?php echo json_encode( $arrayRecibidoMonedas2 )?>;
  }
  else{
    for (var i = 0; i < <?php echo @$matriz?>; i += 1) {
    sin.push([valX[i],valY[i]]);
    cos.push([valX[i],valY2[i]]);
    sinmoneda.push([valX[i],valmonedas1[i]]);
    cosmoneda.push([valX[i],valmonedas2[i]]);
    }
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
  var line_monedas1 = {
    data : sinmoneda,
    color: '#3c8dbc'
  }
  var line_monedas2 = {
    data : cosmoneda,
    color: '#00c0ef'
  }
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



      window.onload=async function learnLinear(){
      console.log("minimo entra aqui2");
      var contador = <?php echo @$matriz?>  ;
      var contador2 = contador;
      var contador_monedas = contador;
      var nuevoValX = contador + ( contador / 2);
      
      while ( contador < nuevoValX ){
//*************** Constantes y variables para completar los tensores y predicciones***************
          const learningRate = 0.0001;
          const optimizer2 = tf.train.sgd(learningRate);
          var epocas = 1000;
          const valorX = tf.tensor1d([contador]);
          const xs = tf.tensor1d(valX)
//***************Se definen todos los modelos****************************************************
          // Modelo de enemigos
          const model = tf.sequential();
          const model2 = tf.sequential();
          //Modelo de monedas
          const modelmonedas = tf.sequential();
          const modelmonedas2 = tf.sequential();
//***************Se agregan las capas densas de los modelos**************************************
          //Capas densas de enemigos
          model.add(tf.layers.dense({units: 1, inputShape: [1]}));
          model2.add(tf.layers.dense({units: 1, inputShape: [1]}));
          //Capas densas de monedas
          modelmonedas.add(tf.layers.dense({units: 1, inputShape: [1]}));
          modelmonedas2.add(tf.layers.dense({units: 1, inputShape: [1]}));
//***************Se compilan los modelos *********************************************************
          //Compilan modelos enemigos
          model.compile({loss: 'meanSquaredError', optimizer: optimizer2});
          model2.compile({loss: 'meanSquaredError', optimizer: optimizer2});
          //Complian modelos monedas
          modelmonedas.compile({loss: 'meanSquaredError', optimizer: optimizer2});
          modelmonedas2.compile({loss: 'meanSquaredError', optimizer: optimizer2});       
//***************Creamos los tensores para x y para y para todas las tablas************************
          //Tensores Enemigos
          const ys = tf.tensor1d(valY);
          const ys2 = tf.tensor1d(valY2);
          //Tensores Monedas
          const ysmonedas = tf.tensor1d(valmonedas1);
          const ysmonedas2 = tf.tensor1d(valmonedas2);          
//***************Ciclo que va ir ajustando el calculo*******************************************
          for (i = 0; i < epocas ; i++) {
// **************Entrenamos los modelos *******************************************************
              //Entrenamiento de los modelos de enemigos
              await model.fit(xs, ys, {epochs: 1});
              await model2.fit(xs, ys2, {epochs: 1});
              //Entramiento de los modelos de monedas
              await modelmonedas.fit(xs, ysmonedas, {epochs: 1});
              await modelmonedas2.fit(xs, ysmonedas2, {epochs: 1});
// **************Se encuentran las predicciones ***********************************************
              //Prediccion de enemigos
              prediccionY = model.predict(valorX).dataSync();
              prediccionY2 = model2.predict(valorX).dataSync();
              //Prediccion de monedas
              prediccionmonedasY = modelmonedas.predict(valorX).dataSync();
              prediccionmonedasY2 = modelmonedas2.predict(valorX).dataSync();
          }
          if( prediccionY > 0 ){
            prediccionYint = parseInt(prediccionY);
            prediccionYint2 = parseInt(prediccionY2);
            sin.push([contador2,prediccionYint]);
            cos.push([contador2,prediccionYint2]);
            contador2++;       
          }
          if ( prediccionmonedasY > 0 ){
            prediccionmonedasYint = parseInt(prediccionmonedasY);
            prediccionmonedasYint2 = parseInt(prediccionmonedasY2);
            sinmoneda.push([contador2,prediccionmonedasYint]);
            cosmoneda.push([contador2,prediccionmonedasYint2]);
            contador_monedas++; 
          }
          console.log("SE AGREGARON EN LAS 4 ARRAYS")
          contador = contador+1;
      }
/******************Se preparan las variables para enviar por POST ***************************/
    var variable_enemigos1 = JSON.stringify(sin);
    var variable_enemigos2 =JSON.stringify(cos);
    var variable_monedas1 = JSON.stringify(sinmoneda);
    var variable_monedas2 = JSON.stringify(cosmoneda);
    var datos = {
      "enemigos1" : variable_enemigos1, // Dato #1 a enviar
      "enemigos2" : variable_enemigos2,// Dato #2 a enviar
      "monedas1" : variable_monedas1,
      "monedas2" : variable_monedas2
      // etc...
      };
/*********************Recargamos las tablas*************************************/
/*********************Tabla Enemigos *********************************************/
    var grafica = new $.plot('#line-chart', [line_data1, line_data2], {
      grid:{ hoverable:true, borderColor:'#f3f3f3',borderWidth: 1,
      tickColor:'#f3f3f3'},series:{shadowSize: 0,lines:{show: true},
      points:{show:true}},lines:{fill:false,color:['#3c8dbc', '#f56954']},
      yaxis:{show: true},xaxis:{show: true},options:{responsive: false}
    })
/*********************TERMINA Tabla Enemigos *********************************************/
 /*********************Tabla Monedas *********************************************/   
  var grafica_monedas = new $.plot('#line-chart_monedas', [line_monedas1, line_monedas2], {
      grid:{ hoverable:true, borderColor:'#f3f3f3',borderWidth: 1,
      tickColor:'#f3f3f3'},series:{shadowSize: 0,lines:{show: true},
      points:{show:true}},lines:{fill:false,color:['#3c8dbc', '#f56954']},
      yaxis:{show: true},xaxis:{show: true},options:{responsive: false}
    })
 /*********************TERMINA Tabla Monedas *********************************************/ 
      /*setInterval(function(){
     window.location.reload(true);
      },1000);*/
    var url = "flotUser.php"; // URL a la cual enviar los datos
    enviarDatos(datos, url); // Ejecutar cuando se quiera enviar los datos
    function enviarDatos(datos, url){
      $.ajax({
              data: datos,
              url: url,
              type: 'post',
              success:  function (response) {
                  console.log(response); // Imprimir respuesta del archivo
              },
              error: function (error) {
                  console.log(error); // Imprimir respuesta de error
              }
      });
    }
}









function labelFormatter(label, series) {
  return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
    + label
    + '<br>'
    + Math.round(series.percent) + '%</div>'
}


//-----
$(function() {
  var barChartData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
      {
        label               : 'Enemigos Total',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [28, 48, 40, 19, 86, 27, 90]
      },
      {
        label               : 'Enemigos Muertos',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : [65, 59, 80, 81, 56, 55, 40]
      },
    ]
  }


  //---------------------
  //- ENEMIES BAR CHART -
  //---------------------
  var enemiesbarChartCanvas = $('#enemiesBarChart').get(0).getContext('2d')
    var enemiesbarChartData = $.extend(true, {}, barChartData)
    var temp0 = barChartData.datasets[0]
    var temp1 = barChartData.datasets[1]
    enemiesbarChartData.datasets[0] = temp0
    enemiesbarChartData.datasets[1] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(enemiesbarChartCanvas, {
      type: 'bar',
      data: enemiesbarChartData,
      options: barChartOptions
    })
  })

</script>

</body>
</html>
