<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'user') {
    header("Location: ../usuario/index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../public/vista/Archivos/indexAd.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/Tabla.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/imagen.css">
</head>

<body>
    <header>
        <h1>Gestion de usuarios</h1>
        <div>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="UsuariosTabla.php">Usuarios</a></li>
                    <li><a href="micuenta.php">Mi cuenta</a></li>
                    <li><a href="../../../config/sesionfinal.php">Salir</a></li>
                   
                </ul>
                  <div class="user">
                    <div class="userImg">
                        <div class="imagen">
                            <img src="<?php echo ('../../../img/fotos/' . $_SESSION["codigo"] . '/' . $_SESSION["img"]) ?>" alt="">
                        </div>
                        <p><span><?php echo ($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) ?></span></p>
                    </div>
            </nav>
    </header>

    <h2>Mensajes Electronicos</h2>

    <div id="contenido">
        <section>
            <br>
            <br>
            <br>
            
                
                <table>
                    <thead>
                        <tr>
                            <td>Fecha</td>
                            <td>Remitente</td>
                            <td>Destino</td>
                            <td>Asunto</td>
                            <td></td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        include '../../../config/conexionBD.php';

                        $sql = "SELECT * FROM mensaje INNER JOIN usuario ON mensaje.usu_destino = usuario.usu_codigo ORDER BY 1;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["mail_fecha"] . "</td>";
                                $sqlRemitente = "SELECT usu_correo FROM usuario WHERE usu_codigo=" . $row["usu_remitente"] . ";";
                                $resultRemitente = $conn->query($sqlRemitente);
                                $rowRemitente = $resultRemitente->fetch_assoc();
                                echo "<td>" . $rowRemitente["usu_correo"] . "</td>";
                                $sqlDestino = "SELECT usu_correo FROM usuario WHERE usu_codigo=" . $row["usu_destino"] . ";";
                                $sqlDestino = $conn->query($sqlDestino);
                                $rowDestino = $sqlDestino->fetch_assoc();
                                echo "<td>" . $rowDestino["usu_correo"] . "</td>";
                                echo "<td>" . $row["mail_asunto"] . "</td>";
                                echo '<td><a href="../../controladores/admin/eliminarMSJ.php?usu_cod=' . $row["mail_codigo"] . '">Eliminar</a></td>';
                            }
                        } else {
                            echo "<tr>";
                            echo '<td colspan="10" ><p>No tienes mensajes recibidos</p></td>';
                            echo "</tr>";
                        }
                        $conn->close();
                        ?>

                    </tbody>
                </table>
           

        </section>
    </div>
    <footer>

        <small><strong>
                &#169; Todos los derechos reservados
                <br>Jonnathan Enrique Ochoa Calderon
                <br>Universidad Politecnica Salesiana
                <br>08-05-2019
            </strong>
        </small>

    </footer>
</body>

</html>