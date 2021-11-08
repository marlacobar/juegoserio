<?php
session_start();
if(isset($_SESSION['user'])){
    header('Location: principal.php');
    exit;
}
include "connections/local.php";
$link = Conectarse();
$msg_error = "";
#Validar usuario y contraseña
if(isset($_POST['txt_usuario']) && isset($_POST['txt_password'])){
	$sqlQ= "SELECT * FROM usuario WHERE usuario = '".$_POST['txt_usuario']."' AND password = '".$_POST['txt_password']."'";
	//echo $sqlQ;
	$result = mysqli_query ($link,$sqlQ);
	if(!$result){
		die("Se presento un problema al correr el query");
	}
	if($row = mysqli_fetch_assoc($result)){
        echo "Entro ";
		$_SESSION['user'] = $_POST['txt_usuario'];
        $_SESSION['tipo'] = $row['tipo_usuario'];
		header('Location: principal.php');
		exit;
	}
	else{
		$msg_error = 'El usuario y/o contraseña son incorrectos.';
	}

	
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Proyecto</title>
	<link href="css/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="vendor/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="vendor/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- CSS -->
    <link href="css/2cto_style.css" rel="stylesheet">
	<!-- Custom Footer -->
    <link href="css/sticky-footer.css" rel="stylesheet">
    <script >
    	function fn_revisa(){
    		if(document.forms[0].txt_usuario.value == "")
    			document.forms[0].txt_usuario.focus();
    		else
    			if(document.forms[0].txt_password.value == "")
    			document.forms[0].txt_password.focus();
    		else
    			document.forms[0].submit();
    	}
nextfield = "start"; // name of first box on page
netscape = "";
ver = navigator.appVersion; len = ver.length;
for (iln = 0; iln < len; iln++) if (ver.charAt(iln) == "(") break;
netscape = (ver.charAt(iln + 1).toUpperCase() != "C");

function keyDown(DnEvents) { // handles keypress
    // determines whether Netscape or Internet Explorer
    k = (netscape) ? DnEvents.which : window.event.keyCode;
    if (k == 13) { // enter key pressed
        if (nextfield == 'done')
            fn_revisa();
            //return true; // submit, we finished all fields
        else { // we're not done yet, send focus to next box
            eval('dynamic-content_updatement.theform.' + nextfield + '.focus()');
            return false;
        }
   }
}
document.onkeydown = keyDown; // work together to analyze keystrokes
if (netscape) document.captureEvents(Event.KEYDOWN | Event.KEYUP);
</script>
<script>
     function vlid(){
      var contra1= document.getElementById('pwd').value;
      var contra2= document.getElementById('pwd2').value;
      var nombre = document.getElementById("txt_nombre_nuevo").value;
      var mail = document.getElementById("txt_email_nuevo").value;
      if (contra1 != "" && nombre != "" && mail != "" && contra2 != ""){
        if(contra1 === contra2){
              
             var comN=mail.indexOf('@');
             
             if((mail.substring(comN)==="@ACADEMICO.UDN.MX")||(mail.substring(comN)==="@academico.udn.mx")||
                (mail.substring(comN)==="@ACADEMICOS.UDN.MX")||(mail.substring(comN)==="@academicos.udn.mx")||
                (mail.substring(comN)==="@PROFESOR.UDN.MX")||(mail.substring(comN)==="@profesor.udn.mx")||
                (mail.substring(comN)==="@PROFESORES.UDN.MX")||(mail.substring(comN)==="@profesores.udn.mx"))
               { 
                 document.getElementById("tipo").value=2;
                 document.forms[0].h_accion.value = "4";
                 return true;
               }
              else if((mail.substring(comN)==="@ALUMNOS.UDN.MX")||(mail.substring(comN)==="@ALUMNO.UDN.MX")||
                     (mail.substring(comN)==="@alumnos.udn.mx")||(mail.substring(comN)==="@alumno.udn.mx"))
                     {
                      document.getElementById("tipo").value = 1;
                      document.forms[0].h_accion.value = "4";
                      return true;
                     }
                       alert ("Este no es un correo academico");
                       return false;
               }
               else
               {
                  alert ("Las contraseñas deben ser iguales.");
                       return false;
               }
      }
      else {
        alert ("Llena todos los Campos.");
        return false;
      }
      }
    function fn_guarda_usuario_nuevo(){
      document.forms[0].h_accion.value = "4";
      document.forms[0].submit();
    }
</script>
</head>
<body>
<section id="login"> 
	<div class="container">
		<form class="form-signin" role="form" method="post">
			
			<input type="usuario" name="txt_usuario" class="form-control-user" id="txt_usuario" autocomplete="off" required placeholder="Usuario" autofocus>
			
			<input type="password" name="txt_password" class="form-control-user" id="txt_password" required placeholder="Contraseña">
			<a href="javascript:fn_revisa();" class="btn btn-lg btn-primary btn-block"> Iniciar Sesión</a>
            <br>
            <font color ="#FF0000"><?= $msg_error?></font>
		
        <a class="page-scroll" name="getusuario_Insert" id="getusuario_Insert" data-toggle="modal" data-target="#insertModal"><i class="fa fa-info-circle" id="myBtn">REGISTRARSE</i></a>
	</div>


</section>
    <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModal"><i class="fas fa-edit fa-fw"></i> Registrarse</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">
    
       <div id="modal-loader_insert" style="display: none; text-align: center;">
         <!-- ajax loader -->
         <img src="img/ajax-loader.gif">
           </div>                        
           <!-- mysql data will be load here -->                          
           <div class="box box-primary">
        <table border="0" cellpadding="5" cellspacing="0" width="100%">
            <input type="hidden" name="h_usuario_nuevo" value="1">
             <tr>
                <td>Nombre Completo</td>
                <td><input type="text" class="form-control form-control-user"  id="txt_nombre_nuevo" name="txt_nombre_nuevo" autocomplete="off" required value="" onfocus="nextfield='txt_nombre_nuevo';" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" required class="form-control form-control-user"  id="txt_email_nuevo" name="txt_email_nuevo" autocomplete="off" required value="" onfocus="nextfield='txt_email_nuevo';" /></td>
            </tr>
             <tr>
                <td>Password</td>
                <td><input type="password" class="form-control form-control-user" id="pwd" name="pwd" autocomplete="off" required value="" onfocus="nextfield='pwd';" /></td>
            </tr>
            <tr>
                <td>Confirmar Password</td>
                <td><input type="password" class="form-control form-control-user" id="pwd2" name="pwd2" autocomplete="off" required value="" onfocus="nextfield='pwd2';" /></td>
            </tr>
            </table>
        </div>
    
    
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <input type="hidden" name="tipo" id="tipo" >
          <a class="btn btn-primary" style="display: none;" onclick="return vlid()" type="submit"name="btn_usuario_guarda_insert" id="btn_usuario_guarda_insert" href="javascript:fn_guarda_usuario_nuevo();" >Unirse</a>
        </div>
      </div>
      </div>
    </div>
</div>
<!-- jQuery -->
    <script src="css/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="css/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" integrity="sha384-mE6eXfrb8jxl0rzJDBRanYqgBxtJ6Unn4/1F7q4xRRyIw7Vdg9jP4ycT7x1iVsgb" crossorigin="anonymous"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>
<script>
$(document).ready(function(){
  $(document).on('click', '#getusuario_activa_desactiva', function(e){
    e.preventDefault();
    var uid = $(this).data('id'); // get id of clicked row
    document.getElementById("h_idusuario").value = uid;
  });
  
  
  
  //inserta nueva usuario
  $(document).on('click', '#getusuario_Insert', function(e){
    e.preventDefault();
    $('#dynamic-content_insert').html(''); // leave this div blank
    $('#modal-loader_insert').show();      // load ajax loader on button click
    
    $.ajax({
      
    })
    .done(function(data){
      console.log(data); 
      $('#dynamic-content_insert').html(''); // blank before load.
      $('#dynamic-content_insert').html(data); // load here
      $('#modal-loader_insert').hide(); // hide loader  
      $('#btn_usuario_guarda_insert').show(); //muestra el boton de guardar
    })
    .fail(function(){
      $('#dynamic-content_insert').html('<i class="glyphicon glyphicon-info-sign"></i> Algo salió mal, favor de intentar de nuevo...');
      $('#modal-loader_insert').hide();
    });
  });
});
</script>
    <!-- Theme JavaScript -->
    <!--script src="js/2cto.min.js"></script-->
    </form>
</body>
</html>