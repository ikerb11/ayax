<?php
class Departamento {
    //Atributos
    /**
     * @var Codigo departamento Char(3) "001" 
     */
    private $codigo;
    /**
     * @var Nombre departamento VarChar(20) "10101010101010101010"
     */
    private $nombre;

    //Metodos
    public function __construct($codigo, $nombre)
    {
        $this->codigo= $codigo;
        $this->nombre= $nombre;
    }
    public function getCodigo(){
        return $this->codigo;
    }
    public static function getAllDepartamentos(){
        require_once("Conexion.php");
        $sql = "select * from departamento";
        $arrValues=[];
        $conexion = Conexion::getInstance();
        $return= $conexion->fetch($sql,$arrValues);
        return $return;

    }
}

?>