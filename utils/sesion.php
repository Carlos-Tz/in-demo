<?php
  session_start();
  if(!isset($_SESSION["user"])){
    header("location:https://demo.inomac.mx/ingresar/login.php");
  }
 ?>