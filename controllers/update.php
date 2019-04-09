<?php

class Update extends Controller{
  function __construct(){
    parent::__construct();
  }
  function render(){
    $this->view->render("update/index");
  }

  function actualizar(){
    $archivo = $_FILES['archivo'];
    $separation = $_POST['separation'];

    $nombre_archivo = $archivo['name'];
    $size_archivo = $archivo['size'];
    $tipo_archivo = explode('.', $nombre_archivo);

    if(strtolower(end($tipo_archivo)) == 'csv'){
      $filename = $_FILES['archivo']['tmp_name'];
      $handle = fopen($filename, 'r');
      $insertar = $this->model->Actualizar($handle, $separation);
      if($insertar){
        echo "Se insertaron todos los datos correctamente";
      }else{
        echo "No se insertaron los datos correctamente";
      }
    }else{
      echo "El tipo de archivo es invalido";
    }
  }
}

?>
