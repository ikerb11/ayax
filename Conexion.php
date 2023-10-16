<?php
/**
 * Class departamento
 * @author Iker berna
 * @since 03/19/2023
 * @version 1.0.0
 */
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
}
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
}

/**
 * Class Conexion
 * @author Iker berna
 * @since 03/19/2023
 * @version 1.0.0
 */
class Conexion{
    //Atributos
    private const HOST="localhost";
    private const DBNAME="universidad";
    private const PORT="3306";
    private const USER="root";
    private const PASS="";
    private static $instances = [];
    private static $pdo;
 //Metodos
 public function __construct()
 {
        self::$pdo= new PDO("mysql:host=".self::HOST.";dbname=".self::DBNAME.";charset=utf8",self::USER,self::PASS);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }

 public static function getInstance()
 {
     $subclass = Conexion::class;
     //Si no existen instancias de uno mismo se instancia a si mismo y guarda la instancia
     if (!isset(self::$instances[$subclass])) {
         self::$instances[$subclass] = new Conexion();
     }
     return self::$instances[$subclass];
 }

 public function fetch($sql, $arrValues){
    try{
        $stmt = Conexion::$pdo->prepare($sql);
        $stmt->execute($arrValues);
    
        return $stmt-> fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $exception){
        $msg=$exception->getMessage();
    }
 }
}