<?php
$data = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json; charset=utf-8');
$name = !empty($_POST["action"])? $_POST["action"] : null;
$action= $data['action'];
$departameno_id=isset($data["departamento_id"])? $data["departamento_id"]:null;
require_once("Departamento.php");
require_once("Profesor.php");
require_once("Conexion.php");

$arrValues=[];
$msg =  "";
$success = true;

try{
    if($action == "departamentos"){
        $data = Departamento::getAllDepartamentos();
    }elseif($action == "eliminar"){
        $dni = isset($data["dni"])? $data["dni"]:null;
        $data = Profesor::deleteProfesores($dni);
    }elseif($action == "profesor"){
        $dni = isset($data["dni"])? $data["dni"]:null;
        $data = Profesor::getProfesoresDNI($dni);
    }elseif($action == "login"){
        $hash = password_hash(uniqid(), PASSWORD_DEFAULT);
        $fechaCaducidad = date('Y-m-d H:i:s', strtotime('+24 hours'));
        try{           
             // Asignar valores a los parámetros y ejecutar la consulta
        
            $sql = "INSERT INTO registros (hash, fecha_caducidad) VALUES (:hash, :fecha_caducidad)";
            $arrValues[":hash"]= $hash;
            $arrValues[":fecha_caducidad"]= $fechaCaducidad;
            $conexion = Conexion::getInstance();
            // Obtener los resultados
            $return = $conexion->fetch($sql,$arrValues);
            $data= $hash;
            }catch(Exception $e){
                throw $e;
            }
    }elseif($action == "sesion"){
        try{           
            // Asignar valores a los parámetros y ejecutar la consulta
            $hash= isset($data["hash"])? $data["hash"]:null;
            $sql = "Select fecha_caducidad from registros where hash=:hash";
            $arrValues[":hash"]= $hash;
            $conexion = Conexion::getInstance();
            $currentDate = date('Y-m-d H:i:s');
            // Obtener los resultados
            $return = $conexion->fetch($sql,$arrValues);
            if ($currentDate>$return[0]["fecha_caducidad"]){
                 throw new Exception("sesion Caducada");
                 echo $return;
            }
            print_r($return) ;
            print_r($return[0]["fecha_caducidad"]);
            print_r($currentDate);
            $data= $hash;
            
        }catch(Exception $e){
            throw $e;
        }
    }elseif($action == "insertar"){
        $insertar = isset($data["datos"])? $data["datos"]:null;
        if( $insertar!=NULL){
            $data = Profesor::insertarProfesores($insertar);
        }else{
            $data = array();
        }
    }elseif($action == "actualizar"){
        $editar = isset($data["datos"])? $data["datos"]:null;
        if( $editar!=NULL){
            $data = Profesor::editarProfesores($editar);
        }else{
            $data = array();
        }
    }else{
        $data= Profesor::getAllProfesores($data["nombre"]);
    }

}catch(Exception $exception){
    if(substr($exception->getMessage(),0,15)=="SQLSTATE[23000]"){
        $msg= "Error de integridad de clave";
    }else{
        $msg=$exception->getMessage();
    }
    
    $success=false;
}
$json= array();
$json["msg"] = $msg;
$json["succes"] = $success;
$json["data"] = $data;
echo json_encode($json);
?>