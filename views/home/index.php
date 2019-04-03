<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once 'views/head.php'; ?>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/css/home.css">
</head>
<body>
  <?php include_once 'views/header.php'; ?>
  <br><br>
  <div class="contenedor col-sm-12">
    <div class="margen">
      <section class=" block col-sm-4" id="menu_form">
        <div class="col-sm-12">
          <h1>Generar Formatos</h1>
          <br>
        </div>
        <div class="menu_form_data col-sm-12">
          <form name="data" method="POST" id="data" action="<?php echo constant('URL'); ?>home/create">
              <div class="row">
                <div class="nivel">
                  <div class="form-group">
                    <label for="formato">Formato</label>
                    <select name="formato" class="form-control" id="formato">
                      <option value="">Seleccione un formato</option>
                      <option value="1">Lista de asistencia</option>
                      <optgroup label="horarios">
                        <option value="2">Grupo</option>
                        <option value="3">Profesor</option>
                        <option value="4">Salon</option>
                      </optgroup>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tipo_horas">Tipo de servicio</label>
                    <select name="tipo_horas" class="form-control" id="tipo_horas">
                      <option value="0">Horas de apoyo</option>
                      <option value="1">Frente a grupo</option>
                    </select>
                  </div>
                </div>
                <br>
                <div id="config">
                  <div class="options" id="option_1">
                    <div class="form-group row">
                      <label for="hora_dia">¿Desea generar listas por hora o por dia?</label>
                      <div class="form-check">
                        <label class="form-ckeck-label">
                          <input type="radio" name="hora_dia" value="1" class="form-check-input">Hora
                        </label>
                        <span>(Se generará una sola lista)</span>
                      </div>
                      <div class="form-check">
                        <label class="form-ckeck-label">
                          <input type="radio" name="hora_dia" value="17" class="form-check-input">Dia
                        </label>
                        <span>(Se generarán 13 listas)</span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label for="fecha">Dia</label>
                          <select name="fecha" id="fecha" class="form-control">
                            <option value="LU">Lunes</option>
                            <option value="MA">Martes</option>
                            <option value="MI">Miercoles</option>
                            <option value="JU">Jueves</option>
                            <option value="VI">Viernes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label for="hora">Hora</label>
                          <select name="hora" id="hora" class="form-control">
                            <option value="">Seleccione una hora</option>
                            <option value="todas">Todas las horas</option>
                            <?php
                              for($i = 1; $i <= sizeof($this->horarios); $i++){
                                if($i < 10){
                                  echo "<option value='0$i'>hora $i (" . $this->horarios[$i] . ")</option>";
                                }else{
                                  echo "<option value='$i'>hora $i (" . $this->horarios[$i] . ")</option>";
                                }
                              }
                             ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="options" id="option_2">
                    <div class="form-group">
                      <label for="dia">Dia de la semana</label>
                      <select name="dia" id="dia" class="form-control">
                        <option value="">Selecciona un dia</option>
                        <script>
                          var dias = ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES'];
                          for(var i = 0; i < dias.length; i++){
                            document.write("<option value='" + (i+1) + "'>" + dias[i] + "</option>");
                          }
                        </script>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="Grado">Grado</label>
                      <select name="Grado" id="Grado" class="form-control">
                        <option for="4">4°</option>
                        <option for="5">5°</option>
                        <option for="6">6°</option>
                      </select>
                    </div>
                  </div>
                  <div class="options" id="boton">
                    <div class="form-group">
                      <input type="submit" name="submit" id="submit_btn" class="btn btn-primary">
                    </div>
                  </div>
                </div>
              </div>
          </form>
        </div>
        <div id="form-error">
        </div>
      </section>
      <section class="block col-sm-8" id="display">
      </section>
    </div>
  </div>
  <?php include_once 'views/footer.php'; ?>
  <script src="<?php echo constant('URL'); ?>public/js/ajax/create.js"></script>
</body>
</html>
