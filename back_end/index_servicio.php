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
    $costoError = null;
    $descripcionError = null;

    $nombre= $_POST['nombre'];
    $costo= $_POST['costo'];
    $descripcion = $_POST['descripcion'];
    // validate input
    $valid = true;
    if(empty($nombre)) {
        $nombreError = "Por favor ingrese el nombre del nuevo servicio";
        $valid = false;
    }
    if(empty($costo)) {
        $costoError = "Por favor ingrese el costo del nuevo servicio";
        $valid = false;
    }
    if(empty($descripcion)) {
        $descripcionError = "Por favor ingrese la descripcion.";
        $valid = false;
    }
    // insert data
    if ($valid) {

        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO servicio(nombre,descripcion,costo) values(?,?,?)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($nombre,$descripcion,$costo));
        header("Location: index_servicio.php");
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
            <h2>Nuevo Servicio</h2>
                <div>
                    <input type="text" id="nombre" name="nombre"  placeholder="Nombre" class="form-control" autocomplete="off" maxlength="50">
                </div>
                <br>
                <div>
                    <input type="number" step="any" id="costo" name="costo"  placeholder="Costo" class="form-control" autocomplete="off" maxlength="50">
                </div>
                <br>
                <div>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50"  placeholder="Descripcion"></textarea>
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
                <form name="form1" method="GET" action = "index_servicio.php" id="cdr">
                    <h2>Buscar Servicio</h2>
                    <h4>Por nombre de Servicio</h4>
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
                <th>Costo</th>
                <th>Descripcion</th>
                <th>Accion</th>
            </tr>
            <tbody>
            <?php
            if (isset($_GET['buscar']))
                {
                    $buscar = $_GET['buscar'];
                    $sql = "SELECT id_servicio, nombre, descripcion, costo
                            FROM   servicio 
                            WHERE  nombre like '%".$buscar."%'";
                }
                else {
                    $sql = 'SELECT  id_servicio, nombre, descripcion, costo
                            FROM    servicio 
                            ORDER BY id_servicio DESC';
                }
                $data = "";
                foreach($PDO->query($sql) as $row) {
                    
                    $data .= "<tr>";
                    $data .= "<td>$row[id_servicio]</td>";
                    $data .= "<td>$row[nombre]</td>";
                    $data .= "<td>$row[costo]</td>";
                    $data .= "<td>$row[descripcion]</td>";
                    $data .= "<td>";                  
                    $data .= "<a href='modificar_servicio.php?id_servicio=$row[id_servicio]'>ACTUALIZAR</a>&nbsp;";
                    $data .= "<a href='eliminar_servicio.php?id_servicio=$row[id_servicio]'>ELIMINAR</a>";
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