<?php
$servername = "localhost";
$database = "netflips";
$username = "moises";
$password = "0C4A830498F54855763F85076B5651C54F6D324EACE5C3EDB7C48A72CF9280FB";
// Create connection
try{
    $PDO = new PDO("mysql:host=".$servername."; "."dbname=".$database, $username, $password);
    //echo "Connected successfully";
}
catch(PDOException $e){
    die($e->getMessage());
}
//DEFINICION DEL PROYECTO

/*
21. Distribución: Fedora, Lenguaje: PHP, Base de Datos: MariaDB | Enunciado: Usted
ahora trabaja para una nueva plataforma de streaming llamada Netflips, se le ha
solicitado crear la base de su sistema de suscripción (puede ser mensual, semestral o
anual) para llevar un control de sus clientes así como sus formas de pago de la
suscripción y el tipo de servicio que pagan.
*/ 
?>
