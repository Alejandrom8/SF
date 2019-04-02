$(document).ready(function(){
  $("#data").bind("submit", function(){

    var boton = $('#submit_btn');
    var display = $('#display');
    var error = $("#form-error");

    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      beforeSend: function(){
        boton.val('Consultando...');
        boton.attr('disabled', 'disabled');
      },
      complete: function(){
        boton.val('Enviar Consulta');
        boton.removeAttr('disabled');
      },
      success: function(data){
        if(data){
          display.append("<p>" + data + "</p>");
        }else{
          error.html = data;
        }
      },
      error: function(){
        alert('Hubo un error al realizar la consulta');
      }
    });
    return false;
  });
});

$(document).on("change", "#formato", function(){
  var value = $(this).val();
  $(".options select,input").removeAttr('required');
  $(".options:not(#option_" + value + ")").css({'display':'none'});
  $("#option_" + value).css({'display':'block'});
  $("#option_" + value + " select,input").attr("required", "true");
  if(value){
    $("#boton").css({'display':'block'});
  }
});