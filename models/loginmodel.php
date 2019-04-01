<?php

  class LoginModel extends Model{

    private $con;

    public function __construct(){
      parent::__construct();
      $this->con = $this->db->connect();
    }

    public function compare($data, $comp, $tab){
      try{
        $sql = "SELECT $data FROM $tab WHERE $data = '$comp'";
        $result = $this->con->prepare($sql);
        $result->execute();
        $verificado = false;

        while($result->fetch(PDO::FETCH_ASSOC)){
          $verificado = true;
          break;
        }

        return $verificado;
      }catch(PDOException $e){
        return false;
      }
    }

    public function comparePass($data,$pass ,$tab){
      $sql = "SELECT password FROM $tab WHERE name = '$data'";
      $result = $this->con->prepare($sql);
      $result->execute();
      while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $pass_r = $row['password'];
        break;
      }
      if(password_verify($pass, $pass_r)){
        return true;
      }else{
        return false;
      }
    }

  }

?>
