<?php
	if(isset($_POST['arraysql'])){
  $nuevo_array=json_decode($_POST["arraysql"], true );
	}
	//var_dump(sizeof($nuevo_array));
	$contador = 0;
	while( $contador < sizeof($nuevo_array)){
		$contador2 = 0;
		while($contador2 < 5){
			var_dump($nuevo_array[$contador][$contador2]) ;
		}
	}
?>