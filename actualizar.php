<?php
    # incluir la libreria con la conexion a la base de datos
    include('conexion.php');
    # instanciar una conexion
    $conexion = Conexion();

    # si la pagina cargo con metodo GE
    # (via formulario o escribiendo el URL a mano)
   // if($_SERVER['REQUEST_METHOD'] == 'GET'){
        # id de la publicacion que se quiere cargar
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }else{
            header("Location: index.php");
        }
        # seleccionar toda la informacion de la publicacion cuyo id es $id
        $query = $conexion->prepare('SELECT * FROM publicaciones WHERE id = ?');
        $query->bind_param("s", $id);

        # executar la consulta
        $query->execute();

        #almacenar los resultados de la consulta
        $resultado = $query->get_result();

        # si la consulta devolvio valores
        if($resultado->num_rows > 0){
            # informacion de la publicacion que se quiere actualizar
            $data = $resultado->fetch_assoc();
        }
        else{
            $msjError ='No hay publicaciones con ese id';
        }
//    }

    # actualizar informacion
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        # variables del formulario
        $id = LimpiarInput($_POST['id']);
        $nombre = LimpiarInput($_POST['nombre']);
        $desc = LimpiarInput($_POST['desc']);
        $stock = LimpiarInput($_POST['stock']);

        # es el stock numerico?
        # no : stock = null
        if(!is_numeric($stock)) {$stock = '';}
        
        # cargar mediante url tipo actualizar.php/id=x
        # si perfil id_vecino no es creador de la publicacion id=x,
        # entonces no permitirle actualziar la publicacion
        # si algun campo esta vacio, no hacer  nada
      //  if(!empty($id) && !empty($nombre) && !empty($desc) && !empty($stock))
        //{
            # crear una consulta sql
            $query = $conexion->prepare('update publicaciones set
                                            nombre = ?,
                                            descripcion = ?,
                                            stock = ?
                                        where
                                            id = '.$id);
            # llenar la consulta con la informacion del formulario
            //$query->bind_param("sss", $nombre, $desc, $stock);
            $sql = "UPDATE publicaciones set nombre='".$nombre."', descripcion='".$desc."', stock='".$stock."' WHERE id='".$id."';";
            $result = $conexion->query($sql);
            # si fue posible realizar la consulta, la publicacion fue actualizada
            # redirigir a la publicacion $query->execute() === TRUE
            if($result){
                header("location:ver.php?id=".$id);
            }
       // }
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
                
                background-color: black;   
                
                
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
        <div class="container" 
        >
            <a class="text-white" href="index.php">Inicio</a>
            <h4 style="color:yellow;" class="text-center"; color ><CENTER>ACTUALIZAR PUBLICACION</h3></br>
            <br/>
            <!-- Formulario actualizar publicacion -->
            <!-- PHP : Mismo archivo -->
            <!-- Metodo : POST -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <!-- (invisible) id de la publicacion que se esta actualizando -->    
                <div class="georgia">
                    <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                </div>
                <!-- Seccion nombre -->
                <div class="georgia">
                    <!-- Texto "nombre" -->
                    <h3 style="color:yellow;" style="font-weight: bold;"> <CENTER> Nombre</h3>
                    <br/>

                    <!-- entrada de texto nombre -->
                    <input type="text" name="nombre" class="form-control" value="<?php if(isset($data)){ echo $data['nombre'];} ?>">
                    <!-- mensaje de error nombre-->
                    
                    <span style="color:yellow;" class="help-block"><?php if( isset($nombre) && empty($nombre))  echo 'Debe ingresar un nombre.';?>
                </div>

                <!-- Seccion descripcion -->
                <div class="georgia">
                    <!-- Texto "descripcion" -->
  
                    <h3 style="color:yellow;" style="font-weight: bold;"><CENTER>Descripcion</h3>
                    <br/>

                    <!-- entrada de texto descripcion -->
                    <textarea class="form-control" aria-label="With textarea" name="desc"><?php if(isset($data)) echo $data['descripcion']; ?></textarea>
                    <!-- mensaje de error descripcion -->
                    <span style="color:yellow;" class="help-block"><?php if( isset($desc) && empty($desc)) echo 'Debe ingresar una descripcion.'; ?></span>
                </div>

                <!-- Seccion stock -->
                <div class="georgia">
                    <!-- Texto "stock" -->
                    <h3 style="color:yellow;" style="font-weight: bold;"> <CENTER> Stock</h3>
                    <!-- entrada de texto stock -->
                    <input type="text"; name="stock" ; class="form-control" value="<?php if(isset($data)) echo $data['stock']; ?>">
                    <!-- mensaje de error stock-->
                    <span style="color:yellow;" class="help-block"><?php if(isset($stock) && empty($stock)) echo  'Debe ingresar un valor numerico.'; ?></span>
                </div>

                <!-- seccion botones -->
                <div class="georgia"
                style= "color:yellow;"></br>
                
                        <!-- boton para enviar formulario, texto "PUBLICAR" -->
                        <input  type="submit"  class="btn btn-primary" value="ACTUALIZAR" >
                    <span class="help-block" ><?php if(!empty($msjError)) echo $msjError; ?></span>
                </div>
                </form>
        </div>   
    </section>
    
    
    </body>
</html>