<?php

class HomeModel extends Model{
  public function __construct(){
    parent::__construct();
    $this->con = $this->db->connect();
  }
  public function listar($no_de_listas, $dia, $hora, $tipo){
    try{
      $sql = "SELECT RFC,NOMBRE,CLAVEASIG,GRUPO,HR1,SALON1,HR2,SALON2,HR3,SALON3,HR4,SALON4,HR5,SALON5 FROM " . constant('TABLA_ACTUAL') ." WHERE NOMBRE <> 'S/P' AND RFC <> '' ";
      $sql_generate = $this->con->prepare($sql);
      $sql_generate->execute();
      $profesores_listados = array();

      if($no_de_listas > 1){
        //si se generaran listas por dia
        while($value = $sql_generate->fetch(PDO::FETCH_ASSOC)){

          $hora_1 = substr($value['HR1'],2,2);
          $hora_2 = substr($value['HR2'],2,2);
          $hora_3 = substr($value['HR3'],2,2);
          $hora_4 = substr($value['HR4'],2,2);
          $hora_5 = substr($value['HR5'],2,2);

          $dia_1 = substr($value['HR1'],0,2);
          $dia_2 = substr($value['HR2'],0,2);
          $dia_3 = substr($value['HR3'],0,2);
          $dia_4 = substr($value['HR4'],0,2);
          $dia_5 = substr($value['HR5'],0,2);

          if($tipo == 0){
            $asignatura = "APOYO";
            //si se elije separar por horas de apoyo
              if($value['CLAVEASIG'] == 2222 or $value['CLAVEASIG'] == 2223){
                switch ($dia) {
                  case $dia_1:
                    array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_1,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON1'],"asig" => $asignatura]);
                    break;
                  case $dia_2:
                    array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_2,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON2'],"asig" => $asignatura]);
                    break;
                  case $dia_3:
                    array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_3,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON3'],"asig" => $asignatura]);
                    break;
                  case $dia_4:
                    array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_4,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON4'],"asig" => $asignatura]);
                    break;
                  case $dia_5:
                    array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_5,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON5'],"asig" => $asignatura]);
                    break;
                  default:
                    break;
                }
              }
          }else{
            $asig = "SELECT nombre FROM asignaturas WHERE idasignatura = " . $value['CLAVEASIG'] . " LIMIT 1";
            $asig_get = $this->con->prepare($asig);
            $asig_get->execute();
            while($row2 = $asig_get->fetch(PDO::FETCH_ASSOC)){
              $asignatura = $row2['nombre'];
            }
            if($value['CLAVEASIG'] != 2222 and $value['CLAVEASIG'] != 2223){
              switch ($dia) {
                case $dia_1:
                  array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_1,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON1'],"asig" => $asignatura]);
                  break;
                case $dia_2:
                  array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_2,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON2'],"asig" => $asignatura]);
                  break;
                case $dia_3:
                  array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_3,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON3'],"asig" => $asignatura]);
                  break;
                case $dia_4:
                  array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_4,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON4'],"asig" => $asignatura]);
                  break;
                case $dia_5:
                  array_push($profesores_listados, ["rfc" => $value['RFC'] ,"hora" => $hora_5,"name" => $value['NOMBRE'],"grupo" => $value['GRUPO'],"salon" => $value['SALON5'],"asig" => $asignatura]);
                  break;
                default:
                  break;
              }
            }
          }
        }
      }else{
        //si se generará listas por hora
        if($tipo == 0){
          $horario = $dia . $hora;//ejemplo: LU01
          while($row = $sql_generate->fetch(PDO::FETCH_ASSOC)){
            $hora_1 = substr($row['HR1'],2,2);
            $hora_2 = substr($row['HR2'],2,2);
            $hora_3 = substr($row['HR3'],2,2);
            $hora_4 = substr($row['HR4'],2,2);
            $hora_5 = substr($row['HR5'],2,2);
            $asignatura = "APOYO";
            if($row['CLAVEASIG'] == 2222 or $row['CLAVEASIG'] == 2223){
              switch ($horario) {
                case $row['HR1']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_1,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON1'],"asig" => $asignatura]);
                  break;
                case $row['HR2']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_2,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON2'],"asig" => $asignatura]);
                  break;
                case $row['HR3']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_3,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON3'],"asig" => $asignatura]);
                  break;
                case $row['HR4']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_4,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON4'],"asig" => $asignatura]);
                  break;
                case $row['HR5']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_5,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON5'],"asig" => $asignatura]);
                  break;
                default:
                  break;
              }
            }
          }
        }else{
          $horario = $dia . $hora;//ejemplo: LU01
          while($row = $sql_generate->fetch(PDO::FETCH_ASSOC)){

            $hora_1 = substr($row['HR1'],2,2);
            $hora_2 = substr($row['HR2'],2,2);
            $hora_3 = substr($row['HR3'],2,2);
            $hora_4 = substr($row['HR4'],2,2);
            $hora_5 = substr($row['HR5'],2,2);

              $asig = "SELECT nombre FROM asignaturas WHERE idasignatura = " . $row['CLAVEASIG'] . " LIMIT 1";
              $asig_get = $this->con->prepare($asig);
              $asig_get->execute();
              while($row2 = $asig_get->fetch(PDO::FETCH_ASSOC)){
                $asignatura = $row2['nombre'];
              }

            if($row['CLAVEASIG'] != 2222 and $row['CLAVEASIG'] != 2223){
              switch ($horario) {
                case $row['HR1']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_1,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON1'],"asig" => $asignatura]);
                  break;
                case $row['HR2']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_2,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON2'],"asig" => $asignatura]);
                  break;
                case $row['HR3']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_3,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON3'],"asig" => $asignatura]);
                  break;
                case $row['HR4']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_4,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON4'],"asig" => $asignatura]);
                  break;
                case $row['HR5']:
                  array_push($profesores_listados, ["rfc" => $row['RFC'] ,"hora" => $hora_5,"name" => $row['NOMBRE'],"grupo" => $row['GRUPO'],"salon" => $row['SALON5'],"asig" => $asignatura]);
                  break;
                default:
                  break;
              }
            }
          }
        }
      }

      $resultado = $profesores_listados ? [true,$profesores_listados] : [false, "No hay resultados"];
      return $resultado;

    }catch(PDOExeption $e){
        return [false,"ERROR: " . $e->getMessage()];
    }
  }

}

?>
