<?php
class Home extends Controller{
  function __construct(){
    parent::__construct();
    if(!isset($_SESSION['user']) || !isset($_SESSION['pass']) || $_SESSION['user'] == null || $_SESSION['pass'] == null || $_SESSION['user'] == '' || $_SESSION['pass'] == ''){
      print("<script>alert('Acceso denegado');window.location='". constant('URL') ."salir/saliendo'</script>");
    }
  }
  function render(){
    $this->view->render('home/index');
  }
}

?>
