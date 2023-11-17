<?php
$data = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json; charset=utf-8');
$name = !empty($_POST["action"])? $_POST["action"] : null;
$action= $data['action'];
$departameno_id=isset($data["departamento_id"])? $data["departamento_id"]:null;
require_once("Departamento.php");
require_once("Profesor.php");

$arrValues=[];
$msg =  "Listado de departamentos";
$success = true;
$data = array();

try{
    if($action == "departamentos"){
        $data = Departamento::getAllDepartamentos();
    } else{
        $data= Profesor::getAllProfesores();
    }

}catch(Exception $exception){
    $msg=$exception->getMessage();
}
$json= array();
$json["msg"] = $msg;
$json["succes"] = $success;
$json["data"] = $data;
echo json_encode($json);
?>