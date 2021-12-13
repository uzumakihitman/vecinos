<?php
    # incluir la libreria con la conexion a la base de datos
    include('conexion.php');
    # instanciar una conexion
    $conexion = Conexion();
    $msjError = '';

    
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        # variables del formulario
        $id_vecino = LimpiarInput($_POST['id_vecino']);
        $nombre = LimpiarInput($_POST['nombre']);
        $desc = LimpiarInput($_POST['desc']);
        $stock = LimpiarInput($_POST['stock']);

        # es el stock numerico?
        # no : stock = null
        if(!is_numeric($stock)) {$stock = '';}
        if(ContieneProfanidades($nombre)) $nombre = -1;
        if(ContieneProfanidades($desc)) $desc = '';
        #esta algun campo vacio?
        if(!empty($id_vecino) && !empty($nombre) && !empty($desc) && !empty($stock)){
            # no hay campos vacios y stock es numerico
            # prepara consulta sql
            $query = $conexion->prepare('INSERT INTO publicaciones (vecino_id, nombre, descripcion, stock) VALUES (?,?,?,?)');
            # llena la consulta con la informacion del formulario
            $query->bind_param("ssss", $id_vecino, $nombre, $desc, $stock);
            
            # se pudo ejecutar correctamente la consulta?
            if($query->execute()){
                # si : redirige al usuario a la pagina de la nueva publicacion
                header('location:./ver.php?id='.$conexion->insert_id);
            }
            else{
                # no : hay un error en la consulta
                $msjAdicional = 'Error al crear una publicacion.';
            }
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
    </head>
    <body>
        <section>
            <div class="container">
                <a class="text-dark" href="index.php">Inicio</a>
                <h3 class="text-center">NUEVA PUBLICACION</h3></br>
                <!-- Formulario nueva publicacion -->
                <!-- PHP : Mismo archivo -->
                <!-- Metodo : POST -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <!-- Input temporal para el debug y desarrollo -->
                    <div class="form-group">
                        <h3 style="font-weight: bold;">id vecino</h3>
                        <input type="text" name="id_vecino" class="form-control">
                    </div>

                    <!-- Seccion nombre -->
                    <div class="form-group">
                        <!-- Texto "nombre" -->
                        <h3 style="font-weight: bold;">nombre</h3>
                        <!-- entrada de texto nombre -->
                        <input type="text" name="nombre" class="form-control">
                        <!-- mensaje de error nombre-->
                        <span class="help-block">
                            <?php if( isset($nombre) && empty($nombre)) echo 'Nombre invalido'; ?>
                        </span>
                    </div>

                    <!-- Seccion descripcion -->
                    <div class="form-group">
                        <!-- Texto "descripcion" -->
                        <h3 style="font-weight: bold;">descripcion</h3>
                        <!-- entrada de texto descripcion -->
                        <textarea class="form-control" aria-label="With textarea" name="desc"></textarea>
                        <!-- mensaje de error descripcion -->
                        <span class="help-block">
                            <?php if( isset($desc) && empty($desc)) echo 'Descripción invalida'; ?>
                        </span>
                    </div>

                    <!-- Seccion stock -->
                    <div class="form-group">
                        <!-- Texto "stock" -->
                        <h3 style="font-weight: bold;">stock</h3>
                        <!-- entrada de texto stock -->
                        <input type="text" name="stock" class="form-control">
                        <!-- mensaje de error stock-->
                        <span class="help-block">
                            <?php if(isset($stock) && empty($stock)) echo 'Stock numerico debe ser > 0'; ?>
                        </span>
                    </div>
                    </br>
                    <!-- seccion botones -->
                    <div class="form-group">
                        <!-- boton para enviar formulario, texto "PUBLICAR" -->
                        <input type="submit" class="btn btn-primary" value="PUBLICAR">
                        <!-- boton limpiar el formulario, texto "LIMPIAR" -->
                        <input type="reset" class="btn btn-default" value="LIMPIAR">
                        </br>
                        <span class="help-block">
                            <?php if(isset($msjAdicional) && !empty($msjAdicional)) echo $msjAdicional; ?>
                        </span>
                    </div>
                </form>
            </div>   
        </section>
    </body>
</html>