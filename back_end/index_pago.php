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
    $cuentaError = null;

    $nombre= $_POST['nombre'];
    $cuenta= strtoupper($_POST['cuenta']);

    // validate input
    $valid = true;
    if(empty($nombre)) {
        $nombreError = "Por favor ingrese el nombre de la nueva cuenta";
        $valid = false;
    }
    if(empty($cuenta)) {
        $cuentaError = "Por favor ingrese el numero de la nueva cuenta ";
        $valid = false;
    }
    // insert data
    if ($valid) {

        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO tipo_pago(nombre,cuenta) values(?,?)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($nombre,$cuenta));
        header("Location: index_pago.php");
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
            <h2>Nueva Formas de Pago</h2>
                <div>
                    <input type="text" id="nombre" name="nombre"  placeholder="Nombre" class="form-control" autocomplete="off" maxlength="50">
                </div>
                <br>
                <div>
                    <input type="text" style="text-transform:uppercase;" id="cuenta" name="cuenta"  placeholder="Cuenta" class="form-control" autocomplete="off" maxlength="50">
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
                <form name="form1" method="GET" action = "index_pago.php" id="cdr">
                    <h2>Buscar Forma de Pago</h2>
                    <h4>Por nombre de forma de pago</h4>
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
                <th>cuenta</th>
                <th>Accion</th>
            </tr>
            <tbody>
            <?php
            if (isset($_GET['buscar']))
                {
                    $buscar = $_GET['buscar'];
                    $sql = "SELECT id_tipo_pago, nombre, cuenta
                            FROM   tipo_pago 
                            WHERE  nombre like '%".$buscar."%'";
                }
                else {
                    $sql = 'SELECT  id_tipo_pago, nombre, cuenta
                            FROM    tipo_pago 
                            ORDER BY id_tipo_pago DESC';
                }
                $data = "";
                foreach($PDO->query($sql) as $row) {
                    
                    $data .= "<tr>";
                    $data .= "<td>$row[id_tipo_pago]</td>";
                    $data .= "<td>$row[nombre]</td>";
                    $data .= "<td>$row[cuenta]</td>";
                    $data .= "<td>";                  
                    $data .= "<a href='modificar_pago.php?id_tipo_pago=$row[id_tipo_pago]'>ACTUALIZAR</a>&nbsp;";
                    $data .= "<a href='eliminar_pago.php?id_tipo_pago=$row[id_tipo_pago]'>ELIMINAR</a>";
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