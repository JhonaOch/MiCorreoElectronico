<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'admin') {
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
  
    <title>Mi cuenta</title>
</head>

<body>

<header>
        <h1>Gestion de usuarios</h1>
        <div>
            <nav>
                <ul>
                <li><a href="index.php">Inicio</a></li>
                    <li><a href="nuevoemail.php">Nuevo Mensaje</a></li>
                    <li><a href="enviarmensaje.php">Enviados</a></li>
                    <li><a href="micuenta.php">Mi cuenta</a></li>
                  
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

    <h2>Mi Cuenta</h2>

    <div id="contenido">
        
        <section>
            <table>
                <thead>
                    <tr>
                        <td>Cedula</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Direccion</td>
                        <td>Email</td>
                        <td>Telefono</td>
                        <td>Fecha Nacimiento</td>
                        <td>Foto</td>
                        <td>Eliminar</td>
                        <td>Modificar</td>
                        <td>Cambiar contraseña</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../../../config/conexionBD.php';
                    $sql = "SELECT * FROM usuario WHERE usu_codigo=" . $_SESSION['codigo'] . ";";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<tr>";
                        echo "<td>" . $row["usu_cedula"] . "</td>";
                        echo "<td>" . $row["usu_nombres"] . "</td>";
                        echo "<td>" . $row["usu_apellidos"] . "</td>";
                        echo "<td>" . $row["usu_direccion"] . "</td>";
                        echo "<td>" . $row["usu_correo"] . "</td>";
                        echo "<td>" . $row["usu_telefono"] . "</td>";
                        echo "<td>" . $row["usu_fecha_nacimiento"] . "</td>";
                        echo '<td><img src="../../../img/fotos/' . $row["usu_codigo"] . '/' . $row["usu_img"] . '" alt=""></td>';
                        if ((string)$row["usu_eliminado"] === 'N') {
                            echo '<td><a href="../../controladores/admin/BorrarUser.php?usu_cod=' . $row["usu_codigo"] . '&delete=' . true . '">Eliminar</a></td>';
                        } else {
                            echo '<td><a href="../../controladores/admin/BorrarUser.php?usu_cod=' . $row["usu_codigo"] . '">Activar</a></td>';
                        }
                        $user = serialize($row);
                        $user = urlencode($user);
                        echo '<td><a href="ModificarUser.php?user=' . $user . '">Modificar</a></td>';
                        echo '<td><a href="CambiarContra.php?usu_cod=' . $row["usu_codigo"] . '">Cambiar contraseña</a></td>';
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                        echo '<td colspan="10"><p>No existen usuarios registrados en el sistema</p></td>';
                        echo "</tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <?php
            $cod = isset($_GET["delete"]) ? trim($_GET["delete"]) : null;
            if ($cod == true) {
                echo "<p>Usuario eliminado</p>";
            }
            ?>
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