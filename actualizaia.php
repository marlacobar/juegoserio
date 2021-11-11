<?php
include "connections/local.php";
$link = Conectarse();
$ya_inserto = 0;
$nuevo_array = [];
if(isset($_POST['arreglofinal'])){
	//echo "alert('ESOOOO');";
	$ya_inserto = 1;
	$nuevo_array=json_decode($_POST["arreglofinal"], true );
	//var_dump(sizeof($nuevo_array));
	//echo "<pre>";
	//var_dump($nuevo_array) ;
	//echo "</pre>";
	$contador = 0;
	while( $contador < sizeof($nuevo_array)){
		//echo "ENTRA AL PRIMER WHILE";
		$contador2 = 0;
		$primero = intval($nuevo_array[$contador][1]);
		$segundo = intval($nuevo_array[$contador][2]);
		$tercero = intval($nuevo_array[$contador][3]);
		$cuarto = intval($nuevo_array[$contador][4]);
		if($primero > 0 && $segundo > 0 && $tercero > 0 && $tercero && 0){
			$SQL_IA ="INSERT INTO `ia`
				(`enemigos_muertos`, `enemigos_total`, `monedas_obtenidas`, `monedas_total`) 
				VALUES ($primero,$segundo,$tercero,$cuarto)";
				mysqli_query($link,$SQL_IA);
		}
		
		$contador++;
	}
	/*echo "LISTO SE CARGO LA IA";
	$SQL_DELETE = " DELETE FROM `ia` WHERE `enemigos_total` = 0 AND `monedas_total`= 0 ;";
	mysqli_query($link,$SQL_DELETE)*/
}

$SQL_JUGADAS = "SELECT * FROM `jugadas` ;";
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
  $idJugador[] = intval($data['idJugador']);
  $idPartida[] = intval($data['idPartida']);
  $enemigosTotal[] = intval($data['enemigosTotal']);
  $enemigosMuertos[] = intval($data['enemigosMuertos']);
  $monedasObtenidas[] = intval($data['monedasObtenidas']);
  $monedasTotal[] = intval($data['monedasTotal']);
  $murio[] = intval($data['murio']);
  $puntaje[] = intval($data['puntaje']);
  $segundos[] = intval($data['segundos']);
  $puzzlesCompletados[] = intval($data['puzzlesCompletados']);
  $puzzlesEvadidos[] = intval($data['puzzlesEvadidos']);
}
$SQLSIZE = "SELECT MAX(idPartida) FROM `jugadas`";
$size_arreglo1 = mysqli_query($link,$SQLSIZE);
while($data2= mysqli_fetch_array($size_arreglo1)){
	$size_arreglo = intval($data2[0]);
}
//echo $size_arreglo;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Juego Serio | Predicciones</title>

  <script src="dist/tf.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">

