<?php

class HomeModel extends Model{
  public function __construct(){
    parent::__construct();
  }
  public function listar($fecha, $hora){

  }
  public function grupos($grupo){
    $sql = "SELECT DISTINCT grupo FROM horarios WHERE ";
  }
}

?>
