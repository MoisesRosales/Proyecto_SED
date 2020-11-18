<?php
    require("netflips.php");

    if(!empty($_POST)) {

    // validation errors
    $nombreError = null;
    $emailError = null;
    $nombre_usuarioError = null;
    $contra_usuarioError = null;
    $contra_confirmError = null;
    $id_tipo_usuarioError = null;
    $validarError  = null;

    $nombre= $_POST['nombre'];
    $email = $_POST['email'];
    $nombre_usuario = $_POST['username'];
    $contra_usuario = $_POST['contra'];
    $contra_confirm = $_POST['contra2'];
    $contra_encrip =  hash('sha256',$_POST["contra"]);
    $id_tipo_usuario = null;

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
    if(empty($contra_usuario)) {
        $contra_usuarioError = "Por favor ingrese la contraseña.";
        $valid = false;
    }
    if(empty($contra_confirm)) {
        $contra_confirmError = "Por favor verifique su Contraseña.";
        $valid = false;
    }
    if (!isset($_SESSION['id_usuario'])) {
        $cliente = 'cliente';
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT id_tipo_usuario FROM tipo_usuario WHERE nombre_tipo_usuario = ?";
        $stmt =$PDO->prepare($sql);
        $stmt->execute(array($cliente));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) {
            //Almacenamos el id que pertenece al tipo cliente
            $id_tipo_usuario = $data['id_tipo_usuario'];
        }
    }
    if($contra_usuario != $contra_confirm) {
        $validarError = "Las contraseñas no coinciden";
        $valid = false;
    }
    if($contra_usuario == $nombre_usuario) {
        echo "La contraseña no puede ser igual a el nombre de usuario";
        $valid = false;
    }
    // insert data
    if ($valid) {
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO usuario(nombre,correo,username, password, id_tipo_usuario) values(?,?,?,?,?)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($nombre,$email,$nombre_usuario, $contra_encrip, $id_tipo_usuario));
        
        header("Location: index.php");
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
    <br>
    <form  method ='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <fieldset>
            <h2>Crear Usuario</h2>
                <div>
                    <input type="text" id="nombre" name="nombre"  placeholder="Nombre completo" class="form-control" autocomplete="off" maxlength="50">
                </div>
                <br>
                <div>
                    <input type="email" id="email" name="email"  placeholder="Correo Electronico" class="form-control" autocomplete="off" maxlength="20">
                </div>
                <br>
                <div>
                    <input type="text" id="username" name="username"  placeholder="Usuario" class="form-control" autocomplete="off" maxlength="20">
                </div>
                <br>
                <div>
                    <input type="password" id="contra" name="contra" placeholder="Contraseña" class="form-control" autocomplete="off" maxlength="20">
                </div>
                <br>
                <div>
                    <input type="password" id="contra2" name="contra2" placeholder="Contraseña" class="form-control" autocomplete="off" maxlength="20">
                </div>
                <br>
                <div>
                    <button type='submit'>Crear</button>
                </div>
            </fieldset>
        </form>
</body>
<footer>
</footer>
</html>