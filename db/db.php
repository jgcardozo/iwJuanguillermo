<?php

class db{

    private $host  ="localhost";
    private $user  ="root";
    private $pass  ="1234";
    private $dbase ="iwJuan";
    private $conexiondb;

    public function __construct(){
        $this->conexiondb = new mysqli($this->host, $this->user, $this->pass,$this->dbase) or die(mysql_error());
        $this->conexiondb->set_charset("utf8");
    }//construct


    public function seleccionar($tabla){
        $resultado = $this->conexiondb->query("SELECT * FROM $tabla") or die($this->conexiondb->error);
        if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }// select

    public function insertar($tabla, $campos, $valores){
        $query = "INSERT INTO $tabla ($campos) VALUES ($valores)";
        echo $query;
        $resultado =    $this->conexiondb->query($query) or die($this->conexiondb->error);
        if($resultado)
            return true;
        return false;
    } //insert


} //class

?>