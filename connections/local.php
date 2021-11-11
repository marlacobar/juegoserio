<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
#$hostname_local = "p3plcpnl0521.prod.phx3.secureserver.net";
$hostname_local = "localhost";
$database_local = "juegoserio";
$username_local = "rootserio";
$password_local = "Juegoserio123";

//$local = mysqli_connect($hostname_local, $username_local, $password_local);


 function Conectarse()
   {
     global $hostname_local, $username_local, $password_local, $database_local;
 
     if (!($link = mysqli_connect($hostname_local, $username_local, $password_local))) 
     { 
        echo "Error conectando a la base de datos.<br>"; 
       exit(); 
            }

     if (!mysqli_select_db($link, $database_local)) 
      { 
        echo "Error seleccionando la base de datos.<br>"; 
        exit(); 
      }

   return $link; 
    } 
  

    

?>