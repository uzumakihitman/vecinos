<?php
    # incluir la libreria con la conexion a la base de datos
    include('conexion.php');
    $conexion = Conexion();
    $msjError = '';


    # si la pagina cargo con metodo GE
    # (via formulario o escribiendo el URL a mano)
   // if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
        $query = $conexion->prepare("SELECT * FROM publicaciones WHERE id = ?");
        $query->bind_param("s", $id);
        $query->execute();
        $resultado = $query->get_result();

        if($resultado->num_rows > 0){
            $publicacion = $resultado->fetch_assoc();

            $query = $conexion->prepare('SELECT * FROM vecinos WHERE id = ?');
            $query->bind_param("s", $publicacion['vecino_id']);
            $query->execute();
            $vecino =  $query->get_result()->fetch_assoc();

            $query = $conexion->prepare('SELECT vecino_id, contenido, usuario FROM comentarios WHERE publ_id = ?');
            $query->bind_param("s", $id);   
            $query->execute();
            $resultado = $query->get_result();
            if($resultado->num_rows > 0){
                $comentarios = $resultado;
            }
        }
        else{
            $msjError = 'No hay publicaciones con ese id';
        }
  //  }
  //  else
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nuevo_comentario_contenido = LimpiarInput($_POST['nuevo_comentario_contenido']);
        $nombre_usuario = LimpiarInput($_POST['nombre_usuario']);
        $sql = "SELECT nombre FROM vecinos WHERE nombre='".$nombre_usuario."';";
        $resultado = $conexion->query($sql);
        $usuario = $resultado->fetch_assoc();

        if ($usuario == !NULL) {
            # code...
        
        /*if (!empty($nuevo_comentario_contenido)) {
           /* $query = $conexion->prepare('INSERT INTO comentarios (vecino_id,publ_id,contenido) VALUES (?,?,?,?)');
            $query->bind_param("ssss",$publicacion['vecino_id'],$publicacion['id'],$nuevo_comentario_contenido);
            $query->execute();
            $resultado=$query->get_result();*/
                $sql = "INSERT INTO comentarios (vecino_id,publ_id,contenido,usuario) VALUES ('".$publicacion['vecino_id']."','".$publicacion['id']."','".$nuevo_comentario_contenido."','".$nombre_usuario."');";
                $resultado = $conexion->query($sql);
                if ($resultado) {
                    header("Location: ver.php?id=".$id);
                }
            }else{
                $msjError = "Este usuario no esta registrado!";
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
                <!-- Si se encontro una publicacion con el id --> 
                <?php if(isset($publicacion)) : ?>
                    <!-- Imprimir datos de la publicacion -->
                    <!-- Nombre -->
                    <h3><?php echo $publicacion['nombre'];?></h3>
                    <!-- Boton actualizar -->
                    <a  
                        style="color:bisque; text-decoration: none;" 
                        href="./actualizar.php?id=<?=$publicacion['id']?>"
                        > ACTUALIZAR
                    </a>
                    <!-- Descripcion -->
                    <p><?php echo $publicacion['descripcion'];?></p>
                    <!-- Stock -->
                    <p> stock: <?php echo $publicacion['stock'];?></p>

                <?php endif; ?>

                <!-- Comentarios -->
                <!-- Titulo seccion -->

                </br><h5 style="font-weight: bold;">COMENTARIOS</h5>    
                    <?php if(isset($comentarios)) : ?>
                        <!-- Imprimir cada comentario de la publicacion en un <p> -->
                        <?php while($comentario = $comentarios->fetch_assoc()) : ?>
                            <p style="font-weight: bold;">(<?php echo $comentario['usuario'];?>) <?php echo $comentario['contenido']; ?></p>
                        <?php endwhile; ?>
                    <?php else:?>
                        <!-- Si no hay comentarios en la publicacion
                            mostrar un mensaje -->
                        <p>No hay comentarios en esta publicacion</p>
                    <?php endif;?>
                <h5>DEJA UN COMMENTARIO</h5>
                <form action="<?php echo 'ver.php?id='.$id ?>" method="POST">
                    <textarea class="d-block w-100" name="nuevo_comentario_contenido"></textarea>
                    <input type="text" name="nombre_usuario" placeholder="Nombre">
                    <?php if (isset($msjError)) {
                        echo $msjError;
                    } ?>
                    <input class="btn btn-primary" type="submit" name="submit" value="Publicar">
                </form>
            </div>
        </section>
        
    </body>
    <script type="text/javascript">
        function commentBox(){
        var name=document.getElementById('name').value;
        var comment=document.getElementById('comment').value;
     
        if(name =="" || comment ==""){
            alert("Porfavor introduce la informacion requerida!");
        }else{
            var parent=document.createElement('div');
            var el_name=document.createElement('h5');
            var el_message=document.createElement('p');
            var el_line=document.createElement('hr');
            var txt_name=document.createTextNode(name);
            var txt_message=document.createTextNode(comment);
            el_name.appendChild(txt_name);
            el_message.appendChild(txt_message);
            el_line.style.border='1px solid #000';
            parent.appendChild(el_name);
            parent.appendChild(el_line);
            parent.appendChild(el_message);
            parent.setAttribute('class', 'pane');
            document.getElementById('result').appendChild(parent);
     
            document.getElementById('name').value="";
            document.getElementById('comment').value="";
        }
     
    }
    </script>
</html>