<form name=form1 method="POST" action="actualizaia.php">
<input type="hidden" id="arreglofinal" name="arreglofinal" value="">

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
<script>
if(<?php echo $ya_inserto?> == 0){
var valX= <?php echo json_encode( $idPartida )?>;
//************** Se crean los arreglos ************************************************
  var valY = <?php echo json_encode( $enemigosMuertos )?>;
  var valY2 = <?php echo json_encode( $enemigosTotal )?>;
  //Arreglos de Monedas
  var valmonedas1 = <?php echo json_encode( $monedasObtenidas )?>;
  var valmonedas2 =<?php echo json_encode( $monedasTotal )?>;
//************** Se crean los arreglos para las tablas*********************************
  //Areglo tabla enemigos
  var sin = [],cos = [];
  //Arreglo tabla monedas
  var sinmoneda = [],cosmoneda = [];
  var arraysql = [];
    for (var i = 0; i < <?php echo @$size_arreglo ?>; i += 1) {
    sin.push([valX[i],valY[i]]);
    cos.push([valX[i],valY2[i]]);
    sinmoneda.push([valX[i],valmonedas1[i]]);
    cosmoneda.push([valX[i],valmonedas2[i]]);
    arraysql.push([valX[i],valY[i],valY2[i],valmonedas1[i],valmonedas2[i]]);
    }
//console.log("entramos aqui");
    window.onload=async function learnLinear(){
	      var contador = <?php echo json_encode( $size_arreglo )?>;
	      var contador2 = contador;
	      var contador_monedas = contador;
	      var nuevoValX = contador + (contador /2);
	      while ( contador < nuevoValX ){
	          const learningRate = 0.0001;
	          const optimizer2 = tf.train.sgd(learningRate);
	          var epocas = 500;
	          const valorX = tf.tensor1d([contador]);
	          const xs = tf.tensor1d(valX)
	          // Modelo de enemigos
	          const model = tf.sequential();
	          const model2 = tf.sequential();
	          //Modelo de monedas
	          const modelmonedas = tf.sequential();
	          const modelmonedas2 = tf.sequential();
	          //console.log("ya definimos los modelos");
	//***************Se agregan las capas densas de los modelos**************************************
	          //Capas densas de enemigos
	          model.add(tf.layers.dense({units: 1, inputShape: [1]}));
	          model2.add(tf.layers.dense({units: 1, inputShape: [1]}));
	          //Capas densas de monedas
	          modelmonedas.add(tf.layers.dense({units: 1, inputShape: [1]}));
	          modelmonedas2.add(tf.layers.dense({units: 1, inputShape: [1]}));
	          //console.log("ya definimos las capas");
	//***************Se compilan los modelos *********************************************************
	          //Compilan modelos enemigos
	          model.compile({loss: 'meanSquaredError', optimizer: optimizer2});
	          model2.compile({loss: 'meanSquaredError', optimizer: optimizer2});
	          //Complian modelos monedas
	          modelmonedas.compile({loss: 'meanSquaredError', optimizer: optimizer2});
	          modelmonedas2.compile({loss: 'meanSquaredError', optimizer: optimizer2});  
	          //console.log("ya definimos el margen de perdida");     
	//***************Creamos los tensores para x y para y para todas las tablas************************
	          //Tensores Enemigos
	          const ys = tf.tensor1d(valY);
	          const ys2 = tf.tensor1d(valY2);
	          //Tensores Monedas
	          const ysmonedas = tf.tensor1d(valmonedas1);
	          const ysmonedas2 = tf.tensor1d(valmonedas2);          
	//***************Ciclo que va ir ajustando el calculo*******************************************
	          for (i = 0; i < epocas ; i++) {
	              //console.log("ciclo de entrenamiento");
	              await model.fit(xs, ys, {epochs: 1});
	              //console.log("ya definimos los modelos1");
	              await model2.fit(xs, ys2, {epochs: 1});
	              //console.log("ya definimos los modelos2");
	              //Entramiento de los modelos de monedas
	              await modelmonedas.fit(xs, ysmonedas, {epochs: 1});
	              await modelmonedas2.fit(xs, ysmonedas2, {epochs: 1});
	              //console.log("entrenamos las monedas");
	// **************Se encuentran las predicciones ***********************************************
	              //Prediccion de enemigos
	              prediccionY = model.predict(valorX).dataSync();
	              prediccionY2 = model2.predict(valorX).dataSync();
	              //Prediccion de monedas
	              prediccionmonedasY = modelmonedas.predict(valorX).dataSync();
	              prediccionmonedasY2 = modelmonedas2.predict(valorX).dataSync();
	              console.log("ENTRA A UNA ITERACION");
	          }
	          //console.log("terminamos el ciclo");
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
	          if( prediccionY > 0 && prediccionmonedasY > 0 && prediccionY2 >= 0 && prediccionmonedasY2 >= 0 ){
	          	arraysql.push([
	          		contador2,prediccionYint,prediccionYint2,
	          		prediccionmonedasYint,prediccionmonedasYint2
	          		]);
	          }
	          console.log("SE AGREGARON EN LAS 4 ARRAYS");
	          contador = contador+1;
	     }
	     var variable_array = JSON.stringify(arraysql);
	     document.getElementById("arreglofinal").value= variable_array;
	     document.form1.submit();
	    
	    /*var datos = {
	      "arreglo" : variable_array
	      };
		var url = "actualizaia2.php"; // URL a la cual enviar los datos
	    enviarDatos(datos); // Ejecutar cuando se quiera enviar los datos
	    function enviarDatos(datos){
	      $.ajax({
	              data: datos,
	              url: "insertardb.php",
	              type: 'POST',
	              success: function(data) {
				      alert('success');
				  },
				  error: function(data) {
				    alert('error');
				  }
	      });
	    }*/
	}
}

  
</script>

</body>
</html>
