<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once 'views/head.php'; ?>
  <title>Login</title>
  <style>
    #footer {
      background-color: #333;
      width: 100%;
      height: 5rem;
      color: white;
    }
    .contenedor{
      height:93.58vh;
    }
  </style>
</head>
<body>
  <div class="contenedor col-sm-12">
    <div class="display">
      <div class="window">
        <div class="margen">
            <div class="col-md-12";>
              <div class="col-sm-12">
                <div class="col-sm-12">
                  <center><img class="logo_p8" src="<?php echo constant('URL'); ?>public/img/LeopardosP8.png"></center>
                </div>
              </div>
              <div id="form-cont" class="col-sm-12" style="text-align: center;margin-top:5%;">
                <h1 >Sistema de Formatos</h1>
                <br><br>
                <form class="form" action="<?php echo constant('URL'); ?>login/login" method="post" id="login">
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                      </span>
                      <input type="text" name="user" class="form-control" placeholder="Nombre de usuario" required autofocus>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                          <i class="glyphicon glyphicon-password"></i>
                      </span>
                      <input type="password" name="password" class="form-control" placeholder="Contraseña" required >
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" id="boton_enviar" name="submit" value="Entrar" class="btn btn-primary">
                  </div>
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <section id="footer" class="col-sm-12">
    <div>
      <div>
        <footer>
          <div>
            <p>hola como estas</p>
          </div>
        </footer>
      </div>
    </div>
  </section>
  <script src="<?php echo constant('URL'); ?>public/js/ajax/login.js"></script>
</body>
</html>
