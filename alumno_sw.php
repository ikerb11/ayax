<?php
$data = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json; charset=utf-8');
$name = !empty($_POST["action"])? $_POST["action"] : null;
$action= $data['action'];
$profesor_id=isset($data["departamento_id"])? $data["departamento_id"]:null;
require_once("Conexion.php");

$arrValues=[];
$msg =  "Listado de departamentos";
$success = true;
$data = array();

try{
    if($action == "departamentos"){
        $sql = "select * from departamento";
    } else{
        $sql = "select * from profesor where id_departamento=:departamento_id";
        $arrValues[":departamento_id"]= $profesor_id;
    }
    $conexion = Conexion::getInstance();
    $data=$conexion->fetch($sql,$arrValues);
    
}catch(Exception $exception){
    $msg=$exception->getMessage();
}
$json= array();
$json["msg"] = $msg;
$json["succes"] = $success;
$json["data"] = $data;
echo json_encode($json);
?>