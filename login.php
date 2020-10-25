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
<?php
if(!empty($_POST)) {
    $username = $_POST["usuario"];
    $pass = hash('sha256',$_POST["contra"]);

        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT id_usuario, username, password, usuario.id_tipo_usuario, tipo_usuario.id_tipo_usuario, nombre_tipo_usuario FROM usuario, tipo_usuario WHERE username = ? AND password =? AND usuario.id_tipo_usuario=tipo_usuario.id_tipo_usuario ";
        $stmt =$PDO->prepare($sql);
        $stmt->execute(array($username, $pass));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $PDO = null;
        if(!empty($data)) {
            //Almacenamos el nombre de usuario en una variable de sesión usuario
            $_SESSION['id_usuario'] = $data['id_usuario'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['id_tipo_usuario'] = $data['id_tipo_usuario'];
            $_SESSION['nombre_tipo_usuario'] = $data['nombre_tipo_usuario'];

            if($_SESSION['nombre_tipo_usuario'] == "cliente"){
                header('location:index_cl.php');
            }else{
                header('location:back_end/index_back.php');
            }
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
        <a href="login.php">login</a>
        <a href="">------------</a>
        <a href="">++++++++++++</a>
        <a href="">////////////</a>
    </nav>
    <h2>Login</h2>
    <form  method ='POST'>
            <fieldset>
                <div>
                    <input type="text" id="usuario" name="usuario"  placeholder="Usuario" class="form-control" autocomplete="off" maxlength="20">
                </div>
                <br>
                <div>
                    <input type="password" id="contra" name="contra" placeholder="Contraseña" class="form-control" autocomplete="off" maxlength="20">
                </div>
                <br>
                <div>
                    <button type="submit">Iniciar</button>
                    <a href="add_usuario.php">|Crear Usuario|</a>
                </div>
            </fieldset>
        </form>
</body>
<footer>
</footer>
</html>