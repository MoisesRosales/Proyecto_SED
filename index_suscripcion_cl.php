<?php
    require("netflips.php");
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header('location: login.php');
    exit();
    }
    if($_SESSION['nombre_tipo_usuario'] != "cliente"){
        header('location:back_end/index_back.php');
        exit();
    }
?>
<?php
    if(!empty($_POST)) {

    // validation errors
    $tipo_suscripcionError = null;
    $fecha_iError = null;
    $id_usuarioError = null;
    $id_servicioError = null;
    $id_tipo_pagoError = null;

    $tipo_suscripcion= $_POST['tipo_suscripcion'];
    $fecha_i = date("Y-m-d");
    $id_usuario = $_SESSION['id_usuario'];
    $id_servicio = $_POST['id_servicio'];
    $id_tipo_pago = $_POST['id_tipo_pago'];
    
    // validate input
    $valid = true;

    if(empty($tipo_suscripcion)) {
        $tipo_suscripcionError = "Por favor ingrese un tipo de suscripcion";

    }
    if(empty($fecha_i)) {
        $fecha_iError = "Error en la fecha del sistema";
        $valid = false;
    }
    if(empty($id_usuario)) {
        $id_usuarioError = "Por favor ingrese un usuario";
        $valid = false;
    }
    if(empty($id_servicio)) {
        $id_servicioError = "Por favor ingrese un servicio.";
        $valid = false;
    }
    if(empty($id_tipo_pago)) {
        $id_tipo_pagoError = "Por favor ingrese una forma de pago.";
        $valid = false;
    }
    // insert data
    if ($valid) {
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO suscripcion(tipo_suscripcion,fecha_inicio,id_usuario, id_servicio, id_tipo_pago) values(?,?,?,?,?)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($tipo_suscripcion,$fecha_i,$id_usuario, $id_servicio, $id_tipo_pago));
        
        header("Location: index_cl.php");
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
        <a href='index_suscripcion_cl.php'>Suscripcion</a>
        <a href="salir.php">Salir</a>
    </nav>
    <br>
    <form  method ='POST'>
            <fieldset>
            <h2>Nueva Suscripcion</h2>
            <div>
                <label for='tipo_suscripcion'>Tipo de Suscripcion</label>
                <select name='tipo_suscripcion' required='required' id='tipo_suscripcion'>
                   <option value="mensual">Mensual</option>
                   <option value="semestral">Semestral</option>
                   <option value="anual">Anual</option>
                </select>
            </div>
            <br>
                <div>
                <label for='fecha_i'>Inicio de la suscripcion</label>
                    <input type="datetime" name="fecha_i" id="fecha_i" value="<?php echo date("Y-m-d");?>" readonly>
                </div>
                <br>
                <div>
                    <label for='id_usuario'>usuario</label>
                    <input name='id_usuario' required='required' id='id_usuario' value="<?php echo $_SESSION['username'];?>" readonly></input>
                </div>
                <br>
                <div>
                    <label for='id_servicio'>Servicio</label>
                    <select name='id_servicio' required='required' id='id_servicio'>
                        <?php
                        $sql="SELECT id_servicio, nombre, costo FROM servicio";
                        foreach ($PDO->query($sql) as $row) {
                            echo "<option value ='$row[id_servicio]'";
                            if (isset($id_servicio) && $id_servicio == $row["id_servicio"])
                            {
                                echo " selected";
                            }
                            echo ">";
                            echo $row["nombre"]. "-Precio-$". $row["costo"];
                            echo "</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <div>
                    <label for='id_tipo_pago'>Forma de pago</label>
                    <select name='id_tipo_pago' required='required' id='id_tipo_pago'>
                        <?php
                        $sql="SELECT id_tipo_pago, nombre FROM tipo_pago";
                        foreach ($PDO->query($sql) as $row) {
                            echo "<option value ='$row[id_tipo_pago]'";
                            if (isset($id_tipo_pago) && $id_tipo_pago == $row["id_tipo_pago"])
                            {
                                echo " selected";
                            }
                            echo ">";
                            echo $row["nombre"] ;
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
</body>
<footer>
</footer>
</html>