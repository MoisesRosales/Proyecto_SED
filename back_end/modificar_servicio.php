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
    if(!empty($_GET['id_servicio'])) {
        $id = $_GET['id_servicio'];
    }
    if($id == null) {
        header("Location: index_servicio.php");
    }
    
    require("../netflips.php");
    if(!empty($_POST)) {

    // validation errors
    $nombreError = null;
    $costoError = null;
    $descripcionError = null;
    
    $nombre= $_POST['nombre'];
    $costo= $_POST['costo'];
    $descripcion = $_POST['descripcion'];
    // validate input
    $valid = true;
    if(empty($nombre)) {
        $nombreError = "Por favor ingrese el nombre del nuevo tipo de usuario.";
        $valid = false;
    }
    if(empty($costo)) {
        $costoError = "Por favor ingrese el costo del servicio.";
        $valid = false;
    }
    if(empty($descripcion)) {
        $descripcionError = "Por favor ingrese la descripcion.";
        $valid = false;
    }
    // insert data   
        if($valid) {
        	
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE servicio SET nombre = ?, descripcion = ?, costo = ? WHERE id_servicio = ?";
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array($nombre, $descripcion,$costo,$id));

            header("Location: index_servicio.php");
        }
    }
    else {
        // read data
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT nombre, descripcion, costo FROM servicio WHERE id_servicio= ?";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($data)) {
            header("Location: index_servicio.php");
        }
        $nombre = $data['nombre'];
        $costo = $data['costo'];
        $descripcion = $data['descripcion'];
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
        <h2>Actualizar Servicio</h2>
        <div class='<?php print(!empty($nombre)?"has-error":""); ?>'>
            <label for='nombre'>Nombre</label>
            <br>
            <input type='text' name='nombre' placeholder='Ingrese el nuevo nombre' required='required' id='nombre' maxlength="50" autocomplete="off" value='<?php print($nombre); ?>'>
            <?php print(!empty($nombreError)?"<span>$nombreError</span>":""); ?>
        </div>
        <div class='<?php print(!empty($costo)?"has-error":""); ?>'>
            <label for='costo'>Costo</label>
            <br>
            <input type='number' step="any" name='costo' placeholder='Ingrese el nuevo costo' required='required' id='costo' maxlength="50" autocomplete="off" value='<?php print($costo); ?>'>
            <?php print(!empty($costoError)?"<span>$costoError</span>":""); ?>
        </div>
        <div class="col-md-12">
            <textarea name="descripcion" id="descripcion" required="required" class="form-control" rows="10" placeholder="Descripcion" maxlength="150" autocomplete="off"  
            <?php print(!empty($descripcionError)?"<span class='help-block'>$descripcionError</span>":""); ?>><?php print($descripcion);?></textarea>
        </div>
        <br>
        <div>
            <button type='submit'>Actualizar</button>
        </div>
        <a href='index_servicio.php'>Cancelar</a>
        </fieldset>
    </form>
</body>
<footer>
</footer>
</html>