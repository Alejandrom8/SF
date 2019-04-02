<?php
class Home extends Controller{
  function __construct(){
    parent::__construct();
    if(!isset($_SESSION['user']) || !isset($_SESSION['pass']) || $_SESSION['user'] == null || $_SESSION['pass'] == null || $_SESSION['user'] == '' || $_SESSION['pass'] == ''){
      print("<script>alert('Acceso denegado');window.location='". constant('URL') ."salir/saliendo'</script>");
    }
    $this->view->grupos;
  }
  function render(){
    $this->view->render('home/index');
  }

  function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function create(){
    $formato = test_input($_REQUEST['formato']);

    switch ($formato) {
      case 1://En caso de que sea listas de asistencia
        $fecha = test_input($_REQUEST['fecha']);
        $hora = test_input($_REQUEST['hora']);

        $dias = array("DOMINGO","LUNES","MARTES","MI&Eacute;RCOLES","JUEVES","VIERNES","S&Aacute;BADO");
        $dia = $dias[date('w',strtotime($fecha))];
        $iniciales = substr($dia,0, 2);

        for($i = 1; $i <= $hora; $i++){
          $this->model->listar();
        }
        break;

      default:

        break;
    }

  }
}

?>
