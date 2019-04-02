<?php
class Home extends Controller{

  function __construct(){
    parent::__construct();
    /* la funcion constructora de home solo servira para llamar a
    * los datos que devolvera este programa, para habilitar seguridad
    * o dar caracteristicas especiales
    */
    //Evaluamos que el usuario tenga una sesion iniciada antes de entrar
    if(!isset($_SESSION['user']) || !isset($_SESSION['pass']) || $_SESSION['user'] == null || $_SESSION['pass'] == null || $_SESSION['user'] == '' || $_SESSION['pass'] == ''){
      print("<script>alert('Acceso denegado');window.location='". constant('URL') ."salir/saliendo'</script>");
    }
    $this->view->mensaje = "";
    $this->view->grupos = [];
    $this->view->horarios = [ 1 => '7:00 - 7:50', '7:50 - 8:40', '8:40 - 9:30', '9:30 - 10:20', '10:20 - 11:10', '11:10 - 12:00', '12:00 - 12:50', '12:50 - 01:40', '01:40 - 02:30','02:30 - 03:20', '03:20 - 04:10', '04:10 - 05:00', '05:00 - 05:50', '05:50 - 06:40', '06:40 - 07:30', '07:30 - 08:20', '08:20 - 09:10'];
  }

  function render(){
    /* Funcion para mostrar en pantalla todo lo que
    * sea necesario devolver del servidor al ciliente
    */
    $this->view->render('home/index');
  }

  function test_input($data){
    /*  funcion para evaluar cada dato que entre al servidor
    *  y quitar caracteres especiales para más seguridad
    * @access public
    * @param String,int,boolean,etc. $data dato al que se le quitaran caractres especiales
    * @return $data dato sin caracteres especiales.
    */
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function create(){
    /* Funcion que se encargara de controlar todos los datos que se
    * soliciten del ciliente al servidor, con esta funcion se
    * construiran los arrays que se imprimiran en pantalla en formato pdf
    */

    //formato solicitado 1 = lista de asistencia; 2 = horario
    $formato = $this->test_input($_POST['formato']);

    switch ($formato) {
      case 1://En caso de que sea listas de asistencia
        $loop = $this->test_input($_POST['hora_dia']);
        $fecha = $this->test_input($_POST['fecha']);
        $hora = $this->test_input($_POST['hora']);
        $loop . " " . $fecha . " " . $hora;
        //se toma las iniciales de el dia de la semana solicitado para compararlo con la base de datos
        // $dias = array("LUNES","MARTES","MI&Eacute;RCOLES","JUEVES","VIERNES");
        // $dia = $dias[date('w',strtotime($fecha))];
        // $iniciales = substr($dia,0, 2);

        break;

      default:

        break;
    }

  }
}

?>
