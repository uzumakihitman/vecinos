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
