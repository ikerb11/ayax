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
    public static function getAllProfesores(){
        $sql = "select * from profesor";
        $arrValues=[];
        $conexion = Conexion::getInstance();
        $return= $conexion->fetch($sql,$arrValues);
        
        return $return;

    }
    public static function getProfesoresDepartamento($departamento_id){
        
        $sql = "select * from profesor where id_departamento=:departamento_id";
        $arrValues[":departamento_id"]= $departamento_id;
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
}
?>