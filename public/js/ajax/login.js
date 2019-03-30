$(document).ready(function(){
  $("#login").bind("submit", function(){
    var boton_enviar = $("boton_enviar");
    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      beforeSend: function(){
        boton_enviar.val('Enviando...');
        boton_enviar.attr('disabled', 'disabled');
      },
      complete: function(){
        boton_enviar.val('Entrar');
        boton_enviar.removeAttr('disabled', 'disabled');
      },
      success: function(resultado){
        if(resultado){
          window.location = 'http://localhost/proyectos/Sistema_formatos/home';
        }
      },
      error: function(){
        console.log('error');
      }
    });
    return false;
  });
});
