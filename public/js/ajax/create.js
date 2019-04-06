$(document).ready(function(){
  $("#data").bind("submit", function(){

    var boton = $('#submit_btn');
    var display = $('#display');
    var error = $("#form-error");
    var boton_section = $("#boton .another");

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
            var abrir = "<table class='table table-striped'  id='listaTabla'>" +
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
                        for(var i = 0; i < respuesta.length; i++){
                          abrir +=
                            "<tr>"+
                              "<td>"+ respuesta[i].rfc + "</td>" +
                              "<td>"+ respuesta[i].hora + "</td>" +
                              "<td>"+ respuesta[i].name +"</td>" +
                              "<td>"+ respuesta[i].asig +"</td>" +
                              "<td>"+ respuesta[i].grupo +"</td>" +
                              "<td>"+ respuesta[i].salon +"</td>"+
                              "<td>"+ 1 + "</td>"
                            +"</tr>"
                          ;
                        }
                        abrir += "</tbody></table>";
            display.append(abrir);
          }else if(data.tipo == 'dia'){
            display.empty();
            var abrir = "<table class='table table-striped' id='listaTabla'>" +
                                "<thead>" +
                                    "<tr>"+
                                      "<th colspan='7'><h1>Listas de asistencia  "+ data.fecha +"</h1></th>" +
                                    "</tr>" +
                                    "<tr>" +
                                      "<th>RFC</th>" +
                                      "<th>Hora</th>" +
                                      "<th>Nombre</th>" +
                                      "<th>Materia</th>" +
                                      "<th>Grupo</th>" +
                                      "<th>Salon</th>" +
                                      "<th>CODIGOTEC</th>"+
                                    "</tr>" +
                                  "</thead>";
            for(var o = 0; o < respuesta.length; o++){
                  abrir +=   "<thead>"+
                                "<tr>" +
                                  "<th colspan='7'><h3>hora ~ "+ (o+1) +" (" + HORARIOS[o] +")</h3></th>" +
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
                    abrir += "</tbody>";
            }
            abrir += "</table>";
            display.append(abrir);
          }else{
            console.log(data.estado);
          }
          boton_section.empty();
          boton_section.append("<a class='btn btn-success' onclick=\"exportTableToCSV('"+ data.dia + data.fecha + ".csv')\">Exportar tabla </a>");
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

function pdf(tipo,data,fecha,dia,veces,hora){
  var doc = new jsPDF();
  if(tipo == 'hora'){
    var grupos = Math.round(data.length/26);
    var sobrante = data.length % 26;
    if(sobrante > 1){grupos++;}
    // for(var o = 1; o <= veces; o++){//
      var u = 1;
      var i = 1;

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

        var position = 0;

          // for(u; u <= (i*26); u++){
          while(u <= (i*26) && data[u-1]){
            doc.line(6, 61 + (position * 9), 204.5, 61 + (position * 9));//linea horizontal 4
            doc.text(9,59 + (position * 9), data[u-1].name);
            doc.text(99,59 + (position * 9), data[u-1].grupo);
            doc.text(114,59 + (position * 9), data[u-1].salon);
            doc.text(130,59 + (position * 9), data[u-1].asig);
            position++;
            u++;
          }
          
        if(i <= grupos){doc.addPage();}
        grupos--;
        i++;
      }while(grupos > 0);
    // }
  }
  // doc.output('datauri');
  doc.save('Test.pdf');
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;
    csvFile = new Blob([csv], {type: "text/csv"});
    // Download link
    downloadLink = document.createElement("a");
    // File name
    downloadLink.download = filename;
    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);
    // Hide download link
    downloadLink.style.display = "none";
    // Add the link to DOM
    document.body.appendChild(downloadLink);
    // Click download link
    downloadLink.click();
}
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#listaTabla tr");
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);
        csv.push(row.join(","));
    }
    downloadCSV(csv.join("\n"), filename);
}
