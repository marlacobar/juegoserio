<?php
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

    //print_r($response);
    $data2 = json_decode($response2,true);
    foreach ($data2 as $key2 => $value){
        if($IdMaximo< $key2)
            $IdMaximo = $key2;
    }
    //echo "El numero maximo es ".$IdMaximo;

    $data = json_decode($response,true);
    $level;
    $nivel_maximo = 1;
    $contador_nivel = 1;
    foreach ($data as $key => $value) {
        if ( @$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel] > $nivel_maximo){
            $nivel_maximo = @$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel];
        }
    }
    //echo "<BR>El Nivel Maximo pasado es ".$nivel_maximo."<BR>";
    while ($contador_nivel <= $nivel_maximo){
        $id_jugador;
        $id_partida;
        $enemigos ;
        $enemigos_muertos ;
        $monedas_obtenidas;
        $monedas_total;
        $murio;
        $puntaje;
        $tiempo;
        $contador = 1;
        
        foreach ($data as $key => $value) {
            if ($data[$key]["resultadoJugadores"]){
                //echo $contador;
                foreach (@$data[$key]["resultadoJugadores"] as $jugador => $value) {
                    foreach(@$data[$key]["resultadoJugadores"][$jugador]["niveles"] as $nivel => $value ){  
                        if ($nivel ==  $contador_nivel){
                            
                            if (@$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosMuertos"] >= 1 ){
                                //echo $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosMuertos"]."--". $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosTotal"]."<BR>";
                                $enemigos_muertos[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosMuertos"];
                                @$enemigos[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["enemigosTotal"];
                                //@$level[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["idNivel"];
                                @$monedas_obtenidas[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["monedasObtenidas"];
                                @$monedas_total[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["monedasTotal"];
                                @$murio[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["murio"];
                                @$puntaje[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["puntaje"];
                                @$tiempo[] = $data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel]["segundos"];
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
    //echo "<BR>";
    //echo "LA MATRIZ MIDE ".$matriz;
    //echo "<BR>";
    //echo "<pre>";
    //var_dump($level['1']['enemigos_muertos']);
    //echo "</pre>";
    //echo "<BR>";
    //echo $contador;*/
    //$matriz= sizeof($enemigos);
    //echo sizeof($enemigos_muertos)."<BR>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | uPlot</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- uPlot -->
  <link rel="stylesheet" href="plugins/uplot/uPlot.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js"></script>
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
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <?php include "barra.php"?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ChartJS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">ChartJS</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- LINE CHART -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Line Chart</h3>

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
              <div id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
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
    <!-- Add Content Here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- uPlot -->
<script src="plugins/uplot/uPlot.iife.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    var partida = [];
    for (i=1; i<= <?php echo @$matriz?>; i++){
      partida.push(i);
    }
    var valX= partida;
    var valY = <?php echo json_encode( $enemigos_muertos    )?>;
    var valY2 = <?php echo json_encode( $enemigos )?>;
    var datosGrafica=deArrayAMatriz(valX, valY, valY2);
    function getSize(elementId) {
      return {
        width: document.getElementById(elementId).offsetWidth,
        height: document.getElementById(elementId).offsetHeight,
      }
    }

    let data = [
      valX,
      valY,
      valY2
    ];

    //--------------
    //- AREA CHART -
    //--------------
    const optsLineChart = {
      ... getSize('lineChart'),
      scales: {
        x: {
          time: false,
        },
        y: {
          range: [0, 100],
        },
      },
      series: [
        {},
        {
          fill: 'transparent',
          width: 5,
          stroke: 'rgba(60,141,188,1)',
        },
        {
          stroke: '#c1c7d1',
          width: 5,
          fill: 'transparent',
        },
      ],
    };
    // Inicializamos la Grafica
    let grafica = new uPlot(optsLineChart, data, document.getElementById('lineChart'),{
      type: 'scatter',
      data: {
        datasets: [{
          data: datosGrafica,
        }]
      }
    });

    window.addEventListener("resize", e => {
      grafica.setSize(getSize('lineChart'));
    });
    // Definimos los parametros en x y en y 
    //Creamos una funcion asincrona (para que se active hasta que termine de cargar la pagina)
    window.onload=async function learnLinear(){
        
        var contador = <?php echo @$matriz?> +1 ;
        var nuevoValX = contador * 2;
        while ( contador < nuevoValX ){
            const learningRate = 0.0001;
            const optimizer2 = tf.train.sgd(learningRate);
            //Definimos el modelo que sera de regresion lineal
            const model = tf.sequential();
            //Agregamos una capa densa porque todos los nodos estan conectado entre si
            model.add(tf.layers.dense({units: 1, inputShape: [1]}));

            // Compilamos el modelo con un sistema de perdida de cuadratico y optimizamos con sdg
            model.compile({loss: 'meanSquaredError', optimizer: optimizer2});
            // Creamos los tensores para x y para y
            const xs = tf.tensor1d(valX);
            const ys = tf.tensor1d(valY);

            // Obtenemos la epocas (Las veces que se repetira para encontrar el valor de x)
            var epocas = 10;
            // Obtenemos el valor de x
            
            const valorX = tf.tensor1d([contador]);
            //tf.tensor1d([nuevoValX]).print();
            //var prediccionY = 10;
            // Ciclo que va ir ajustando el calculo
            for (i = 0; i < epocas ; i++) {
                // Entrenamos el modelo una sola vez (pero como esta dentro de un ciclo se va ir entrenando por cada bucle)
                await model.fit(xs, ys, {epochs: 1});
                // Obtenemos el valor de Y cuando el valor de x sea
                prediccionY = model.predict(valorX).dataSync();
                // Escribimos el valor de y
                //console.log(prediccionY);
                //document.getElementById("valy").innerText = prediccionY;
                // Escribimos en que epoca vamos
                //document.getElementById("epocas").innerText = i+1;
                // Redibujamos la grafica con el nuevo valor de X y Y
                
            }
            if( prediccionY > 0 ){
                    datosGrafica.push({x:contador,y:prediccionY});
                    grafica.data.datasets[0].data = datosGrafica;
                    grafica.update();
                    valX.push(contador);
                    valY.push(prediccionY);
            }
            document.getElementById("valy").innerText = prediccionY;
            contador = contador+2;
        }
    }
    function deArrayAMatriz(arx, ary) {
        var data = [];
        for (i = 0; i < arx.length; i++) {
            data.push({x: arx[i], y: ary[i]});
        }
        return data;
    }
  })
</script>
</body>
</html>
