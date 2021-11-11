<?php
include "connections/local.php";
$link = Conectarse();
$SQL_DELETE = "DELETE FROM `jugadas`";
$SQL = mysqli_query($link, $SQL_DELETE);
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
  $data2 = json_decode($response2,true);
  foreach ($data2 as $key2 => $value){
      if($IdMaximo< $key2)
          $IdMaximo = $key2;
  }
  $data = json_decode($response,true);
  $level;
  $nivel_maximo = 1;
  $contador_nivel = 1;
  foreach ($data as $key => $value) {
      if ( @$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel] > $nivel_maximo){
          $nivel_maximo = @$data[$key]["resultadoJugadores"][$jugador]["niveles"][$nivel];
      }
  }
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
  $contador_partidas = 0;
  foreach($data as $key => $value){
    foreach($value['resultadoJugadores'] as $key2 => $value2){
      foreach($value2["niveles"] as $key3 => $value3){
        if( @$value2['idJugador'] != NULL && @$value3['enemigosTotal'] != NULL && @$value3['monedasTotal'] != NULL ){
          @$idJugador=$value2['idJugador'];
          @$idPartida = $contador_partidas +1;
          @$enemigosMuertos = $value3['enemigosMuertos'];
          @$enemigosTotal = $value3['enemigosTotal'];
          @$monedasObtenidas = $value3['monedasObtenidas'];
          @$monedasTotal = $value3['monedasTotal'];
          @$murio = $value3['murio'];
          @$puntaje = $value3['puntaje'];
          @$segundos = $value3['segundos'];
          @$contador_partidas ++;
          @$puzzlesCompletados = $value2['puzzlesCompletados'];
          @$puzzlesEvadidos = $value2['puzzlesEvadidos'];
          $SQL_INSERT = "INSERT INTO `jugadas`(`idPartida`, `idJugador`, `enemigosTotal`, `enemigosMuertos`, `monedasObtenidas`, `monedasTotal`, `murio`, `puntaje`, `segundos`, `puzzlesCompletados`, `puzzlesEvadidos`) 
          VALUES (
            $idPartida, $idJugador, $enemigosTotal, $enemigosMuertos, $monedasObtenidas, $monedasTotal, $murio, $puntaje, $segundos, $puzzleCompletados, $puzzleEvadidos
            )";
          $SQL = mysqli_query($link, $SQL_INSERT);
        } 
      }    
    }   
  }
?>
