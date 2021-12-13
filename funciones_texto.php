<?php
    # devuelve verdadero si $palabra contiene profanidades
    function ContieneProfanidades($palabra)
    {
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