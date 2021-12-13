<?php
    # Informacion de la conexion a la base de dat os
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'emprendimientos');
    
    # funcion devuelve una conexion valida a la base de datos
    function Conexion(){
        $conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if($conexion->ping() == FALSE){
            echo 'No hay conexion con la base de datos';
        }    
        return $conexion;

    }

    # devuelve verdadero si $palabra contiene profanidades
    function ContieneProfanidades($palabra)
    {
        # cambiar esto. no funciona.
        $lista = ['profanidad1','profanidad2','profanidad3'];
        if(in_array($palabra, $lista))
        {
            return true;
        }
        return false;
    }

    function LimpiarInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>