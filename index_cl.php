<?php
    require("netflips.php");
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header('location:index.php');
    exit();
    }
    if($_SESSION['nombre_tipo_usuario'] != "cliente"){
        header('location:back_end/index_back.php');
        exit();
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
        <a href="index.php">index</a>
        <a href='index_suscripcion_cl.php'>Suscripcion</a>
        <a href="salir.php">Salir</a>
    </nav>
    <h2>Index clientes</h2>
    <?php
        echo ("<h3>{$_SESSION['id_usuario']}{$_SESSION['username']}{$_SESSION['nombre_tipo_usuario']}</h3>");
    ?>
</body>
<footer>
</footer>
</html>