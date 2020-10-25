<?php
    require("netflips.php");
    session_start();

    if (isset($_SESSION['id_usuario'])) {
        if($_SESSION['nombre_tipo_usuario'] == "cliente"){
            header('location:index_cl.php');
            exit();
        }else{
            header('location:back_end/index_back.php');
            exit();
        } 
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
        <a href='login.php'>login</a>
    </nav>
    <h2>Index</h2>
</body>
<footer>
</footer>
</html>