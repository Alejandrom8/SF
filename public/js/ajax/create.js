$(document).ready(function(){
  $("#data").bind("submit", function(){

    var boton = $('#submit_btn');
    var display = $('#display');
    var error = $("#form-error");

    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      dataType: 'JSON',
      beforeSend: function(){
        boton.val('Consultando...');
        boton.attr('disabled', 'disabled');
      },
      complete: function(){
        boton.val('Enviar Consulta');
        boton.removeAttr('disabled');
      },
      success: function(data){
        if(data.estado){
          if(data.tipo == 'hora'){
            var respuesta = JSON.parse(data.respuesta);
            display.empty();
            display.append("<table class='table table-striped'><thead><tr><th>Nombre</th><th>Grupo</th><th>Salon</th><th>Materia</th></tr></thead><tbody>");
            for(var i = 0; i < respuesta.length; i++){
              display.append(
                "<tr>"+
                  "<td>"+ respuesta[i].name +"</td>" +
                  "<td>"+ respuesta[i].grupo +"</td>" +
                  "<td>"+ respuesta[i].salon +"</td>" +
                  "<td>"+ respuesta[i].asig +"</td>"
                +"</tr>"
              );
            }
            display.append("</tbody></table>");
          }else if(data.tipo == 'dia'){
            display.empty();
            var horas = JSON.parse(data.respuesta);
            for(var o = 0; o < horas.length; o++){
              var abrir = "<table class='table table-striped'>" +
                              "<thead>"+
                                "<tr>" +
                                  "<th colspan='4'><h3>hora"+ (o+1) +"</h3></th>" +
                                "</tr>" +
                              "</thead>" +
                              "<thead>" +
                                "<tr>" +
                                  "<th>Nombre</th>" +
                                  "<th>Grupo</th>" +
                                  "<th>Salon</th>" +
                                  "<th>Materia</th>" +
                                "</tr>" +
                              "</thead>" +
                              "<tbody>";
                            for(var i = 0; i < horas[o].length; i++){
                              abrir +=
                                "<tr>"+
                                  "<td>"+ horas[o][i].name +"</td>" +
                                  "<td>"+ horas[o][i].grupo +"</td>" +
                                  "<td>"+ horas[o][i].salon +"</td>" +
                                  "<td>"+ horas[o][i].asig +"</td>"
                              +"</tr>"
                              ;
                            }
              abrir += "</tbody></table>";
              display.append(abrir);
            }
          }else{
            console.log(data.estado);
          }
        }else{
          console.log("no se logro completar");
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
  $("#option_" + value + " select,input:not(#hora)").attr("required", "true");
  if(value){
    $("#boton").css({'display':'block'});
  }
});
