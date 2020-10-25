<?php
    require("../netflips.php");
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header('location: ../login.php');
    exit();
    }
    if($_SESSION['nombre_tipo_usuario'] == "cliente"){
        header('location:../index_cl.php');
        exit();
    }
?>
<?php
    $id = null;
    if(!empty($_GET['id_tipo_usuario'])) {
        $id = $_GET['id_tipo_usuario'];
    }
    if($id == null) {
        header("Location: index_tipo_usuario.php");
    }
    
    require("../netflips.php");
    if(!empty($_POST)) {

    // validation errors
    $nombreError = null;
    $descripcionError = null;
    
    $nombre= $_POST['nombre'];
    $descripcion_tipo_usuario = $_POST['descripcion_tipo_usuario'];
    // validate input
    $valid = true;
    if(empty($nombre)) {
        $nombreError = "Por favor ingrese el nombre del nuevo tipo de usuario";
        $valid = false;
    }
    if(empty($descripcion_tipo_usuario)) {
        $descripcionError = "Por favor ingrese la descripcion.";
        $valid = false;
    }
    // insert data   
        if($valid) {
        	
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tipo_usuario SET nombre_tipo_usuario = ?, descripcion = ? WHERE id_tipo_usuario = ?";
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array($nombre, $descripcion_tipo_usuario,$id));

            header("Location: index_tipo_usuario.php");
        }
    }
    else {
        // read data
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT nombre_tipo_usuario, descripcion FROM tipo_usuario WHERE id_tipo_usuario= ?";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($data)) {
            header("Location: index_tipo_uusuario.php");
        }
        $nombre = $data['nombre_tipo_usuario'];
        $descripcion_tipo_usuario = $data['descripcion'];
    }
?>
<!DOCTYPE html>
<html lang=”en”>
<head>
    <meta charset=”UTF-8″ />
    <title>Netflips</title>
</head>
<body>
    <header>
        <h1>Netflips</h1>
    </header>
    <nav>
        <a href="index_back.php">|index|</a>
        <a href="index_usuario.php">|Usuarios|</a>
        <a href="index_tipo_usuario.php">|Tipo de Usuarios|</a>
        <a href="index_servicio.php">|Servicios|</a>
        <a href="index_pago.php">|Formas de pago|</a>
        <a href="index_suscripcion.php">|Suscripciones|</a>
        <a href="../salir.php">Salir</a>
    </nav>
    <br>
    <form  method ='POST'>
        <fieldset>
        <h2>Actualizar Tipo de usuario</h2>
        <div class='<?php print(!empty($nombre)?"has-error":""); ?>'>
            <label for='nombre'>Nombre</label>
            <br>
            <input type='text' name='nombre' placeholder='Ingrese el nuevo nombre' required='required' id='nombre' maxlength="50" autocomplete="off" value='<?php print($nombre); ?>'>
            <?php print(!empty($nombreError)?"<span>$nombreError</span>":""); ?>
        </div>
        <div class="col-md-12">
            <textarea name="descripcion_tipo_usuario" id="descripcion_tipo_usuario" required="required" class="form-control" rows="10" placeholder="Descripcion" maxlength="150" autocomplete="off"  
            <?php print(!empty($descripcionError)?"<span class='help-block'>$descripcionError</span>":""); ?>><?php print($descripcion_tipo_usuario);?></textarea>
        </div>
        <br>
        <div>
            <button type='submit'>Actualizar</button>
        </div>
        <a href='index_tipo_usuario.php'>Cancelar</a>
        </fieldset>
    </form>
</body>
<footer>
</footer>
</html>