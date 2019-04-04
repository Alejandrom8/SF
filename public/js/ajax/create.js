$(document).ready(function(){
  $("#data").bind("submit", function(){

    var boton = $('#submit_btn');
    var display = $('#display');
    var error = $("#form-error");
    var boton_section = $("#other_options");

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
          var respuesta = JSON.parse(data.respuesta);
          if(data.tipo == 'hora'){
            display.empty();
            var abrir = "<table class='table table-striped'>" +
                          "<thead>" +
                            "<tr>" +
                              "<th>RFC</th>" +
                              "<th>Nombre</th>" +
                              "<th>Materia</th>" +
                              "<th>Grupo</th>" +
                              "<th>Salon</th>" +
                              "<th>CODIGOTEC</th>"+
                            "</tr>" +
                          "</thead>" +
                          "<tbody>";
                        for(var i = 0; i < respuesta.length; i++){
                          abrir +=
                            "<tr>"+
                              "<td>"+ respuesta[i].rfc + "</td>" +
                              "<td>"+ respuesta[i].name +"</td>" +
                              "<td>"+ respuesta[i].asig +"</td>" +
                              "<td>"+ respuesta[i].grupo +"</td>" +
                              "<td>"+ respuesta[i].salon +"</td>"+
                              "<td>"+ 1 + "</td>"
                            +"</tr>"
                          ;
                        }
                        abrir += "</tbody></table>";
            // window.open(data.URL, '_blank');
            display.append(abrir);
          }else if(data.tipo == 'dia'){
            display.empty();
            for(var o = 0; o < respuesta.length; o++){
              var abrir = "<table class='table table-striped'>" +
                              "<thead>"+
                                "<tr>" +
                                  "<th colspan='4'><h3>hora"+ (o+1) +"</h3></th>" +
                                "</tr>" +
                              "</thead>" +
                              "<thead>" +
                                "<tr>" +
                                  "<th>RFC</th>" +
                                  "<th>Hora</th>" +
                                  "<th>Nombre</th>" +
                                  "<th>Materia</th>" +
                                  "<th>Grupo</th>" +
                                  "<th>Salon</th>" +
                                  "<th>CODIGOTEC</th>"+
                                "</tr>" +
                              "</thead>" +
                              "<tbody>";
                            for(var i = 0; i < respuesta[o].length; i++){
                              abrir +=
                                "<tr>"+
                                  "<td>"+ respuesta[o][i].rfc + "</td>" +
                                  "<td>"+ respuesta[o][i].hora + "</td>" +
                                  "<td>"+ respuesta[o][i].name +"</td>" +
                                  "<td>"+ respuesta[o][i].asig +"</td>" +
                                  "<td>"+ respuesta[o][i].grupo +"</td>" +
                                  "<td>"+ respuesta[o][i].salon +"</td>"+
                                  "<td>"+ 1 + "</td>"
                              +"</tr>"
                              ;
                            }
              abrir += "</tbody></table>";
              // window.open(data.URL, '_blank');
              display.append(abrir);
            }
          }else{
            console.log(data.estado);
          }
          // getImageFromUrl(URL+"public/img/plantilla.jpg", pdf);
          pdf(data.tipo, respuesta, data.fecha, data.dia,data.H, data.hora);
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
var getImageFromUrl = function(url, callback) {
	var img = new Image, data, ret={data: null, pending: true};

	img.onError = function() {
		throw new Error('Cannot load image: "'+url+'"');
	}
	img.onload = function() {
		var canvas = document.createElement('canvas');
		document.body.appendChild(canvas);
		canvas.width = img.width;
		canvas.height = img.height;

		var ctx = canvas.getContext('2d');
		ctx.drawImage(img, 0, 0);
		// Grab the image as a jpeg encoded in base64, but only the data
		data = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
		// Convert the data to binary form
		data = atob(data)
		document.body.removeChild(canvas);

		ret['data'] = data;
		ret['pending'] = false;
		if (typeof callback === 'function') {
			callback(data);
		}
	}
	img.src = url;

	return ret;
}
// var pdf = function(imgData){
//   var fecha = "2019-04-03";
//   var hora = 2;
//   var dia = "MARTES";
function pdf(tipo,data,fecha,dia,veces,hora){
  var doc = new jsPDF();
  if(tipo == 'hora'){
    var grupos = Math.round(data.length/26);
    var sobrante = data.length % 26;
    if(sobrante > 1){
      grupos++;
    }
    for(var i = 1; i <= veces; i++){
      do{
        doc.setFontSize(10);
        doc.setFont("helvetica");
        doc.text(60,37,"8 Miguel E. Schulz");
        doc.text(137.7,42.5,dia);
        doc.text(57,46,fecha);
        doc.text(100,46,HORARIOS[(hora-1)]);
        doc.setFontSize(10);
        doc.setLineWidth(0.1);
        doc.line(6, 48, 204.5, 48);//linea horizontal 1
        doc.line(6, 52, 204.5, 52);//linea horizontal 2
        doc.line(6, 291, 204.5, 291);//linea horizontal 3
        doc.setFont("courier");
        doc.setFontSize(8);
        doc.text(46, 51, "Nombre");
        doc.text(100, 51, "Grupo");
        doc.text(115, 51, "Salon");
        doc.text(140, 51, "Materia");
        doc.text(180, 51, "Firma");
        doc.line(6, 48, 6, 291);//linea vertical 1
        doc.line(98, 48, 98, 291);//linea vertical 2
        doc.line(113, 48, 113, 291);//linea vertical 3
        doc.line(126, 48, 126, 291);//linea vertical 4
        doc.line(167, 48, 167, 291);//linea vertical 5
        doc.line(204.5, 48, 204.5, 291);//linea vertical 6
        doc.setFont("helvetica");
        doc.setFontSize(10);
          for(var u = 0; u < 26; u++){
            doc.line(6, 61 + (u * 9), 204.5, 61 + (u * 9));//linea horizontal 4
            doc.text(9,59 + (u * 9), data[u].name);
            doc.text(99,59 + (u * 9), data[u].grupo);
            doc.text(114,59 + (u * 9), data[u].salon);
            doc.text(130,59 + (u * 9), data[u].asig);
          }
        grupos--;
        if(i != hora){
          doc.addPage();
        }
      }while(grupos > 0);
    }
  }
  // doc.output('datauri');
  doc.save('Test.pdf');
}
