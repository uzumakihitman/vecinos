<?php
    # incluir la libreria con la conexion a la base de datos
    include('conexion.php');
    # instanciar una conexion
    $conexion = Conexion();

    $query = $conexion->prepare('select * from publicaciones');
    $query->execute();
    $resultado = $query->get_result();
    if($resultado->num_rows > 0){
        $publicaciones = $resultado;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- body : color de fondo-->
        <!-- section : atributos necesarios para centrar el contenedor
            del formulario en la pantalla -->
        <style>
            body{
                background-color: darkcyan; 
            }
            section
            {
                border-radius: 1em;
                padding: 1em;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-right: -50%;
                transform: translate(-50%, -50%) 
            }
        </style>
    </head>
    <body>
        <section>
            <!-- vinculo para crear una nueva publicacion -->
            <a style="color:bisque;" class="text-center" href="nuevo.php">CREAR UNA NUEVA PUBLICACION</a>
            <!-- formulario de busqueda -->
            <form action="buscar.php" method="GET">
                <!-- contenedor de la barra de busqueda -->
                <div class="form-group">
                    <!-- input tipo texto -->
                    <input class="text-center w-100" type="text" name="termino" placeholder="¿Qué necesita?">
                </div>
            </form>
        </section>
    </body>
</html>