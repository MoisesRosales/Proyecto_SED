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
        $sql = "SELECT id_tipo_usuario FROM tipo_usuario WHERE nombre = ?";
        $stmt =$PDO->prepare($sql);
        $stmt->execute(array($cliente));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) {
            //Almacenamos el id que pertenece al tipo cliente
            $id_tipo_usuario = $data['id_tipo_usuario'];
        }
    }
    else{
        $id_tipo_usuario = $_POST['id_tipo_usuario'];
        if(empty($id_tipo_usuario)) {
            $id_tipo_usuarioError = "Por favor seleccione el tipo de usuario.";
            $valid = false;
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
        
        header("Location: index_usuario.php");
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
            <h2>Nuevo Usuario</h2>
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
                <label for='id_tipo_usuario'>Tipo de usuario</label>
                <select name='id_tipo_usuario' required='required' id='id_tipo_usuario'>
                    <?php
                    $sql="SELECT id_tipo_usuario, nombre_tipo_usuario FROM tipo_usuario";
                    foreach ($PDO->query($sql) as $row) {
                        echo "<option value ='$row[id_tipo_usuario]'";
                        if (isset($id_tipo_usuario) && $id_tipo_usuario == $row["id_tipo_usuario"])
                        {
                            echo " selected";
                        }
                        echo ">";
                        echo $row["nombre_tipo_usuario"];
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>
                <br>
                <div>
                    <button type='submit'>Crear</button>
                </div>
            </fieldset>
        </form>
        <br>
        <fieldset>
        <aside>
            <div>
                <form name="form1" method="GET" action = "index_usuario.php" id="cdr">
                    <h2>Buscar usuario</h2>
                    <h4>Por nombre de usuario</h4>
                    <div>
                        <input name="buscar" type="text" id="busqueda" placeholder="Busqueda" autocomplete="off" maxlength="50">
                        <span >
                            <button type="submit" name="submit" value="Buscar">Buscar</button>
                        </span>
                    </div>
                </form>
            </div>
        </aside>
        <br>
    </section><!--/#registration-->
        <table>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Tipo de usuario</th>
                <th>Accion</th>
            </tr>
            <tbody>
            <?php
            if (isset($_GET['buscar']))
                {
                    $buscar = $_GET['buscar'];
                    $sql = "SELECT  id_usuario, nombre, correo, username, usuario.id_tipo_usuario, 
                                    tipo_usuario.id_tipo_usuario, nombre_tipo_usuario 
                            FROM usuario, tipo_usuario 
                            WHERE usuario.id_tipo_usuario = tipo_usuario.id_tipo_usuario 
                            AND nombre like '%".$buscar."%'";
                }
                else {
                    $sql = 'SELECT  id_usuario, nombre, correo, username, usuario.id_tipo_usuario, 
                                    tipo_usuario.id_tipo_usuario, nombre_tipo_usuario
                            FROM usuario, tipo_usuario 
                            WHERE usuario.id_tipo_usuario = tipo_usuario.id_tipo_usuario
                            ORDER BY id_usuario';
                }
                $data = "";
                foreach($PDO->query($sql) as $row) {
                    
                    $data .= "<tr>";
                    $data .= "<td>$row[id_usuario]</td>";
                    $data .= "<td>$row[nombre]</td>";
                    $data .= "<td>$row[correo]</td>";
                    $data .= "<td>$row[username]</td>";
                    $data .= "<td>$row[nombre_tipo_usuario]</td>";
                    $data .= "<td>";                  
                    $data .= "<a class='btn btn-xs btn-primary' href='modificar_usuario.php?id_usuario=$row[id_usuario]'>ACTUALIZAR</a>&nbsp;";
                    $data .= "<a class='btn btn-xs btn-danger' href='eliminar_usuario.php?id_usuario=$row[id_usuario]'>ELIMINAR</a>";
                    $data .= "</td>";
                    $data .= "</tr>";
                }
                print($data);
                $PDO = null;
            ?>
            </tbody>
        </table>
    </section>
        </fieldset>
</body>
<footer>
</footer>
</html>