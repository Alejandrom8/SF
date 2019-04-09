<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include_once "views/head.php"; ?>
    <title>Actualizar base de datos</title>
    <style>
      .margen{
        display:flex;
        align-items: center;
      }
      .form{
        margin:0 auto;
      }
      .form input[type="file"]{
        height:15%;
      }
      body{
        background-image:url('public/img/escudoenp.jpg');
        background-size:cover;
        background-attachment: fixed;
        color:#fff;
      }
      body h1{
        color:#fff;
      }
      .form{
        background-color:rgba(119,119,119,0.8);
        margin-top:-5%;
        padding:5%;
        padding-left:4%;
        padding-right:4%;
        border-radius:15px;
      }
      #submit{
        width:50%;
        height:50px;
        font-weight: bold;
      }
      #separation{
        padding:4%;
        height:15%;
        text-align: center;
        font-size:40px;
        font-weight:bold;
      }
    </style>
  </head>
  <body>
    <?php include_once "views/header.php"; ?>
    </br></br>
    <div class="contenedor col-sm-12">
      <div class="margen">
        <div class="form">
          <h1>Actualizar Base de datos</h1>
          <br><br>
          <form name="actualizar" id="actualizar" action="<?php echo constant('URL'); ?>update/actualizar" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="archivo">Archivo: </label>
              <input type="file" name="archivo" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="separacion">Columnas delimitadas por</label>
              <select name="separation" id="separation" class="form-control" required>
                <option value=",">,</option>
                <option value=";">;</option>
                <option value=":">:</option>
              </select>
            </div>
            <center>
              <button type="submit" name="enviar" id="submit" class="submit btn btn-info">
                Actualizar
                <span class="glyphicon glyphicon-upload"></span>
              </button>
            </center>
          </form>
        </div>
      </div>
    </div>
    <?php include_once "views/footer.php"; ?>
  </body>
  <script src="<?php echo constant('URL'); ?>public/js/ajax/update.js"></script>
</html>
