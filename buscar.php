<?php
    # incluir la libreria con la conexion a la base de datos
    include('conexion.php');
    # instanciar una conexion
    $mysqli = Conexion();

    # si la pagina cargo con metodo GE
    # (via formulario o escribiendo el URL a mano)
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {   
        $termino = $_GET['termino'];
        $param = "%{$termino}%";
        $query = $mysqli->prepare("SELECT * FROM publicaciones WHERE nombre LIKE ?");
        $query->bind_param('s',$param);
        $query->execute();
        $queryResult = $query->get_result();

        if($queryResult->num_rows > 0)
        {
            $publicaciones = $queryResult;
        }
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
            body
            {
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
        <br>
        <br>
         <h1><Center>Mostrando resultado de "<?=$termino?>"</h1>
    </head>
    <body>
        <section>
        <?php if(isset($publicaciones)): ?>
           
            <ul class="list-group">
                <?php foreach($publicaciones as $value): ?>
                <il>
                    <a  
                        style="color:bisque; text-decoration: none;"
                        class="text-center" 
                        href="./ver.php?id=<?=$value['id']?>"
                    >
                        <p><?=$value['nombre']?></p>
                    </a>
                </il>
                <?php endforeach; ?>
            </ul>
        <?php else:?>
            <h3 class="text-center">No se han encontrado publicaciones.</h3>
        <?php endif;?>
        </section>
    </body>
</html>