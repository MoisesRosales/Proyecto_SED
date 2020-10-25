<?php
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
    
    // Delete Data
    if(!empty($_POST)) {
        require("../netflips.php");   
        $id = $_POST['id_usuario'];
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM usuario WHERE id_usuario = ?";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($id));
        $PDO = null;
        header("Location: index_usuario.php");
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
<div class="container"> 
    <div class='row'>
        <h2>ELIMINAR USUARIOS</h2>
    </div>
    <form method='POST'>
        <input type='hidden' name='id_usuario' value='<?php print($id); ?>'>
        <p>¿DESEA ELIMINAR ESTE USUARIO?</p>
            <button type='submit'>CONFIRMAR</button>
            <a href='index_usuario.php'>CANCELAR</a>
    </form>
</div>
</body>
<footer>
</footer>
</html>