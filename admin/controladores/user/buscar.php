<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'admin') {
    header("Location: ../usuario/index.php");
}
include '../../../config/conexionBD.php';

if ($_GET != '') {

    $sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj.usu_remitente AND 
    msj.usu_destino=" . $_SESSION['codigo'] . " AND
    usu.usu_correo LIKE '" . $_GET['key'] . "%';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["mail_fecha"] . "</td>";
            echo "<td>" . $row["usu_correo"] . "</td>";
            echo "<td>" . $row["mail_asunto"] . "</td>";
            echo '<td><a href="#">Leer</a></td>';
        }
    } else {
        echo "<tr>";
        echo '<td colspan="10" ><p>No hay resultados...</p></td>';
        echo "</tr>";
    }
} else {
    $sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj.usu_remitente AND 
                    msj.usu_destino=" . $_SESSION['codigo'] . ";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["mail_fecha"] . "</td>";
            echo "<td>" . $row["usu_correo"] . "</td>";
            echo "<td>" . $row["mail_asunto"] . "</td>";
            echo '<td><a href="#">Leer</a></td>';
        }
    } else {
        echo "<tr>";
        echo '<td colspan="10" "><p>No tienes mensajes recibidos</p></td>';
        echo "</tr>";
    }
}
$conn->close();
