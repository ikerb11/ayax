<?php
require_once("Conexion.php");
/**
 * Class Profesor
 * @author Iker berna
 * @since 10/19/2023
 * @version 1.0.0
 */
class Profesor {
    //Atributos
    /**
     * @var Dni profesor Char(10) "65004204V" 
     */
    private $dni;
    /**
     * @var Nombre profesor VarChar(18) "101010101010101010"
     */
    private $nombre;

    //Metodos
    public function __construct($dni, $nombre)
    {
        $this->dni= $dni;
        $this->nombre= $nombre;
    }
    public function getDni(){
        return $this->dni;
    }
    public static function getAllProfesores($nombre){
        $sql = "select * from profesor";
        $arrValues=[];
        if (isset($nombre) && $nombre!=""){
            $arrValues[":nombre"]=$nombre;
            $sql.=' where nombre like concat("%",:nombre,"%")';
        }
        
        $conexion = Conexion::getInstance();
        $return= $conexion->fetch($sql,$arrValues);
        
        return $return;

    }
    public static function getProfesoresDNI($dni){
        
        $sql = "select * from profesor where dni=:dni";
        $arrValues[":dni"]= $dni;
        $conexion = Conexion::getInstance();
        $return= $conexion->fetch($sql,$arrValues);
        return $return;

    }
    public static function deleteProfesores($dni){
        try{
        $sql = "delete from profesor where dni=:dni";
        $arrValues[":dni"]= $dni;
        $conexion = Conexion::getInstance();

        // Asignar valores a los parámetros y ejecutar la consulta
    
        // Obtener los resultados
        $return = $conexion->fetch($sql,$arrValues);
        return $return;
        }catch(Exception $e){
            throw $e;
        }

    }
    public static function insertarProfesores($datos){
        try{
            $sql="
            INSERT INTO profesor
            VALUES (:dni, :apellido1, :apellido2, :nombre, :direccion, :localidad, :provincia, :fecha_ingreso, :id_categoria, :id_departamento)
            ";
            $fecha=date_create_from_format("d-m-Y",$datos[7]);
            echo $fecha;
            $arrValues[':dni']=  $datos[0];
            $arrValues[':apellido1']=$datos[1];
            $arrValues[':apellido2']=$datos[2];
            $arrValues[':nombre']= $datos[3];
            $arrValues[':direccion']= $datos[4];
            $arrValues[':localidad']= $datos[5];
            $arrValues[':provincia']= $datos[6];
            $arrValues[':fecha_ingreso']= $datos[7];
            $arrValues[':id_categoria']= $datos[8];
            $arrValues[':id_departamento']= $datos[9];
            $conexion = Conexion::getInstance();
            // Obtener los resultados
            $return = $conexion->fetch($sql,$arrValues);
        return $return;
        }catch(Exception $e){
            
            throw $e;
        }

    }
    public static function editarProfesores($datos){
        try{
            $sql="
            update profesor
            set  apellido_1=:apellido1, apellido_2=:apellido2, nombre=:nombre, direccion=:direccion, localidad=:localidad, provincia=:provincia, fecha_ingreso=:fecha_ingreso, id_categoria=:id_categoria, id_departamento=:id_departamento 
            where dni=:dni";
            $fecha=date_create_from_format("d-m-Y",$datos[7]);
            echo $fecha;
            $arrValues[':dni']=  $datos[0];
            $arrValues[':apellido1']=$datos[1];
            $arrValues[':apellido2']=$datos[2];
            $arrValues[':nombre']= $datos[3];
            $arrValues[':direccion']= $datos[4];
            $arrValues[':localidad']= $datos[5];
            $arrValues[':provincia']= $datos[6];
            $arrValues[':fecha_ingreso']= $datos[7];
            $arrValues[':id_categoria']= $datos[8];
            $arrValues[':id_departamento']= $datos[9];
            $conexion = Conexion::getInstance();
            // Obtener los resultados
            $return = $conexion->fetch($sql,$arrValues);
        return $return;
        }catch(Exception $e){
            throw $e;
        }

    }
}
?>