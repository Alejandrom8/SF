<?php
class Respuesta{
  public $estado;
  public $tipo;
  public $respuesta;
  public $fecha;
  public $dia;
  public $H;
  public $hora;
}

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

  function clasifHora($data){
    /*Funcion que clasifica los datos introducidos por hora
    * @access public
    * @param Array $data los datos que serán ordenados
    * @return Array $por_hora array con los datos ordenados por hora
    */

    $por_hora = array();// Array resultante

    for($i = 1; $i <= 17; $i++){//loop de clasificacion por hora, se repite 17 veces que son el numero de horas que esta activo el plantel 7am-9pm
      ${'hora_' . $i} = array();
      $aux = $i <10 ? "0".$i : $i;
      foreach($data as $key => $value){
        if($value['hora'] == $aux){
          $clase = ["rfc" => $value['rfc'],"hora" => $value['hora'],"name" => $value['name'], "grupo" => $value['grupo'], "salon" => $value['salon'],"asig" => $value['asig'], "clave" => $value['clave']];
          array_push(${'hora_' . $i}, $clase);
        }
      }
      array_push($por_hora, ${'hora_' . $i});
    }
    return [true, json_encode($por_hora)];
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
        //se toman todos los valores que vengan del formulario con id="data" y
        //se pasan por el metodo test_input para quitar caracteres especiales o extraños

        $loop = $this->test_input($_POST['hora_dia']);
        $fecha = $this->test_input($_POST['fecha']);
        $hora = $this->test_input($_POST['hora']);
        $tipo = $this->test_input($_POST['tipo_horas']);

        //  obtenemos las primeras 2 iniciales del dia de la semana (ejemplo: LU->LUNES)
        //  de acuerdo a la variable fecha con formato aaaa-mm-dd
        $dias = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
        $num_dia = date('w', strtotime($fecha));
        $dia = $dias[$num_dia];
        $iniciales = substr($dia,0,2);

        //se llama al metodo 'Listar' de la clase HomeModel para encontrar
        //todos los datos que concuerden con la busqueda del usuario
        $lista = $this->model->listar($loop, $iniciales, $hora, $tipo);
        $estado = $lista[0];
        $resultado = $lista[1];
        //se crea un objeto respuesta para almacenar dentro los resultados del proceso de $listar
        $respuesta = new Respuesta();

        if($estado){
          if($loop > 1){//Condicion que evalua si hablamos de listado por dia o por hora, en este caso será por dia.
             $clasificar_por_hora = $this->clasifHora($resultado);
             if($clasificar_por_hora[0]){
               $respuesta->estado = $clasificar_por_hora[0];
               $respuesta->tipo = 'dia';
               $respuesta->respuesta = $clasificar_por_hora[1];
               $respuesta->fecha = $fecha;
               $respuesta->dia = $dia;
               $respuesta->H = $loop;
               $respuesta->hora = (int)$hora;
             }else{
               $respuesta->estasdo = false;
             }
           }else{
             //listado por hora
              $respuesta->estado = true;
              $respuesta->tipo = "hora";
              $respuesta->respuesta = json_encode($resultado);
              $respuesta->fecha = $fecha;
              $respuesta->dia = $dia;
              $respuesta->H = $loop;
              $respuesta->hora = (int)$hora;
           }
        }else{
          $respuesta->estado = false;
        }
        echo json_encode($respuesta);
        break;

      default:

        break;
    }

  }
}

?>
