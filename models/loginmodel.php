<?php

  class LoginModel extends Model{
    private $con;
    function __construct(){
      parent::__construct();
      $this->con = $this->db->connect();
    }
    public function verify($user, $password){
      $sql = "SELECT usuario FROM usuarios WHERE usuario = $user";
      $result = $this->con->prepare($sql);
      $result->execute();
      $verificado = false;
      while($result->fetch(PDO::FETCH_ASSOC)){
        $verificado = true;
        break;
      }
      if($verificado){
      }
    }
    private function select($data, $comp, $tab, $con1 = null, $con2 = null){
      if($con1 != null){
          $sql = "SELECT $data FROM $tab WHERE $data = $comp AND ";
      }
      $result = $this->con->prepare($sql);
      $result->execute();
      $verificado = false;
      while($result->fetch(PDO::FETCH_ASSOC)){
        $verificado = true;
        break;
      }
    }
  }

?>
