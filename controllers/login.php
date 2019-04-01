<?php

class Login extends Controller{

  function __construct(){
    parent::__construct();
    $this->view->mensaje = "";
  }

  function render(){
    $this->view->render('login/index');
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function login(){
    $user = $this->test_input($_POST['user']);
    $pass = $this->test_input($_POST['pass']);

    $usuario_verificado = $this->model->compare('name', $user, 'usuarios_form');

    if($usuario_verificado){
      $password_verificada = $this->model->comparePass($user, $pass, 'usuarios_form');
      if($password_verificada){
        session_regenerate_id();
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        header('Location: ' . constant('URL') . 'home');
      }else{
        $this->view->mensaje = "<div class='alert alert-danger'>Contraseña incorrecta</div>";
        $this->render();
      }
    }else{
      $this->view->mensaje = "<div class='alert alert-danger'>Usuario incorrecto</div>";
      $this->render();
    }

  }
}

?>
