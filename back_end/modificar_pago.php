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
    if(!empty($_GET['id_tipo_pago'])) {
        $id = $_GET['id_tipo_pago'];
    }
    if($id == null) {
        header("Location: index_pago.php");
    }
    
    require("../netflips.php");
    if(!empty($_POST)) {

    // validation errors
    $nombreError = null;
    $cuentaError = null;
    
    $nombre= $_POST['nombre'];
    $cuenta= strtoupper($_POST['cuenta']);

    // validate input
    $valid = true;
    if(empty($nombre)) {
        $nombreError = "Por favor ingrese el nombre del nuevo tipo de usuario.";
        $valid = false;
    }
    if(empty($cuenta)) {
        $cuentaError = "Por favor ingrese el nuevo numero de cuenta.";
        $valid = false;
    }

    // insert data   
        if($valid) {
        	
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tipo_pago SET nombre = ?, cuenta = ? WHERE id_tipo_pago = ?";
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array($nombre, $cuenta,$id));

            header("Location: index_pago.php");
        }
    }
    else {
        // read data
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT nombre, cuenta FROM tipo_pago WHERE id_tipo_pago= ?";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($data)) {
            header("Location: index_pago.php");
        }
        $nombre = $data['nombre'];
        $cuenta = $data['cuenta'];
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
        <h2>Actualizar Forma de Pago</h2>
        <div class='<?php print(!empty($nombre)?"has-error":""); ?>'>
            <label for='nombre'>Nombre</label>
            <br>
            <input type='text' name='nombre' placeholder='Ingrese el nuevo nombre' required='required' id='nombre' maxlength="50" autocomplete="off" value='<?php print($nombre); ?>'>
            <?php print(!empty($nombreError)?"<span>$nombreError</span>":""); ?>
        </div>
        <div class='<?php print(!empty($cuenta)?"has-error":""); ?>'>
            <label for='cuenta'>Cuenta</label>
            <br>
            <input type='text' style="text-transform:uppercase;" name='cuenta' placeholder='Ingrese el nuevo numero de cuenta' required='required' id='cuenta' maxlength="50" autocomplete="off" value='<?php print($cuenta); ?>'>
            <?php print(!empty($cuentaError)?"<span>$cuentaError</span>":""); ?>
        </div>
        <br>
        <div>
            <button type='submit'>Actualizar</button>
        </div>
        <a href='index_pago.php'>Cancelar</a>
        </fieldset>
    </form>
</body>
<footer>
</footer>
</html>