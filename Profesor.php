<?php
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
        require_once("Conexion.php");
        $sql = "select * from profesores";
        $arrValues=[];
        $conexion = Conexion::getInstance();
        $return= $conexion->fetch($sql,$arrValues);
        return $return;

    }
    public static function getProfesoresDepartamento($departamento_id){
        require_once("Conexion.php");
        $sql = "select * from profesor where id_departamento=:departamento_id";
        $arrValues[":departamento_id"]= $departamento_id;
        $conexion = Conexion::getInstance();
        $return= $conexion->fetch($sql,$arrValues);
        return $return;

    }
}
?>