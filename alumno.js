
//Carga
function getDepartamentos(){
  var url = "alumno_sw.php";
  var data = { action:"departamentos" };
  
  fetch(url, {
    method: "POST", // or 'PUT'
    body: JSON.stringify(data), // data can be `string` or {object}!
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then(function(response){
      var select = document.getElementById("departamentos");
      var p = document.getElementById("msg");
      p.innerHTML=response.msg;
      for(var i = 0; i<response.data.length; i++){
        var opt = document.createElement('option');
        opt.value= response.data[i].CODIGO;
        opt.innerHTML = response.data[i].NOMBRE;
        select.appendChild(opt);
      }
    });
}

function getProfesores(){
  var url = "alumno_sw.php";
  var select= document.getElementById("departamentos");
  var data = { action:"profesores", departamento_id:select.value };
  
  fetch(url, {
    method: "POST", // or 'PUT'
    body: JSON.stringify(data), // data can be `string` or {object}!
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then(function(response){
      var select = document.getElementById("profesores");
      var p = document.getElementById("msg");
      while (select.firstChild) {
        select.removeChild(select.firstChild);
      }
      var opt = document.createElement('option');
      opt.innerHTML = "--selecionar";
      select.appendChild(opt);
      for(var i = 0; i<response.data.length; i++){
        var opt = document.createElement('option');
        opt.value= response.data[i].DNI;
        opt.innerHTML = response.data[i].NOMBRE +" "+ response.data[i].APELLIDO_1;
        select.appendChild(opt);
      }
    });
}