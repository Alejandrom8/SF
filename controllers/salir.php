<?php
class Salir extends Controller{
  function __construct(){
    parent::__construct();
  }
  function saliendo(){
    echo "Espere un momento porfavor...";
    foreach($_SESSION as $key => $value){
      $_SESSION[$key] = NULL;
    }
    session_destroy();
    print("<script>window.location = '" . constant('URL') . "';</script>'");
  }
}

?>
