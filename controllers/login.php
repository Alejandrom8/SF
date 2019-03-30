<?php

class Login extends Controller{
  function __construct(){
    parent::__construct();
  }
  function render(){
    $this->view->render('login/index');
  }
  function login(){
    $user = $_REQUEST['user'];
    $usuario_verificado = $this->model->compare('user', $user, 'usuarios');
    if($usuario_verificado){
      $password_verificada = $this->model->comparePass($user, $pass, 'usuarios');
      if($password_verificada){
        session_regenerate_id();
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        echo true;
      }else{
        echo "Contraseña incorrecta";
      }
    }else{
      echo "Usuario incorrecto";
    }
  }
}

?>
