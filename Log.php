<?php
class Log{
    


    private $log_filename = "log.txt";


    public function newLine($email, $estado)
    {
        if (!file_exists($this->log_filename)) 
        {
                     
  /*          chdir('../../');
            $dir =  getcwd();
            echo $dir;
            chmod('ideaware', 0777); */

            $fp = fopen($this->log_filename, 'w');
            fwrite($fp,
            "-----------  Log sistema de subscripcion IwJuan -----------".PHP_EOL);
            fclose($fp);
            chmod($this->log_filename, 0777); 
        }
    
        //$estado = "Agregado exitosamente";
        // "Fallo envío {$error}" ;
        date_default_timezone_set('America/Bogota');
        $newLine  = "Correo:".$email.' Fecha:'.date("m/d/yy H:i:s").
        " Estado:".$estado.PHP_EOL;
    
        file_put_contents($this->log_filename , $newLine, FILE_APPEND); 
        echo "registro agregado al log \n";  

    }//newLine



}//class
?>