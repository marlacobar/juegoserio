/*
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
/*echo "<BR>";
echo "LA MATRIZ MIDE ".$matriz;
echo "<BR>";
echo "<pre>";
//var_dump($level['1']['enemigos_muertos']);
echo "</pre>";
echo "<BR>";
echo $contador;*/
//$matriz= sizeof($enemigos);
    //echo sizeof($enemigos_muertos)."<BR>";
?>
<html>
  <head>
    <!-- Load TensorFlow.js -->
     <!--<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.9.0/dist/tf.min.js"> </script>-->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.9.0/dist/tf.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <!-- Place your code in the script tag below. You can also use an external .js file -->
    
  </head>

  <body>
    <table border="0">
        <tbody>
            <tr>
                <td>Repeticiones</td>
                <td><input type="number" id="repeticiones" value="100"/></td>
            </tr>
            <tr>
                <td>Valor de X</td>
                <td><input type="number" id="nuevoValX" value= "<?php echo @$matriz*2?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" id="calcular" value= "Calcular" onclick="learnLinear()"/></td>
            </tr>
            <tr>
                <td>Valor de Y</td>
                <td><span id="valy"></span></td>
            </tr>
            <tr>
                <td>Epoca</td>
                <td><span id="epocas"></span></td>
            </tr>
        </tbody>
    </table>
    <canvas id="myChart" width="400" height="400"></canvas>

    <div id="salida"></div>

  </body>
  <script>
    var partida = [];
    //const enemigosX = [10,20,30,40,50,60,70,80,90,100,110,120,130,140,150,160,170,180,190,200];
    for (i=1; i<= <?php echo @$matriz?>; i++){
                    partida.push(i);
    }
    var valX= partida;
    var valY = <?php echo json_encode( $enemigos_muertos    )?>;
    // Definimos los parametros en x y en y
    
    var datosGrafica=deArrayAMatriz(valX, valY);
    // Inicializamos la Grafica
    var grafica = new Chart(document.getElementById("myChart"), {
        type: 'scatter',
        data: {
            datasets: [{
                    label: "Estadisticas",
                    data: datosGrafica,
                    borderColor: "red",
                }]
        },
        options: {
            responsive: false
            
        }
    });

    //Creamos una funcion asincrona (para que se active hasta que termine de cargar la pagina)
    async function learnLinear(){

        //Definimos el modelo que sera de regresion lineal
        const model = tf.sequential();
        //Agregamos una capa densa porque todos los nodos estan conectado entre si
        model.add(tf.layers.dense({units: 1, inputShape: [1]}));

        // Compilamos el modelo con un sistema de perdida de cuadratico y optimizamos con sdg
        model.compile({loss: 'meanSquaredError', optimizer: 'sgd'});
        // Creamos los tensores para x y para y
        const xs = tf.tensor2d(valX, [157, 1]);
        const ys = tf.tensor2d(valY, [157, 1]);

        // Obtenemos la epocas (Las veces que se repetira para encontrar el valor de x)
        var epocas = +document.getElementById("repeticiones").value;
        // Obtenemos el valor de x
        var nuevoValX = +document.getElementById("nuevoValX").value;
        
        // Ciclo que va ir ajustando el calculo
        for (i = 0; i < epocas; i++) {
            // Entrenamos el modelo una sola vez (pero como esta dentro de un ciclo se va ir entrenando por cada bucle)
            await model.fit(xs, ys, {epochs: 1});
            // Obtenemos el valor de Y cuando el valor de x sea
            var prediccionY = model.predict(tf.tensor2d([nuevoValX], [1, 1])).dataSync()[0];
            // Escribimos el valor de y
            document.getElementById("valy").innerText = prediccionY;
            // Escribimos en que epoca vamos
            document.getElementById("epocas").innerText = i+1;
            // Redibujamos la grafica con el nuevo valor de X y Y
            datosGrafica.push({x:nuevoValX,y:prediccionY});
            grafica.data.datasets[0].data = datosGrafica;
            grafica.update();
        }

    }
    function deArrayAMatriz(arx, ary) {
        var data = [];
        for (i = 0; i < arx.length; i++) {
            data.push({x: arx[i], y: ary[i]});
        }
        return data;
    }
    
     //learnLinear(); 
    </script>
</html>

*/