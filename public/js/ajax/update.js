$(document).ready(function(){
  let boton = $("#submit");
  $("#actualizar").on('submit', function(e){
    e.preventDefault();
    var form_data = new FormData(document.getElementById("actualizar"));
    $.ajax({
      type:$(this).attr("method"),
      url:$(this).attr("action"),
      data:form_data,
      dataType: "html",
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function(){
        boton.html("actualizando... <img src='public/img/loading.gif' height='50px' width='50px'>");
        boton.attr("disabled","disabled");
      },
      complete: function(){
        boton.html("Actualizar <span class='glyphicon glyphicon-upload'></span>");
        boton.removeAttr("disabled");
      },
      success: function(data){
        window.alert(data);
      },
      error: function(){
        window.alert("Error");
      }
    });
    return false;
  });
});
