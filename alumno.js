var max;
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
      //Recoje los elementos que se van a modificar
      var select = document.getElementById("departamentos");
      var p = document.getElementById("msg");
      p.innerHTML=response.msg;
      //Muestra todos los departmanentos como opciones
      for(var i = 0; i<response.data.length; i++){
        var opt = document.createElement('option');
        opt.value= response.data[i].CODIGO;
        opt.innerHTML = response.data[i].NOMBRE;
        select.appendChild(opt);
      }
      getProfesores();
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
      //Recoje los elementos que se van a modificar
      var select = document.getElementById("profesores");
      var table = document.getElementById("tabla");
      var opt = document.createElement('option');
      //Borra el contenido anterior preparando para el nuevo
      while (select.firstChild) {
        select.removeChild(select.firstChild);
      }
      table.innerHTML= " ";
      opt.innerHTML = "--selecionar";
      select.appendChild(opt);
      //Crea etiquetas para mostrar los profesores
      for(var i = document.getElementById("pagina").value*5; i<(document.getElementById("pagina").value*5)+5; i++){ 
        try{
                  //Crea las variables de las etiquetas que va a crear
        var row = table.insertRow(0);
        var cel1= row.insertCell(0);
        var cel2= row.insertCell(1);
        var opt = document.createElement('option');
        //Añado un valor/HTML a las etiquetas
        opt.value= response.data[i].DNI;
        cel1.innerHTML= response.data[i].DNI;
        opt.innerHTML = response.data[i].NOMBRE +" "+ response.data[i].APELLIDO_1;
        cel2.innerHTML= response.data[i].NOMBRE +" "+ response.data[i].APELLIDO_1;
        select.appendChild(opt);

        }catch(error ){
          table.deleteRow(0)
          continue;
        }
       
      }
      max= Math.ceil(response.data.length/5)-1;
    });

}

  function maximo(){
    pagina.value = max;
    getProfesores();
  }
  function minimo(){
    var pagina= document.getElementById("pagina");
    var numero = 0;
    pagina.value = numero;
    getProfesores();

}
function menos(){
  var pagina= document.getElementById("pagina");
  var numero =0;
  if (pagina.value>0){
    numero = pagina.value-1;
  }
  pagina.value = numero;
  getProfesores();

}
function mas(){
  var pagina= document.getElementById("pagina");
  if(pagina.value!=null && pagina.value>=0){
    var numero = parseInt(pagina.value)+1;
  }else{
    var numero=0;
  }
  if(numero>max){
    pagina.value=max;
  }else{
    pagina.value = numero;
  }
  getProfesores();

}
function cambiarPagina(){
  var pagina= document.getElementById("pagina");
  var numero =pagina.value;
  if (numero<0){
    numero=0;
  }else if(numero>max){
    numero=max
  }
  pagina.value = numero;
  getProfesores();
}