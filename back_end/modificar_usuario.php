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
    if(!empty($_GET['id_usuario'])) {
        $id = $_GET['id_usuario'];
    }
    if($id == null) {
        header("Location: index_usuario.php");
    }
    
    require("../netflips.php");
    if(!empty($_POST)) {
    	  
        // validation errors
        $nombreError = null;
        $emailError = null;
        $nombre_usuarioError = null;
        $id_tipo_usuarioError = null;
        $validarError  = null;
        
        // post values
        $nombre= $_POST['nombre'];
        $email = $_POST['email'];
        $nombre_usuario = $_POST['username'];
        $id_tipo_usuario = $_POST['id_tipo_usuario'];

        // validate input
        $valid = true;

        if(empty($nombre)) {
            $nombreError = "Por favor ingrese su nombre completo";

        }
        if(empty($email)) {
            $emailError = "Por favor ingrese el correo electtronico.";
            $valid = false;
        }
        if(empty($nombre_usuario)) {
            $nombre_usuarioError = "Por favor ingrese del usuario";
            $valid = false;
        }
        
        if(empty($id_tipo_usuario)) {
            $id_tipo_usuarioError = "Por favor seleccione el tipo de usuario.";
            $valid = false;
        }
        if($contra_usuario != $contra_confirm) {
            $validarError = "Las contraseñas no coinciden";
            $valid = false;
        }
        if($contra_usuario == $nombre_usuario) {
            echo "La contraseña no puede ser igual a el nombre de usuario";
            $valid = false;
        }             
        // update data       
        if($valid) {
        	
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE usuario SET nombre = ?, correo = ?, username = ?, id_tipo_usuario = ? WHERE id_usuario = ?";
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array($nombre, $email,$nombre_usuario,$id_tipo_usuario,$id));

            header("Location: index_usuario.php");
        }
    }
    else {
        // read data
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT nombre, correo,username,id_tipo_usuario FROM usuario WHERE id_usuario= ?";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($data)) {
            header("Location: index_usuario.php");
        }
        $nombre = $data['nombre'];
        $email = $data['correo'];
        $nombre_usuario = $data['username'];
        $id_tipo_usuario = $data['id_tipo_usuario'];
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
            <div class='<?php print(!empty($emailError)?"has-error":""); ?>'>
                <label for='email'>Correo</label>
                <br>
                <input type='email' name='email' placeholder='Ingrese el nuevo correo' required='required' id='email' maxlength="50" autocomplete="off" value='<?php print($email); ?>'>
                <?php print(!empty($emailError)?"<span>$emailError</span>":""); ?>
            </div>
            <div class='<?php print(!empty($nombre_usuario)?"has-error":""); ?>'>
                <label for='username'>Nombre de Usuario</label>
                <br>
                <input type='text' name='username' placeholder='Ingrese el nuevo nombre de usuario' required='required' id='username' maxlength="20" autocomplete="off" value='<?php print($nombre_usuario); ?>'>
                <?php print(!empty($nombre_usuarioError)?"<span>$nombre_usuarioError</span>":""); ?>
            </div>
            <div class='<?php print(!empty($id_tipo_usuarioError)?"has-error":""); ?>'>
                <label for='id_tipo_usuario'>Tipo de usuario</label>
                <br>
                <select name='id_tipo_usuario' required='required' id='id_tipo_usuario'>
                    <?php
                    $sql="SELECT id_tipo_usuario, nombre_tipo_usuario FROM tipo_usuario";
                    foreach ($PDO->query($sql) as $row) {
                        echo "<option value ='$row[id_tipo_usuario]'";
                        if ($id_tipo_usuario == $row['id_tipo_usuario'])
                        {
                            echo " selected";
                        }
                        echo ">";
                        echo $row['nombre_tipo_usuario'];
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>
                <br>
                <div>
                    <button type='submit'>Actualizar</button>
                </div>
                <a href='index_usuario.php'>Cancelar</a>
            </fieldset>
        </form>
</body>
<footer>
</footer>
</html>