<?php
$data = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json; charset=utf-8');
$name = !empty($_POST["action"])? $_POST["action"] : null;
$action= $data['action'];
$departameno_id=isset($data["departamento_id"])? $data["departamento_id"]:null;
require_once("Departamento.php");
require_once("Profesor.php");

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
        $data= Profesor::getAllProfesores();
    }

}catch(Exception $exception){
    $msg=$exception->getMessage();
    $success=false;
}
$json= array();
$json["msg"] = $msg;
$json["succes"] = $success;
$json["data"] = $data;
echo json_encode($json);
?>