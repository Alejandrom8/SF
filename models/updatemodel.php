<?php

class UpdateModel extends Model{

  public function __construct(){
    parent::__construct();
    $this->con = $this->db->connect();
  }

  public function Actualizar($archivo, $separador){

    try{
      $delete = "TRUNCATE TABLE actual8";
      $status = $this->con->prepare($delete);
      $status->execute();

      if($status){
        try{
          while(($data = fgetcsv($archivo, 3000, $separador)) !== FALSE){
            $sql = "INSERT INTO ". constant('TABLA_ACTUAL') ."(RFC, NOMBRE, CLAVEADS, TIPOMOV,CAUSA,CATEGO,TIPOPZA, TIPONOM, FECHAINI, FECHATERM,TIPOHOR,CLAVEASIG,GRUPO,HR1,SALON1,HR2,SALON2,HR3,SALON3,HR4,SALON4,HR5,SALON5,HRTEOR,HRPRAC,HRAPOY,HRTOT,MARCA,HRSNOM,FECHACT) VALUE(";
            for($i = 0; $i < 30; $i++){
              $sql .= "'$data[$i]'";
              if($i != 29){
                $sql .= ",";
              }
            }
            $sql .= ")";
            $ejecutar = $this->con->prepare($sql);
            $ejecutar->execute();
          }

          $delete_bad = "DELETE FROM ". constant('TABLA_ACTUAL') ." WHERE RFC = '?RFC' OR NOMBRE = 'NOMBRE'";
          $execute =$this->con->prepare($delete_bad);
          $execute->execute();
          
          return true;
        }catch(PDOException $d){
          return false;
        }
      }
    }catch(PDOException $e){
      return false;
    }
  }
}

?>
