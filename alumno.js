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
    });
    getProfesores()
}

function getProfesores(){
  var url = "alumno_sw.php";
  var buscador = document.getElementById("nombre");

  var data = { action:"profesores", nombre:buscador.value};
  
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
      var table = document.getElementById("tabla");
      var opt = document.createElement('option');
      //Borra el contenido anterior preparando para el nuevo

      table.innerHTML= " ";
      opt.innerHTML = "--selecionar";
      
      //Crea etiquetas para mostrar los profesores
      for(var i = document.getElementById("pagina").value*5; i<(document.getElementById("pagina").value*5)+5; i++){ 
        try{
                  //Crea las variables de las etiquetas que va a crear
        var row = table.insertRow(0);
        var cel1= row.insertCell(0);
        var cel2= row.insertCell(1);
        var cel3= row.insertCell(2);
        var cel4= row.insertCell(3);
        var opt = document.createElement('option');
        //Añado un valor/HTML a las etiquetas

        opt.value= response.data[i].DNI;
        cel1.innerHTML= response.data[i].DNI;
        opt.innerHTML = response.data[i].NOMBRE +" "+ response.data[i].APELLIDO_1;
        cel2.innerHTML= response.data[i].NOMBRE +" "+ response.data[i].APELLIDO_1;
        cel3.innerHTML= '<input type="button" value="eliminar" onclick="eliminar(\''+response.data[i].DNI.toString()+'\')">';
        cel4.innerHTML= '<input type="button" value="editar" onclick="irFormularioEditar(\''+response.data[i].DNI.toString()+'\')">';
        

        }catch(error ){
          table.deleteRow(0)
          continue;
        }
       
      }
      max= Math.ceil(response.data.length/5)-1;
    });

}

  function maximo(){
    var url = "alumno_sw.php";
    var select= document.getElementById("departamentos");
    var data = { action:"profesores" };
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
function eliminar($DNI){
  var url = "alumno_sw.php";
  var data = { action:"eliminar", dni:$DNI };
  
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
      var error=document.getElementById("error")
      if(response.msg!=null){
        error.textContent= response.msg;
      }
    });
    getProfesores();
    

}
function insertar(){
  var url = "alumno_sw.php";

  $formulario=Array.from(document.getElementById("form").elements);
  for (var i = 0; i < $formulario.length; i++) {
      $formulario[i]= $formulario[i].value;
  }
  console.log($formulario);
  var data = { action:"insertar", datos:$formulario };
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
      var error=document.getElementById("error")
      if(response.msg!=null){
          error.textContent= response.msg;     
      }
      if(response.succes== true){
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        window.location.href="alumno.html?token=" + encodeURIComponent(token);
    }
    });
}
function actualizar(){
  var url = "alumno_sw.php";

  $formulario=Array.from(document.getElementById("form").elements);
  for (var i = 0; i < $formulario.length; i++) {
      $formulario[i]= $formulario[i].value;
  }
  console.log($formulario);
  var data = { action:"actualizar", datos:$formulario };
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
      var error=document.getElementById("error")
      if(response.msg!=null){
          error.textContent= response.msg;     
      }
      if(response.succes== true){
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        window.location.href="alumno.html?token=" + encodeURIComponent(token);
    }
    });
}
function cargarUpdate(){
  confirmarToken();
  var parametros = new URLSearchParams(window.location.search);
  var boton = document.getElementById("boton");
  if(parametros.get('dni')!=null){
    var elemento = document.getElementById("dni");
    $DNI=parametros.get('dni');
    elemento.value= $DNI;
    elemento.readOnly = "true";
    var url = "alumno_sw.php";
    var data = { action:"profesor", dni:$DNI };
    
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
        var nombre=document.getElementById("nombre")
        var apellido1=document.getElementById("apellido1")
        var apellido2=document.getElementById("apellido2")
        var direccion=document.getElementById("direccion")
        var localidad=document.getElementById("localidad")
        var provincia=document.getElementById("provincia")
        var fechaIngreso=document.getElementById("fechaIngreso")
        var idCategoria=document.getElementById("idCategoria")
        var idDepartamento=document.getElementById("idDepartamento")
        nombre.value= response.data[0].NOMBRE;
        apellido1.value= response.data[0].APELLIDO_1;
        apellido2.value= response.data[0].APELLIDO_2;
        direccion.value= response.data[0].DIRECCION;
        localidad.value= response.data[0].LOCALIDAD;
        provincia.value= response.data[0].PROVINCIA;
        fechaIngreso.value= response.data[0].FECHA_INGRESO;
        idCategoria.value= response.data[0].ID_CATEGORIA;
        idDepartamento.value= response.data[0].ID_DEPARTAMENTO;
        boton.onclick = actualizar;
      });
  }else{
    boton.onclick = insertar;
  }
}
function irFormularioEditar($valor){
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');
  if($valor!= null){

    window.location.href = 'formulario.html?dni=' + encodeURIComponent($valor) + '&token=' + encodeURIComponent(token);
  }else{
    window.location.href = 'formulario.html?token=' + token;
  }
  
}
function login(){
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  // Verificación simple
  if (username === 'iker' && password === '1234') {
      // Autenticación exitosa, redirigir a otra página
      var url = "alumno_sw.php";
      var data = { action:"login"};
      
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
          const token = true;  // Puedes generar un token más seguro en un entorno real
          window.location.href = 'alumno.html?token=' + response.data;
        });

  } else {
      alert('Error de autenticación. Por favor, verifica tus credenciales.');
  }
  
}
function confirmarToken(){
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');

  // Verificar la presencia del token
  if (token) {
      // Token válido, puedes realizar acciones adicionales aquí
      console.log('Token válido:', token);
  } else {
      // Token no presente, redirigir a la página de inicio de sesión
      alert('Acceso no autorizado. Debes iniciar sesión.');
      window.location.href = 'index.html';
  }
}

function cargarTabla(){
  confirmarToken();
  getProfesores();
}

function cancelar(){
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');
  window.location.href="alumno.html?token=" + encodeURIComponent(token);
}
function logout(){
  window.location.href="index.html";
}